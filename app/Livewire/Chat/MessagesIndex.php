<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Proposal;
use App\Models\Message;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;

#[Layout('layouts.dashboard')]
class MessagesIndex extends Component
{
    public $activeProposalId = null;
    public $messageBody = '';
    public $messagesLimit = 50;

    public function mount()
    {
        $this->activeProposalId = request()->query('proposal_id');
    }

    #[Computed]
    public function conversations()
    {
        $companyId = auth()->user()->company->id;
        
        return Proposal::with(['project.company', 'company'])
            ->withCount(['messages as unread_count' => function($query) use ($companyId) {
                $query->where('is_read', 'false')
                      ->where('company_id', '!=', $companyId);
            }])
            ->where(function ($q) use ($companyId) {
                $q->where('company_id', $companyId)
                  ->orWhereHas('project', function ($q) use ($companyId) {
                      $q->where('company_id', $companyId);
                  });
            })
            ->whereIn('status', ['negotiating', 'accepted', 'rejected'])
            ->latest('updated_at')
            ->get();
    }

    #[Computed]
    public function activeConversation()
    {
        if (!$this->activeProposalId) return null;
        
        return $this->conversations->firstWhere('id', $this->activeProposalId);
    }

    #[Computed]
    public function messages()
    {
        if (!$this->activeProposalId) return collect();

        return Message::with('sender')
            ->where('proposal_id', $this->activeProposalId)
            ->latest()
            ->take($this->messagesLimit)
            ->get();
    }

    public $firstUnreadMessageId = null;
    public $unreadMessagesCount = 0;

    public function selectConversation($proposalId)
    {
        $this->activeProposalId = $proposalId;
        $this->messagesLimit = 50;
        
        $myCompanyId = auth()->user()->company->id;
        
        $unreadQuery = Message::where('proposal_id', $proposalId)
            ->where('is_read', 'false')
            ->where('company_id', '!=', $myCompanyId);
            
        $this->unreadMessagesCount = $unreadQuery->count();
        $this->firstUnreadMessageId = (clone $unreadQuery)->orderBy('created_at', 'asc')->value('id');

        // Mark all unread messages from the other party as read
        $unreadQuery->update(['is_read' => 'true']);
    }

    public function loadMoreMessages()
    {
        $this->messagesLimit += 50;
    }

    public function sendMessage()
    {
        if (trim($this->messageBody) === '' || !$this->activeProposalId) {
            return;
        }
        
        $proposal = Proposal::find($this->activeProposalId);
        
        if (!$proposal || $proposal->status !== 'negotiating') {
            return;
        }

        $message = Message::create([
            'proposal_id' => $this->activeProposalId,
            'company_id' => auth()->user()->company->id,
            'body' => trim($this->messageBody),
        ]);

        broadcast(new \App\Events\MessageSent($message))->toOthers();

        $this->messageBody = '';
        
        $proposal->touch();
    }

    public function pollChat()
    {
        // Dummy action to force Livewire to bypass state-change optimizations and re-render the view
    }

    public function render()
    {
        if ($this->activeProposalId) {
            // Automatically mark any incoming messages as read since the user is actively viewing this chat.
            // This runs before the view evaluates computed properties, preventing the sidebar counter from flashing.
            Message::where('proposal_id', $this->activeProposalId)
                ->where('is_read', 'false')
                ->where('company_id', '!=', auth()->user()->company->id)
                ->update(['is_read' => 'true']);
        }

        return view('livewire.chat.messages-index');
    }
}
