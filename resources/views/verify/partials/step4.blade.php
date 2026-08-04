                    <div id="step-4" class="p-6 sm:p-10 step-section hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <i class="ph ph-check-square-offset text-blue-600 text-3xl"></i> Konfirmasi Data
                        </h2>
                        <p class="text-gray-500 mb-6 text-sm">Pastikan semua data di bawah ini sudah benar sebelum Anda menyelesaikan registrasi.</p>
                        
                        <div class="space-y-6">
                            <!-- Profil Summary -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h3 class="font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2">Profil Usaha</h3>
                                <div class="grid grid-cols-2 gap-y-3 text-sm">
                                    <div class="text-gray-500">Nama Perusahaan</div>
                                    <div class="font-medium text-gray-900" id="summary-company-name">-</div>
                                    
                                    <div class="text-gray-500">Jenis Pelaku Usaha</div>
                                    <div class="font-medium text-gray-900" id="summary-jenis-usaha">-</div>
                                    
                                    <div class="text-gray-500">Kode KBLI</div>
                                    <div class="font-medium text-gray-900" id="summary-kode-kbli">-</div>
                                </div>
                            </div>
                            
                            <!-- Legalitas Summary -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h3 class="font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2">Legalitas & Pimpinan</h3>
                                <div class="grid grid-cols-2 gap-y-3 text-sm">
                                    <div class="text-gray-500">Penanggung Jawab</div>
                                    <div class="font-medium text-gray-900" id="summary-pimpinan">-</div>
                                    
                                    <div class="text-gray-500">Jabatan</div>
                                    <div class="font-medium text-gray-900" id="summary-jabatan">-</div>
                                    
                                    <div class="text-gray-500">Nomor NIB</div>
                                    <div class="font-medium text-gray-900" id="summary-nib">-</div>
                                    
                                    <div class="text-gray-500">Nomor NPWP</div>
                                    <div class="font-medium text-gray-900" id="summary-npwp">-</div>

                                    <div class="text-gray-500">Status PKP</div>
                                    <div class="font-medium text-gray-900" id="summary-pkp">-</div>
                                </div>
                            </div>
                            
                            <!-- Lokasi Summary -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h3 class="font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2">Informasi Lokasi</h3>
                                <div class="grid grid-cols-2 gap-y-3 text-sm">
                                    <div class="text-gray-500">Alamat Kantor Utama</div>
                                    <div class="font-medium text-gray-900" id="summary-alamat-kantor">-</div>
                                    
                                    <div class="text-gray-500">Alamat Lokasi Usaha</div>
                                    <div class="font-medium text-gray-900" id="summary-alamat-usaha">-</div>
                                </div>
                            </div>
                            
                            <!-- Alert/Disclaimer -->
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex gap-3 text-sm text-blue-800 mt-2">
                                <i class="ph ph-info mt-0.5 text-xl"></i>
                                <div>
                                    Dengan menekan tombol <strong>Kirim Data Verifikasi</strong>, saya menyatakan bahwa seluruh data dan dokumen yang dilampirkan adalah benar dan sah sesuai dengan peraturan yang berlaku.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center rounded-b-xl">
                        <button type="button" id="btn-prev" class="hidden px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <i class="ph ph-arrow-left"></i> Kembali
                        </button>
                        <div class="flex-grow" id="spacer"></div>
                        <button type="button" id="btn-next" class="px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors flex items-center gap-2 ml-auto">
                            Selanjutnya <i class="ph ph-arrow-right"></i>
                        </button>
                        <button type="submit" id="btn-submit" class="hidden px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 transition-colors flex items-center gap-2 ml-auto">
                            <i class="ph ph-check-circle text-lg"></i> Kirim Data Verifikasi
                        </button>
                    </div>

                </form>
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-500">
                &copy; 2026 DPMPTSP. Sistem Informasi Manajemen Mitra.
            </div>
            
        </div>
    </main>

    <!-- Map Picker Modal -->
    <div id="map-picker-modal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col h-[80vh] mx-4 relative z-50">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Pilih Titik Koordinat Usaha</h3>
                    <p class="text-sm text-gray-500">Geser peta atau klik pada lokasi untuk menentukan koordinat.</p>
                </div>
                <button type="button" id="btn-close-map" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="ph ph-x text-2xl"></i>
                </button>
            </div>
            <div class="flex-grow relative bg-gray-200">
                <div id="interactive-map" class="w-full h-full absolute inset-0 z-0"></div>
                <div class="absolute top-4 right-4 z-[400] bg-white px-3 py-2 rounded-lg shadow-md border border-gray-200 text-sm font-medium flex items-center gap-2">
                    <i class="ph ph-crosshair text-blue-600"></i>
                    <span id="temp-coordinate" class="font-mono text-gray-700">-</span>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-white flex justify-end items-center gap-3">
                <button type="button" id="btn-cancel-map" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Batal</button>
                <button type="button" id="btn-save-map" class="px-6 py-2 bg-blue-600 rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <i class="ph ph-check-circle text-lg"></i> Simpan Lokasi
                </button>
            </div>
        </div>
    </div>

