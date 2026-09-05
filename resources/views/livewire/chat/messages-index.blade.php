<div class="-mx-4 -mt-4 -mb-24 md:m-0 h-[calc(100dvh-4rem)] md:h-[calc(100vh-4rem)] flex flex-col">
    <div class="bg-white overflow-hidden shadow-sm md:rounded-2xl flex flex-1 md:border border-gray-200">
        <!-- Sidebar -->
        <div class="w-full md:w-1/3 md:border-r border-gray-200 flex-col bg-gray-50 {{ $this->activeConversation ? 'hidden md:flex' : 'flex' }}">
            <div class="p-4 border-b border-gray-200 bg-white">
                <h2 class="text-lg font-semibold text-gray-800">Pesan & Negosiasi</h2>
            </div>
            
            <div class="overflow-y-auto flex-1 p-2 space-y-1">
                @forelse($this->conversations as $conversation)
                    @php
                        $isMeUMKM = $conversation->company_id === auth()->user()->company->id;
                        $otherPartyName = $isMeUMKM ? $conversation->project->company->name : $conversation->company->name;
                        $isActive = $activeProposalId == $conversation->id;
                    @endphp
                    <button 
                        wire:click="selectConversation({{ $conversation->id }})"
                        class="w-full text-left p-3 rounded-lg flex flex-col gap-1 transition-colors {{ $isActive ? 'bg-blue-50 border border-blue-200' : 'hover:bg-gray-100 border border-transparent' }}"
                    >
                        <div class="flex justify-between items-center w-full">
                            <span class="font-medium text-sm text-gray-900 truncate">{{ $otherPartyName }}</span>
                            @if($conversation->status !== 'negotiating')
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-gray-200 text-gray-600 uppercase">{{ $conversation->status }}</span>
                            @endif
                        </div>
                        <span class="text-xs text-blue-600 font-medium truncate">{{ $conversation->project->title }}</span>
                    </button>
                @empty
                    <div class="p-4 text-center text-sm text-gray-500">
                        Belum ada percakapan negosiasi.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="w-full md:w-2/3 flex-col bg-white {{ $this->activeConversation ? 'flex' : 'hidden md:flex' }}">
            @if($this->activeConversation)
                @php
                    $isMeUMKM = $this->activeConversation->company_id === auth()->user()->company->id;
                    $otherPartyName = $isMeUMKM ? $this->activeConversation->project->company->name : $this->activeConversation->company->name;
                    $otherPartyAvatar = $isMeUMKM ? $this->activeConversation->project->company->logo : $this->activeConversation->company->logo;
                @endphp
                
                <!-- Chat Header -->
                <div class="p-4 border-b border-gray-200 bg-white flex items-center gap-3">
                    <button wire:click="$set('activeProposalId', null)" class="md:hidden text-gray-500 hover:text-gray-700 p-1 -ml-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                        @if($otherPartyAvatar)
                            <img src="{{ Storage::url($otherPartyAvatar) }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                <i class="ph ph-buildings text-xl"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $otherPartyName }}</h3>
                        <p class="text-xs text-gray-500">Proyek: {{ $this->activeConversation->project->title }}</p>
                    </div>
                </div>

                <!-- Messages container -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50">
                    @forelse($this->messages as $msg)
                        @php
                            $isMyMessage = $msg->company_id === auth()->user()->company->id;
                        @endphp
                        <div class="flex {{ $isMyMessage ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[75%] rounded-2xl px-4 py-2 {{ $isMyMessage ? 'bg-blue-600 text-white rounded-tr-sm' : 'bg-white border border-gray-200 text-gray-800 rounded-tl-sm shadow-sm' }}">
                                <p class="text-sm whitespace-pre-wrap">{{ $msg->body }}</p>
                                <span class="text-[10px] mt-1 block {{ $isMyMessage ? 'text-blue-200' : 'text-gray-400' }}">
                                    {{ $msg->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center text-gray-500 text-sm">
                                <i class="ph ph-chat-circle text-4xl mb-2 text-gray-300"></i>
                                <p>Belum ada pesan. Mulai diskusi sekarang!</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Input Area -->
                <div class="p-4 border-t border-gray-200 bg-white">
                    @if($this->activeConversation->status === 'negotiating')
                        <form wire:submit="sendMessage" class="flex gap-2">
                            <input 
                                type="text" 
                                wire:model="messageBody"
                                placeholder="Ketik pesan..." 
                                class="flex-1 rounded-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4"
                                autocomplete="off"
                            >
                            <button 
                                type="submit" 
                                class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors disabled:opacity-50"
                                wire:loading.attr="disabled"
                            >
                                <i class="ph ph-paper-plane-right text-lg"></i>
                            </button>
                        </form>
                    @else
                        <div class="text-center py-2 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                            Percakapan ini ditutup karena proposal telah {{ $this->activeConversation->status }}.
                        </div>
                    @endif
                </div>
            @else
                <!-- No Conversation Selected -->
                <div class="flex-1 flex flex-col items-center justify-center text-gray-400">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="ph ph-chats text-4xl text-gray-300"></i>
                    </div>
                    <p class="text-lg font-medium text-gray-600">Pilih Percakapan</p>
                    <p class="text-sm">Pilih proposal di sebelah kiri untuk mulai berdiskusi</p>
                </div>
            @endif
        </div>
    </div>
</div>
