<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Proposal;
use App\Models\Message;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

#[Layout('layouts.dashboard')]
class MessagesIndex extends Component
{
    #[Url(as: 'proposal_id', history: true)]
    public $activeProposalId = null;

    public $searchQuery = '';
    public $messageBody = '';
    public $messagesLimit = 50;
    public $authUserId = null;

    public function mount()
    {
        $this->authUserId = auth()->id();
    }

    #[Computed]
    public function conversations()
    {
        $companyId = auth()->user()->company->id;
        $query = trim($this->searchQuery);
        
        return Proposal::with(['project.company', 'company'])
            ->withCount(['messages as unread_count' => function($q) use ($companyId) {
                $q->where('is_read', 'false')
                  ->where('company_id', '!=', $companyId);
            }])
            ->where(function ($q) use ($companyId) {
                $q->where('company_id', $companyId)
                  ->orWhereHas('project', function ($q) use ($companyId) {
                      $q->where('company_id', $companyId);
                  });
            })
            ->whereIn('status', ['negotiating', 'accepted', 'rejected'])
            ->when($query, function ($q) use ($query, $companyId) {
                $q->where(function ($sub) use ($query, $companyId) {
                    $sub->whereHas('project', function ($p) use ($query) {
                        $p->where('title', 'ilike', '%' . $query . '%');
                    })
                    ->orWhereHas('company', function ($c) use ($query, $companyId) {
                        $c->where('id', '!=', $companyId)
                          ->where('name', 'ilike', '%' . $query . '%');
                    })
                    ->orWhereHas('project.company', function ($c) use ($query, $companyId) {
                        $c->where('id', '!=', $companyId)
                          ->where('name', 'ilike', '%' . $query . '%');
                    });
                });
            })
            ->latest('updated_at')
            ->get();
    }

    #[Computed]
    public function activeConversation()
    {
        if (!$this->activeProposalId) return null;
        
        return Proposal::with(['project.company', 'company'])
            ->find($this->activeProposalId);
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
    public $lastRenderedProposalId = null;

    public function selectConversation($proposalId)
    {
        $this->activeProposalId = $proposalId;
        $this->messagesLimit = 50;
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
            'is_read' => 'false'
        ]);

        $this->messageBody = '';

        // Broadcast to others
        $message->load('sender');
        broadcast(new \App\Events\MessageSent($message))->toOthers();

        // Touch the proposal
        $proposal = Proposal::find($this->activeProposalId);
        $proposal->touch();
    }





    public function render()
    {
        if ($this->activeProposalId) {
            // Detect conversation change or fresh URL load
            if ($this->lastRenderedProposalId !== $this->activeProposalId) {
                $this->firstUnreadMessageId = null;
                $this->unreadMessagesCount = 0;
            }

            $myCompanyId = auth()->user()->company->id;
            
            $unreadQuery = Message::where('proposal_id', $this->activeProposalId)
                ->where('is_read', 'false')
                ->where('company_id', '!=', $myCompanyId);
                
            $unreadCount = $unreadQuery->count();

            if ($unreadCount > 0) {
                if (!$this->firstUnreadMessageId || $this->lastRenderedProposalId !== $this->activeProposalId) {
                    $this->firstUnreadMessageId = (clone $unreadQuery)->orderBy('created_at', 'asc')->value('id');
                    $this->unreadMessagesCount = $unreadCount;
                }

                $unreadQuery->update(['is_read' => 'true']);
                broadcast(new \App\Events\MessagesRead($this->activeProposalId))->toOthers();
            }

            $this->lastRenderedProposalId = $this->activeProposalId;
        }

        return view('livewire.chat.messages-index');
    }
}
