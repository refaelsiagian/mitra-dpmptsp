                    <div id="step-1" class="p-6 sm:p-10 step-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-buildings text-blue-600 text-3xl"></i> Profil Usaha
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="company-name">Nama Perusahaan / Usaha <span class="text-red-500">*</span></label>
                                <input name="company_name"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="company-name" type="text" placeholder="Contoh: PT Maju Bersama">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="pelaku-usaha">Pelaku Usaha <span class="text-red-500">*</span></label>
                                <select name="pelaku_usaha"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="pelaku-usaha">
                                    <option value="" disabled selected>Pilih Pelaku Usaha...</option>
                                    <option value="orang-perseorangan">Orang Perseorangan</option>
                                    <option value="badan-usaha">Badan Usaha</option>
                                    <option value="kantor-perwakilan">Kantor Perwakilan</option>
                                    <option value="badan-usaha-luar-negeri">Badan Usaha Luar Negeri</option>
                                </select>
                            </div>
                            
                            <div id="sub-pelaku-usaha-container" class="hidden">
                                <div id="container-nik" class="hidden mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nik-perseorangan">NIK <span class="text-red-500">*</span></label>
                                    <input name="nik_perseorangan"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="nik-perseorangan" type="text" placeholder="Masukkan 16 digit NIK">
                                </div>
                                <div id="container-badan-usaha" class="hidden mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-badan-usaha">Jenis Badan Usaha <span class="text-red-500">*</span></label>
                                    <select name="jenis_badan_usaha"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-badan-usaha">
                                        <option value="" disabled selected>Pilih Jenis Badan Usaha...</option>
                                        <option value="Perseroan Terbatas (PT)">Perseroan Terbatas (PT)</option>
                                        <option value="Perseroan Terbatas (PT) Perorangan">Perseroan Terbatas (PT) Perorangan</option>
                                        <option value="Persekutuan Komanditer (CV / Commanditaire Vennootschap)">Persekutuan Komanditer (CV / Commanditaire Vennootschap)</option>
                                        <option value="Persekutuan Firma (FA / Venootschap Onder Firma)">Persekutuan Firma (FA / Venootschap Onder Firma)</option>
                                        <option value="Persekutuan Perdata">Persekutuan Perdata</option>
                                        <option value="Perusahaan Umum (Perum)">Perusahaan Umum (Perum)</option>
                                        <option value="Perusahaan Umum Daerah (Perumda)">Perusahaan Umum Daerah (Perumda)</option>
                                        <option value="Badan Hukum Lainnya">Badan Hukum Lainnya</option>
                                        <option value="Koperasi">Koperasi</option>
                                        <option value="Persekutuan dan Perkumpulan">Persekutuan dan Perkumpulan</option>
                                        <option value="Yayasan">Yayasan</option>
                                        <option value="Badan Layanan Umum">Badan Layanan Umum</option>
                                        <option value="BUM Desa">BUM Desa</option>
                                        <option value="BUM Desa Bersama">BUM Desa Bersama</option>
                                        <option value="Bentuk Usaha Tetap (BUT)">Bentuk Usaha Tetap (BUT)</option>
                                    </select>
                                </div>
                                <div id="container-kantor-perwakilan" class="hidden mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-kantor-perwakilan">Jenis Kantor Perwakilan <span class="text-red-500">*</span></label>
                                    <select name="jenis_kantor_perwakilan"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-kantor-perwakilan">
                                        <option value="" disabled selected>Pilih Jenis Kantor Perwakilan...</option>
                                        <option value="KPPA">KPPA</option>
                                        <option value="KPJPTLA">KPJPTLA</option>
                                        <option value="KP3A">KP3A</option>
                                        <option value="KP3A PMSE">KP3A PMSE</option>
                                        <option value="BUJKA">BUJKA</option>
                                    </select>
                                </div>
                                <div id="container-badan-usaha-luar-negeri" class="hidden mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-badan-usaha-luar-negeri">Jenis Badan Usaha Luar Negeri <span class="text-red-500">*</span></label>
                                    <select name="jenis_badan_usaha_luar_negeri"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-badan-usaha-luar-negeri">
                                        <option value="" disabled selected>Pilih Jenis Badan Usaha Luar Negeri...</option>
                                        <option value="Pemberi Waralaba (STPW)">Pemberi Waralaba (STPW)</option>
                                        <option value="Pedagang Berjangka Asing">Pedagang Berjangka Asing</option>
                                        <option value="PSE Asing">PSE Asing</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode KBLI (Klasifikasi Baku Lapangan Usaha Indonesia) <span class="text-red-500">*</span></label>
                                
                                <div id="kbli-container" class="flex flex-wrap items-center gap-2 w-full p-2 border border-gray-300 rounded-lg bg-white focus-within:ring-2 focus-within:ring-blue-600 focus-within:border-blue-600 transition-colors min-h-[42px] cursor-text">
                                    <div id="kbli-chips" class="flex flex-wrap gap-1.5 items-center"></div>
                                    <input type="text" id="kbli-search" class="flex-grow min-w-[150px] outline-none text-sm bg-transparent py-0.5" placeholder="Cari kode atau nama KBLI...">
                                </div>
                                
                                <div id="kbli-dropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl hidden max-h-56 overflow-y-auto">
                                    <ul id="kbli-list" class="py-1 text-sm text-gray-700">
                                        <!-- JS will populate this -->
                                    </ul>
                                </div>
                                
                                <p class="text-xs text-gray-500 mt-1.5"><i class="ph ph-info mr-1"></i>Anda dapat memilih lebih dari satu KBLI.</p>
                                <input type="hidden" name="kblis" id="kblis-input">
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Legalitas & Pimpinan -->
