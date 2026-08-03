<!-- Invite Modal Overlay -->
<div id="inviteModal" class="fixed inset-0 z-[100] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeInviteModal()"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full border border-slate-200">
            <!-- Header -->
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">
                    Undang ke Proyek Anda
                </h3>
                <button type="button" onclick="closeInviteModal()" class="bg-slate-50 rounded-md text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="px-6 py-5">
                <p class="text-sm text-slate-500 mb-4">
                    Pilih proyek atau pengadaan aktif Anda untuk mengundang vendor ini berpartisipasi.
                </p>
                
                <div class="space-y-3">
                    <!-- Option 1 -->
                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:border-blue-300 hover:bg-blue-50/30 transition-colors">
                        <input type="radio" name="project_id" value="1" class="peer sr-only" />
                        <div class="flex w-full items-center justify-between">
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p class="font-bold text-slate-900">Pembangunan Gedung Kantor Tahap 2 CBD</p>
                                    <div class="text-slate-500 mt-0.5">
                                        <p class="text-xs">Tender Aktif • Sisa Waktu: 5 Hari</p>
                                    </div>
                                </div>
                            </div>
                            <div class="shrink-0 text-blue-600 hidden peer-checked:block">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                        </div>
                        <div class="absolute -inset-px rounded-xl border-2 border-transparent peer-checked:border-blue-600 pointer-events-none"></div>
                    </label>

                    <!-- Option 2 -->
                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:border-blue-300 hover:bg-blue-50/30 transition-colors">
                        <input type="radio" name="project_id" value="2" class="peer sr-only" />
                        <div class="flex w-full items-center justify-between">
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p class="font-bold text-slate-900">Pengadaan Katering Karyawan Pabrik Cikarang</p>
                                    <div class="text-slate-500 mt-0.5">
                                        <p class="text-xs">KSO Aktif • Sisa Waktu: Terbuka</p>
                                    </div>
                                </div>
                            </div>
                            <div class="shrink-0 text-blue-600 hidden peer-checked:block">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                        </div>
                        <div class="absolute -inset-px rounded-xl border-2 border-transparent peer-checked:border-blue-600 pointer-events-none"></div>
                    </label>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-slate-200">
                <button type="button" onclick="closeInviteModal()" class="px-4 py-2 text-sm font-bold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Batal
                </button>
                <button type="button" onclick="submitInvite()" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Kirim Undangan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openInviteModal() {
        document.getElementById('inviteModal').classList.remove('hidden');
    }
    
    function closeInviteModal() {
        document.getElementById('inviteModal').classList.add('hidden');
    }

    function submitInvite() {
        // Find checked radio
        const selected = document.querySelector('input[name="project_id"]:checked');
        if(!selected) {
            alert('Pilih salah satu proyek terlebih dahulu!');
            return;
        }
        
        // Mock success
        alert('Undangan berhasil dikirim! Vendor akan menerima notifikasi dari Anda.');
        closeInviteModal();
        
        // Uncheck the selected radio for next time
        selected.checked = false;
    }
</script>
