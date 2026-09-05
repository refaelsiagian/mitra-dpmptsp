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

    public function mount()
    {
        $this->activeProposalId = request()->query('proposal_id');
    }

    public function getConversationsProperty()
    {
        $companyId = auth()->user()->company->id;
        
        return Proposal::with(['project', 'company', 'project.company'])
            ->whereIn('status', ['negotiating', 'accepted', 'rejected'])
            ->where(function($query) use ($companyId) {
                $query->where('company_id', $companyId)
                      ->orWhereHas('project', function($q) use ($companyId) {
                          $q->where('company_id', $companyId);
                      });
            })
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
            ->oldest()
            ->get();
    }

    public function selectConversation($proposalId)
    {
        $this->activeProposalId = $proposalId;
    }

    public function sendMessage()
    {
        if (trim($this->messageBody) === '' || !$this->activeConversation) {
            return;
        }
        
        if ($this->activeConversation->status !== 'negotiating') {
            return;
        }

        $message = Message::create([
            'proposal_id' => $this->activeProposalId,
            'company_id' => auth()->user()->company->id,
            'body' => trim($this->messageBody),
        ]);

        broadcast(new \App\Events\MessageSent($message))->toOthers();

        $this->messageBody = '';
        
        $this->activeConversation->touch();
    }

    #[On('echo-private:proposal.{activeProposalId},.MessageSent')]
    public function onMessageSent($event)
    {
        // Just trigger a re-render
    }

    public function render()
    {
        return view('livewire.chat.messages-index');
    }
}
