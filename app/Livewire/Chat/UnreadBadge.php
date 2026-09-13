<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use Livewire\Attributes\On;

class UnreadBadge extends Component
{
    public $hasUnread = false;
    public $isMobile = false;

    public function mount($isMobile = false)
    {
        $this->isMobile = $isMobile;
        $this->checkUnread();
    }

    #[On('refresh-unread-badge')]
    public function checkUnread()
    {
        $user = auth()->user();
        if (!$user || !$user->company) {
            $this->hasUnread = false;
            return;
        }

        $companyId = $user->company->id;
        
        $this->hasUnread = Message::where('company_id', '!=', $companyId)
            ->where('is_read', 'false')
            ->whereHas('proposal', function($q) use ($companyId) {
                $q->where('company_id', $companyId)
                  ->orWhereHas('project', function($p) use ($companyId) {
                      $p->where('company_id', $companyId);
                  });
            })->exists();
    }

    public function render()
    {
        return view('livewire.chat.unread-badge');
    }
}
