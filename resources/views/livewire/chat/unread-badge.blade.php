<div class="absolute inset-0 pointer-events-none">
    @if($hasUnread)
        @if($isMobile)
            <span class="absolute top-0 -right-1 w-2.5 h-2.5 bg-blue-500 border-[1.5px] border-white rounded-full"></span>
        @else
            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-blue-500 border-[1.5px] border-white rounded-full"></span>
        @endif
    @endif
</div>
