<div class="-mx-4 -mt-4 -mb-24 md:m-0 h-[calc(100dvh-4rem)] md:h-[calc(100vh-4rem)] flex flex-col">
    <div class="bg-white overflow-hidden shadow-sm md:rounded-2xl flex flex-1 md:border border-gray-200" x-data>
        <!-- Sidebar -->
        <div class="w-full md:w-1/3 md:border-r border-gray-200 bg-gray-50 flex-col" :class="$wire.activeProposalId ? 'hidden md:flex' : 'flex'">
            <div class="p-4 border-b border-gray-200 bg-white">
                <h2 class="text-lg font-semibold text-gray-800">Pesan & Negosiasi</h2>
            </div>
            
            <div class="overflow-y-auto flex-1 p-2 space-y-1">
                @forelse($this->conversations as $conversation)
                    @php
                        $isMeUMKM = $conversation->company_id === auth()->user()->company->id;
                        $otherPartyName = $isMeUMKM ? $conversation->project->company->name : $conversation->company->name;
                    @endphp
                    <button 
                        wire:key="conv-{{ $conversation->id }}"
                        wire:click="selectConversation({{ $conversation->id }})"
                        x-on:click="$wire.activeProposalId = {{ $conversation->id }}"
                        class="w-full text-left p-3 rounded-lg flex flex-col gap-1 transition-colors border border-transparent"
                        :class="$wire.activeProposalId == {{ $conversation->id }} ? 'bg-blue-50 border-blue-200' : 'hover:bg-gray-100'"
                    >
                        <div class="flex justify-between items-center w-full">
                            <span class="font-medium text-sm text-gray-900 truncate flex items-center gap-2">
                                {{ $otherPartyName }}
                                @if($conversation->unread_count > 0)
                                    <span class="bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full flex items-center justify-center min-w-[1.25rem]">
                                        {{ $conversation->unread_count }}
                                    </span>
                                @endif
                            </span>
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

        <div class="w-full md:w-2/3 flex-col bg-white relative" :class="$wire.activeProposalId ? 'flex' : 'hidden md:flex'">
             
            <!-- Absolute Full-Pane Skeleton Loader Overlay -->
            <div wire:loading.flex wire:target="selectConversation" class="absolute inset-0 bg-slate-50 z-20 flex-col" style="display: none;">
                <!-- Fake Header -->
                <div class="p-4 border-b border-gray-200 bg-white flex items-center gap-3 shrink-0">
                    <div class="w-10 h-10 rounded-full bg-slate-200 animate-pulse border border-slate-300"></div>
                    <div class="flex-col gap-2 flex justify-center">
                        <div class="w-32 h-4 bg-slate-200 animate-pulse rounded"></div>
                        <div class="w-24 h-3 bg-slate-200 animate-pulse rounded"></div>
                    </div>
                </div>
                <!-- Fake Messages -->
                <div class="flex-1 p-4 flex flex-col-reverse gap-4 overflow-hidden">
                    <div class="flex justify-start">
                        <div class="w-2/3 h-12 bg-slate-200 animate-pulse rounded-2xl rounded-tl-sm border border-slate-100"></div>
                    </div>
                    <div class="flex justify-end">
                        <div class="w-1/2 h-16 bg-blue-100 animate-pulse rounded-2xl rounded-tr-sm border border-blue-50/50"></div>
                    </div>
                    <div class="flex justify-start">
                        <div class="w-3/4 h-24 bg-slate-200 animate-pulse rounded-2xl rounded-tl-sm border border-slate-100"></div>
                    </div>
                </div>
                <!-- Fake Input -->
                <div class="p-4 border-t border-gray-200 bg-white shrink-0">
                    <div class="w-full h-10 rounded-full bg-slate-200 animate-pulse"></div>
                </div>
            </div>

            @if($this->activeProposalId)
                <!-- Header for active chat -->
                <div class="p-4 flex items-center justify-between border-b border-gray-200 shrink-0">
                    <div class="flex items-center gap-3">
                        <button x-on:click="$wire.activeProposalId = null" class="md:hidden text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors -ml-2 shrink-0">
                            <i class="ph ph-caret-left text-xl"></i>
                        </button>
                        
                        @if($this->activeConversation)
                            @php
                                $isMeUMKM = $this->activeConversation->company_id === auth()->user()->company->id;
                                $otherPartyName = $isMeUMKM ? $this->activeConversation->project->company->name : $this->activeConversation->company->name;
                                $otherPartyId = $isMeUMKM ? $this->activeConversation->project->company->id : $this->activeConversation->company->id;
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center shrink-0 border border-slate-300">
                                    <i class="ph ph-buildings text-slate-500 text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <a href="{{ route('vendor.show', $otherPartyId) }}" target="_blank" class="font-semibold text-slate-800 hover:text-blue-600 transition-colors leading-tight truncate max-w-[200px] md:max-w-md">
                                        {{ $otherPartyName }}
                                    </a>
                                    <span class="text-xs text-slate-500 truncate max-w-[200px] md:max-w-md">Proyek: {{ $this->activeConversation->project->title }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Messages container -->
                <div class="flex-1 overflow-hidden bg-slate-50 relative">
                    <div class="absolute inset-0 overflow-y-auto p-4 flex flex-col-reverse gap-4">
                        
                        <!-- Optimistic Loading Bubble -->
                        <div class="flex justify-end" wire:loading.flex wire:target="sendMessage" style="display: none;">
                            <div class="max-w-[75%] rounded-2xl px-4 py-2 bg-blue-500 text-white rounded-tr-sm opacity-70">
                                <p class="text-sm whitespace-pre-wrap" x-text="$wire.messageBody"></p>
                                <span class="text-[10px] mt-1 flex items-center justify-end gap-1 text-blue-200">
                                    <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Mengirim...
                                </span>
                            </div>
                        </div>

                        @forelse($this->messages as $index => $msg)
                            @php
                                $msgDate = $msg->created_at->format('Y-m-d');
                                $nextMsg = $this->messages[$index + 1] ?? null;
                                $nextMsgDate = $nextMsg ? $nextMsg->created_at->format('Y-m-d') : null;
                                
                                $showDate = ($msgDate !== $nextMsgDate);
                                $isMyMessage = $msg->company_id === auth()->user()->company->id;
                            @endphp

                            <div wire:key="msg-{{ $msg->id }}" class="flex {{ $isMyMessage ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[75%] rounded-2xl px-4 py-2 {{ $isMyMessage ? 'bg-blue-600 text-white rounded-tr-sm' : 'bg-white border border-gray-200 text-gray-800 rounded-tl-sm shadow-sm' }}">
                                    <p class="text-sm whitespace-pre-wrap">{{ $msg->body }}</p>
                                    <span class="text-[10px] mt-1 block {{ $isMyMessage ? 'text-right text-blue-200' : 'text-left text-gray-400' }}">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if(!$isMyMessage && !$msg->is_read)
                                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-500 ml-1"></span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @if($showDate)
                                <div wire:key="date-{{ $msg->id }}" class="flex justify-center my-4">
                                    <span class="text-[10px] px-3 py-1 bg-gray-200 text-gray-600 rounded-full font-medium shadow-sm">
                                        {{ $msg->created_at->isToday() ? 'Hari Ini' : ($msg->created_at->isYesterday() ? 'Kemarin' : $msg->created_at->translatedFormat('d F Y')) }}
                                    </span>
                                </div>
                            @endif
                        @empty
                            <div class="flex items-center justify-center h-full pb-10">
                                <div class="text-center text-gray-500 text-sm">
                                    <i class="ph ph-chat-circle text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada pesan. Mulai diskusi sekarang!</p>
                                </div>
                            </div>
                        @endforelse
                        
                        @if($this->messages->count() >= $this->messagesLimit)
                            <div class="flex justify-center my-4">
                                <button wire:click="loadMoreMessages" class="text-[10px] px-4 py-1.5 bg-white border border-blue-200 text-blue-600 hover:text-white rounded-full font-semibold shadow-sm hover:bg-blue-600 transition-colors" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="loadMoreMessages">Muat Pesan Sebelumnya</span>
                                    <span wire:loading wire:target="loadMoreMessages">Memuat...</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Input Area -->
                <div class="p-4 border-t border-gray-200 bg-white shrink-0">
                    @if($this->activeConversation)
                        @if($this->activeConversation->status === 'negotiating')
                            <form wire:submit="sendMessage" class="flex gap-2">
                                <input 
                                    type="text" 
                                    wire:model="messageBody"
                                    placeholder="Ketik pesan..." 
                                    class="flex-1 rounded-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 shadow-sm text-sm disabled:opacity-50 disabled:bg-gray-100"
                                    required
                                    wire:loading.attr="disabled"
                                    wire:target="selectConversation"
                                >
                                <button 
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2.5 h-10 w-10 flex items-center justify-center transition-colors shadow-sm shrink-0 disabled:opacity-50"
                                    wire:loading.attr="disabled"
                                    wire:target="sendMessage, selectConversation"
                                >
                                    <svg class="w-5 h-5 ml-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                                </button>
                            </form>
                        @elseif(in_array($this->activeConversation->status, ['accepted', 'rejected']))
                            <div class="text-center p-2 rounded-lg bg-gray-50 border border-gray-200 text-sm text-gray-600">
                                <i class="ph ph-lock-key mr-1"></i>
                                Percakapan dikunci karena negosiasi telah selesai.
                            </div>
                        @endif
                    @endif
                </div>
            @else
                <!-- Empty State Desktop -->
                <div class="hidden md:flex flex-1 items-center justify-center bg-slate-50">
                    <div class="text-center max-w-sm px-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-200">
                            <i class="ph ph-chat-teardrop-dots text-3xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pilih Percakapan</h3>
                        <p class="text-gray-500 text-sm">Pilih salah satu proyek di samping untuk mulai berdiskusi dan bernegosiasi.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
