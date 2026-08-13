                    <div id="step-1" class="p-6 sm:p-10 step-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-buildings text-blue-600 text-3xl"></i> Profil Usaha
                        </h2>
                        
                        <div class="space-y-6">
                            <x-form.input 
                                name="company_name" 
                                label="Nama Perusahaan / Usaha" 
                                id="company-name" 
                                :required="true" 
                                value="{{ $company->name ?? '' }}" 
                                placeholder="Contoh: PT Maju Bersama" 
                            />
                            
                            <x-form.select 
                                name="pelaku_usaha" 
                                label="Pelaku Usaha" 
                                id="pelaku-usaha" 
                                :required="true"
                            >
                                <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Pelaku Usaha...</option>
                                <option value="orang-perseorangan" {{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'orang-perseorangan' ? 'selected' : '' }}>Orang Perseorangan</option>
                                <option value="badan-usaha" {{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'badan-usaha' ? 'selected' : '' }}>Badan Usaha</option>
                                <option value="kantor-perwakilan" {{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'kantor-perwakilan' ? 'selected' : '' }}>Kantor Perwakilan</option>
                                <option value="badan-usaha-luar-negeri" {{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'badan-usaha-luar-negeri' ? 'selected' : '' }}>Badan Usaha Luar Negeri</option>
                            </x-form.select>
                            
                            <div id="container-skala-usaha" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'kantor-perwakilan' ? '' : 'hidden' }}">
                                <x-form.select 
                                    name="skala_usaha" 
                                    label="Skala Usaha (sesuai NIB)" 
                                    id="skala-usaha" 
                                    :required="true"
                                >
                                    <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Skala Usaha...</option>
                                    <option value="mikro" {{ old('skala_usaha', $company->skala_usaha ?? '') == 'mikro' ? 'selected' : '' }}>Usaha Mikro</option>
                                    <option value="kecil" {{ old('skala_usaha', $company->skala_usaha ?? '') == 'kecil' ? 'selected' : '' }}>Usaha Kecil</option>
                                    <option value="menengah" {{ old('skala_usaha', $company->skala_usaha ?? '') == 'menengah' ? 'selected' : '' }}>Usaha Menengah</option>
                                    <option value="besar" {{ old('skala_usaha', $company->skala_usaha ?? '') == 'besar' ? 'selected' : '' }}>Usaha Besar</option>
                                </x-form.select>
                            </div>
                            
                            @php $isSubPelakuUsahaVisible = in_array(old('pelaku_usaha', $company->pelaku_usaha_type ?? ''), ['orang-perseorangan', 'badan-usaha', 'kantor-perwakilan', 'badan-usaha-luar-negeri']); @endphp
                            <div id="sub-pelaku-usaha-container" class="{{ $isSubPelakuUsahaVisible ? '' : 'hidden' }}">
                                <div id="container-nik" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'orang-perseorangan' ? 'mb-4' : 'hidden mb-4' }}">
                                    <x-form.input 
                                        name="nik_perseorangan" 
                                        label="NIK" 
                                        id="nik-perseorangan" 
                                        :required="true" 
                                        value="{{ $company->perseorangan_nik ?? '' }}" 
                                        placeholder="Masukkan 16 digit NIK" 
                                    />
                                </div>
                                <div id="container-badan-usaha" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'badan-usaha' ? 'mb-4' : 'hidden mb-4' }}">
                                    <x-form.select 
                                        name="jenis_badan_usaha" 
                                        label="Jenis Badan Usaha" 
                                        id="jenis-badan-usaha" 
                                        :required="true"
                                        feedbackKey="pelaku-usaha-detail"
                                    >
                                        <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Jenis Badan Usaha...</option>
                                        @foreach(['Perseroan Terbatas (PT)', 'Perseroan Terbatas (PT) Perorangan', 'Persekutuan Komanditer (CV / Commanditaire Vennootschap)', 'Persekutuan Firma (FA / Venootschap Onder Firma)', 'Persekutuan Perdata', 'Perusahaan Umum (Perum)', 'Perusahaan Umum Daerah (Perumda)', 'Badan Hukum Lainnya', 'Koperasi', 'Persekutuan dan Perkumpulan', 'Yayasan', 'Badan Layanan Umum', 'BUM Desa', 'BUM Desa Bersama', 'Bentuk Usaha Tetap (BUT)'] as $jbu)
                                            <option value="{{ $jbu }}" {{ old('jenis_badan_usaha', $company->pelaku_usaha_detail ?? '') == $jbu ? 'selected' : '' }}>{{ $jbu }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                                <div id="container-kantor-perwakilan" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'kantor-perwakilan' ? 'mb-4' : 'hidden mb-4' }}">
                                    <x-form.select 
                                        name="jenis_kantor_perwakilan" 
                                        label="Jenis Kantor Perwakilan" 
                                        id="jenis-kantor-perwakilan" 
                                        :required="true"
                                        feedbackKey="pelaku-usaha-detail"
                                    >
                                        <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Jenis Kantor Perwakilan...</option>
                                        @foreach(['KPPA', 'KPJPTLA', 'KP3A', 'KP3A PMSE', 'BUJKA'] as $jkp)
                                            <option value="{{ $jkp }}" {{ old('jenis_kantor_perwakilan', $company->pelaku_usaha_detail ?? '') == $jkp ? 'selected' : '' }}>{{ $jkp }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                                <div id="container-badan-usaha-luar-negeri" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'badan-usaha-luar-negeri' ? 'mb-4' : 'hidden mb-4' }}">
                                    <x-form.select 
                                        name="jenis_badan_usaha_luar_negeri" 
                                        label="Jenis Badan Usaha Luar Negeri" 
                                        id="jenis-badan-usaha-luar-negeri" 
                                        :required="true"
                                        feedbackKey="pelaku-usaha-detail"
                                    >
                                        <option value="" disabled {{ !isset($company) ? 'selected' : '' }}>Pilih Jenis Badan Usaha Luar Negeri...</option>
                                        @foreach(['Pemberi Waralaba (STPW)', 'Pedagang Berjangka Asing', 'PSE Asing'] as $jbuln)
                                            <option value="{{ $jbuln }}" {{ old('jenis_badan_usaha_luar_negeri', $company->pelaku_usaha_detail ?? '') == $jbuln ? 'selected' : '' }}>{{ $jbuln }}</option>
                                        @endforeach
                                    </x-form.select>
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
