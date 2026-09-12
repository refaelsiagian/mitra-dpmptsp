<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Proposal;
use App\Models\Message;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

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

    public function getConversationsProperty()
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

    public function getActiveConversationProperty()
    {
        if (!$this->activeProposalId) return null;
        
        return $this->conversations->firstWhere('id', $this->activeProposalId);
    }

    public function getMessagesProperty()
    {
        if (!$this->activeProposalId) return collect();

        return Message::with('sender')
            ->where('proposal_id', $this->activeProposalId)
            ->latest()
            ->take($this->messagesLimit)
            ->get();
    }

    public function selectConversation($proposalId)
    {
        $this->activeProposalId = $proposalId;
        $this->messagesLimit = 50;
        
        // Mark all unread messages from the other party as read
        Message::where('proposal_id', $proposalId)
            ->where('is_read', 'false')
            ->where('company_id', '!=', auth()->user()->company->id)
            ->update(['is_read' => 'true']);
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

    public function render()
    {
        if ($this->activeProposalId) {
            Message::where('proposal_id', $this->activeProposalId)
                ->where('is_read', 'false')
                ->where('company_id', '!=', auth()->user()->company->id)
                ->update(['is_read' => 'true']);
        }
        
        return view('livewire.chat.messages-index');
    }
}
