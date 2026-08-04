                    <div id="step-1" class="p-6 sm:p-10 step-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-buildings text-blue-600 text-3xl"></i> Profil Usaha
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="company-name">Nama Perusahaan / Usaha <span class="text-red-500">*</span></label>
                                <input name="company_name" value="{{ old('company_name', $company->name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="company-name" type="text" placeholder="Contoh: PT Maju Bersama">
                                @if(isset($feedbacks['company-name']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['company-name']->message }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="pelaku-usaha">Pelaku Usaha <span class="text-red-500">*</span></label>
                                <select name="pelaku_usaha"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="pelaku-usaha">
                                    <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Pelaku Usaha...</option>
                                    <option value="orang-perseorangan" {{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'orang-perseorangan' ? 'selected' : '' }}>Orang Perseorangan</option>
                                    <option value="badan-usaha" {{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'badan-usaha' ? 'selected' : '' }}>Badan Usaha</option>
                                    <option value="kantor-perwakilan" {{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'kantor-perwakilan' ? 'selected' : '' }}>Kantor Perwakilan</option>
                                    <option value="badan-usaha-luar-negeri" {{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'badan-usaha-luar-negeri' ? 'selected' : '' }}>Badan Usaha Luar Negeri</option>
                                </select>
                                @if(isset($feedbacks['pelaku-usaha']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['pelaku-usaha']->message }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div id="container-skala-usaha" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'kantor-perwakilan' ? '' : 'hidden' }}">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="skala-usaha">Skala Usaha (sesuai NIB) <span class="text-red-500">*</span></label>
                                <select name="skala_usaha" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white disabled:bg-gray-100 disabled:text-gray-500" id="skala-usaha">
                                    <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Skala Usaha...</option>
                                    <option value="mikro" {{ old('skala_usaha', $company->skala_usaha ?? '') == 'mikro' ? 'selected' : '' }}>Usaha Mikro</option>
                                    <option value="kecil" {{ old('skala_usaha', $company->skala_usaha ?? '') == 'kecil' ? 'selected' : '' }}>Usaha Kecil</option>
                                    <option value="menengah" {{ old('skala_usaha', $company->skala_usaha ?? '') == 'menengah' ? 'selected' : '' }}>Usaha Menengah</option>
                                    <option value="besar" {{ old('skala_usaha', $company->skala_usaha ?? '') == 'besar' ? 'selected' : '' }}>Usaha Besar</option>
                                </select>
                                @if(isset($feedbacks['skala-usaha']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['skala-usaha']->message }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            @php $isSubPelakuUsahaVisible = in_array(old('pelaku_usaha', $company->pelaku_usaha_type ?? ''), ['orang-perseorangan', 'badan-usaha', 'kantor-perwakilan', 'badan-usaha-luar-negeri']); @endphp
                            <div id="sub-pelaku-usaha-container" class="{{ $isSubPelakuUsahaVisible ? '' : 'hidden' }}">
                                <div id="container-nik" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'orang-perseorangan' ? 'mb-4' : 'hidden mb-4' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nik-perseorangan">NIK <span class="text-red-500">*</span></label>
                                    <input name="nik_perseorangan" value="{{ old('nik_perseorangan', $company->perseorangan_nik ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="nik-perseorangan" type="text" placeholder="Masukkan 16 digit NIK">
                                </div>
                                <div id="container-badan-usaha" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'badan-usaha' ? 'mb-4' : 'hidden mb-4' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-badan-usaha">Jenis Badan Usaha <span class="text-red-500">*</span></label>
                                    <select name="jenis_badan_usaha"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-badan-usaha">
                                        <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Jenis Badan Usaha...</option>
                                        @foreach(['Perseroan Terbatas (PT)', 'Perseroan Terbatas (PT) Perorangan', 'Persekutuan Komanditer (CV / Commanditaire Vennootschap)', 'Persekutuan Firma (FA / Venootschap Onder Firma)', 'Persekutuan Perdata', 'Perusahaan Umum (Perum)', 'Perusahaan Umum Daerah (Perumda)', 'Badan Hukum Lainnya', 'Koperasi', 'Persekutuan dan Perkumpulan', 'Yayasan', 'Badan Layanan Umum', 'BUM Desa', 'BUM Desa Bersama', 'Bentuk Usaha Tetap (BUT)'] as $jbu)
                                            <option value="{{ $jbu }}" {{ old('jenis_badan_usaha', $company->pelaku_usaha_detail ?? '') == $jbu ? 'selected' : '' }}>{{ $jbu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="container-kantor-perwakilan" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'kantor-perwakilan' ? 'mb-4' : 'hidden mb-4' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-kantor-perwakilan">Jenis Kantor Perwakilan <span class="text-red-500">*</span></label>
                                    <select name="jenis_kantor_perwakilan"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-kantor-perwakilan">
                                        <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Jenis Kantor Perwakilan...</option>
                                        @foreach(['KPPA', 'KPJPTLA', 'KP3A', 'KP3A PMSE', 'BUJKA'] as $jkp)
                                            <option value="{{ $jkp }}" {{ old('jenis_kantor_perwakilan', $company->pelaku_usaha_detail ?? '') == $jkp ? 'selected' : '' }}>{{ $jkp }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="container-badan-usaha-luar-negeri" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'badan-usaha-luar-negeri' ? 'mb-4' : 'hidden mb-4' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-badan-usaha-luar-negeri">Jenis Badan Usaha Luar Negeri <span class="text-red-500">*</span></label>
                                    <select name="jenis_badan_usaha_luar_negeri"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-badan-usaha-luar-negeri">
                                        <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Jenis Badan Usaha Luar Negeri...</option>
                                        @foreach(['Pemberi Waralaba (STPW)', 'Pedagang Berjangka Asing', 'PSE Asing'] as $jbuln)
                                            <option value="{{ $jbuln }}" {{ old('jenis_badan_usaha_luar_negeri', $company->pelaku_usaha_detail ?? '') == $jbuln ? 'selected' : '' }}>{{ $jbuln }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(isset($feedbacks['pelaku-usaha-detail']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['pelaku-usaha-detail']->message }}
                                        </div>
                                    </div>
                                @endif
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
                                @if(isset($feedbacks['kbli-search']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['kbli-search']->message }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Legalitas & Pimpinan -->
