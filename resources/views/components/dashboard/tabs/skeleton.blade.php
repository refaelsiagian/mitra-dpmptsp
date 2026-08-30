<div class="space-y-4 animate-pulse p-2">
    @for($i = 0; $i < 3; $i++)
    <div class="bg-slate-50/50 p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between gap-6">
            <div class="flex-1 space-y-4">
                <div class="flex gap-2">
                    <div class="h-6 bg-slate-200 rounded-md w-24"></div>
                    <div class="h-6 bg-slate-200 rounded-md w-16"></div>
                </div>
                <div class="h-6 bg-slate-200 rounded-lg w-3/4"></div>
                <div class="space-y-2">
                    <div class="h-4 bg-slate-200 rounded w-full"></div>
                    <div class="h-4 bg-slate-200 rounded w-5/6"></div>
                </div>
                <div class="pt-2 flex gap-3">
                    <div class="h-9 bg-slate-200 rounded-lg w-32"></div>
                    <div class="h-9 bg-slate-200 rounded-lg w-28"></div>
                </div>
            </div>
            
            <div class="w-full md:w-1/3 flex flex-col md:items-end justify-center md:border-l border-slate-100 md:pl-6 space-y-3">
                <div class="h-4 bg-slate-200 rounded w-20"></div>
                <div class="h-8 bg-slate-200 rounded w-32"></div>
                <div class="h-9 bg-slate-200 rounded-lg w-full max-w-[150px]"></div>
            </div>
        </div>
    </div>
    @endfor
</div>
