                    <div id="step-2" class="p-6 sm:p-10 step-section hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-file-text text-blue-600 text-3xl"></i> Legalitas & Pimpinan
                        </h2>
                        
                        <div class="space-y-8">
                            <!-- Pimpinan Section -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><i class="ph ph-user-circle text-xl text-gray-500"></i> Informasi Penanggung Jawab</h3>
                                
                                <!-- WNI/WNA Radio for Kantor Perwakilan / BULN -->
                                <div id="container-kewarganegaraan-radio" class="mb-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kewarganegaraan Penanggung Jawab <span class="text-red-500">*</span></label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="kewarganegaraan" value="WNI" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                            <span class="text-sm text-gray-700">WNI (Warga Negara Indonesia)</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="kewarganegaraan" value="WNA" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="text-sm text-gray-700">WNA (Warga Negara Asing)</span>
                                        </label>
                                    </div>
                                </div>

                                <div id="pimpinan-grid" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama-pimpinan">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input name="nama_pimpinan"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nama-pimpinan" type="text" placeholder="Sesuai KTP / Paspor">
                                    </div>
                                    <div id="container-jabatan">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jabatan-pimpinan">Jabatan <span class="text-red-500">*</span></label>
                                        <input name="jabatan_pimpinan"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="jabatan-pimpinan" type="text" placeholder="Contoh: Direktur Utama / Pemilik">
                                    </div>
                                    <div id="container-nik-pimpinan" class="hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" id="label-nik-pimpinan" for="nik-pimpinan">NIK <span class="text-red-500">*</span></label>
                                        <input name="nik_pimpinan"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nik-pimpinan" type="text" placeholder="16 Digit NIK">
                                    </div>
                                    <div id="container-nationality" class="hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nationality-pimpinan">Kewarganegaraan (Nationality) <span class="text-red-500">*</span></label>
                                        <select name="nationality_pimpinan"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nationality-pimpinan">
                                            <option value="" disabled selected>Pilih Negara...</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Singapura">Singapura</option>
                                            <option value="Jepang">Jepang</option>
                                            <option value="Korea Selatan">Korea Selatan</option>
                                            <option value="Amerika Serikat">Amerika Serikat</option>
                                            <option value="Tiongkok">Tiongkok</option>
                                            <option value="Inggris">Inggris</option>
                                            <option value="Lainnya">Lainnya...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dokumen Section -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><i class="ph ph-certificate text-xl text-gray-500"></i> Informasi Legalitas</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- NIB -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nib-number">Nomor Induk Berusaha (NIB) <span class="text-red-500">*</span></label>
                                    <input name="nib_number"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 mb-3" id="nib-number" type="text" placeholder="13 Digit Nomor NIB">
                                    
                                    <div class="mt-1 relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="ph ph-link text-gray-400 text-lg"></i>
                                        </div>
                                        <input type="url" id="nib-link" name="nib_link" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white transition-colors text-sm" placeholder="Link Google Drive Dokumen NIB">
                                    </div>
                                </div>
                                
                                <!-- NPWP -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-sm font-medium text-gray-700" for="npwp-number">Nomor NPWP <span id="label-npwp-perusahaan">Perusahaan </span><span class="text-red-500">*</span></label>
                                        <div id="container-sama-dengan-nik" class="hidden flex items-center">
                                            <input name="sama_dengan_nik"  id="sama-dengan-nik" type="checkbox" class="ml-1 h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                                            <label for="sama-dengan-nik" class="ml-2 block text-xs font-medium text-gray-700 cursor-pointer select-none">
                                                Sama dengan NIK
                                            </label>
                                        </div>
                                    </div>
                                    <input name="npwp_number"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 mb-3" id="npwp-number" type="text" placeholder="15 Digit Nomor NPWP">
                                    
                                    <div class="mt-1 relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="ph ph-link text-gray-400 text-lg"></i>
                                        </div>
                                        <input type="url" id="npwp-link" name="npwp_link" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white transition-colors text-sm" placeholder="Link Google Drive Kartu NPWP">
                                    </div>
                                </div>
                            </div>

                            <!-- PKP Section -->
                            <div class="mt-6 border-t border-gray-100 pt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Apakah Perusahaan Anda PKP (Pengusaha Kena Pajak)? <span class="text-red-500">*</span></label>
                                <div class="flex gap-4 mb-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="is_pkp" value="1" id="pkp-yes" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="text-sm text-gray-700">Ya, Sudah PKP</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="is_pkp" value="0" id="pkp-no" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="text-sm text-gray-700">Belum PKP</span>
                                    </label>
                                </div>
                                <div id="container-pkp-link" class="hidden mt-3 relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="ph ph-link text-gray-400 text-lg"></i>
                                    </div>
                                    <input type="url" id="pkp-link" name="pkp_link" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white transition-colors text-sm" placeholder="Link Google Drive Dokumen / SPPKP">
                                </div>
                                <p id="pkp-helper-text" class="text-xs text-amber-600 mt-2 hidden"><i class="ph ph-info"></i> Skala usaha Menengah/Besar wajib memiliki status PKP.</p>
                            </div>
                            
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Lokasi -->
