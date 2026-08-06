                    <div id="step-2" class="p-6 sm:p-10 step-section hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-file-text text-blue-600 text-3xl"></i> Legalitas & Pimpinan
                        </h2>
                        
                        <div class="space-y-8">
                            @php $rep = $company?->representatives?->first() ?? null; @endphp
                            <!-- Pimpinan Section -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><i class="ph ph-user-circle text-xl text-gray-500"></i> Informasi Penanggung Jawab</h3>
                                @if(isset($feedbacks['penanggung-jawab']))
                                    <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi Penanggung Jawab</span>
                                            {{ $feedbacks['penanggung-jawab']->message }}
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- WNI/WNA Radio for Kantor Perwakilan / BULN -->
                                @php $pelakuUsaha = old('pelaku_usaha', $company->pelaku_usaha_type ?? ''); @endphp
                                <div id="container-kewarganegaraan-radio" class="{{ in_array($pelakuUsaha, ['kantor-perwakilan', 'badan-usaha-luar-negeri']) ? 'mb-4' : 'hidden mb-4' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kewarganegaraan Penanggung Jawab <span class="text-red-500">*</span></label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="kewarganegaraan" value="WNI" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('kewarganegaraan', $rep->citizenship_type ?? 'WNI') == 'WNI' ? 'checked' : '' }}>
                                            <span class="text-sm text-gray-700">WNI (Warga Negara Indonesia)</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="kewarganegaraan" value="WNA" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('kewarganegaraan', $rep->citizenship_type ?? 'WNI') == 'WNA' ? 'checked' : '' }}>
                                            <span class="text-sm text-gray-700">WNA (Warga Negara Asing)</span>
                                        </label>
                                    </div>
                                    @if(isset($feedbacks['kewarganegaraan']))
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                            <i class="ph ph-warning-circle mt-0.5"></i> 
                                            <div>
                                                <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                {{ $feedbacks['kewarganegaraan']->message }}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div id="pimpinan-grid" class="{{ $pelakuUsaha == 'orang-perseorangan' ? 'grid grid-cols-1 gap-5' : 'grid grid-cols-1 md:grid-cols-2 gap-5' }}">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama-pimpinan">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input name="nama_pimpinan" value="{{ old('nama_pimpinan', $rep->name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nama-pimpinan" type="text" placeholder="Sesuai KTP / Paspor">
                                        @if(isset($feedbacks['nama-pimpinan']))
                                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                                <i class="ph ph-warning-circle mt-0.5"></i> 
                                                <div>
                                                    <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                    {{ $feedbacks['nama-pimpinan']->message }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div id="container-jabatan" class="{{ $pelakuUsaha == 'orang-perseorangan' ? 'hidden' : '' }}">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jabatan-pimpinan">Jabatan <span class="text-red-500">*</span></label>
                                        <input name="jabatan_pimpinan" value="{{ old('jabatan_pimpinan', $rep->position ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="jabatan-pimpinan" type="text" placeholder="Contoh: Direktur Utama / Pemilik">
                                        @if(isset($feedbacks['jabatan-pimpinan']))
                                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                                <i class="ph ph-warning-circle mt-0.5"></i> 
                                                <div>
                                                    <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                    {{ $feedbacks['jabatan-pimpinan']->message }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @php $isWNI = old('kewarganegaraan', $rep->citizenship_type ?? 'WNI') == 'WNI'; @endphp
                                    <div id="container-nik-pimpinan" class="{{ $pelakuUsaha == 'orang-perseorangan' ? 'hidden' : '' }}">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" id="label-nik-pimpinan" for="nik-pimpinan">{!! $isWNI ? 'NIK <span class="text-red-500">*</span>' : 'Nomor Paspor / Passport <span class="text-red-500">*</span>' !!}</label>
                                        <input name="nik_pimpinan" value="{{ old('nik_pimpinan', $rep->identity_number ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nik-pimpinan" type="text" placeholder="{{ $isWNI ? '16 Digit NIK' : 'Nomor Paspor / Passport Number' }}">
                                        @if(isset($feedbacks['nik-pimpinan']))
                                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                                <i class="ph ph-warning-circle mt-0.5"></i> 
                                                <div>
                                                    <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                    {{ $feedbacks['nik-pimpinan']->message }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div id="container-nationality" class="{{ !$isWNI && in_array($pelakuUsaha, ['kantor-perwakilan', 'badan-usaha-luar-negeri']) ? '' : 'hidden' }}">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nationality-pimpinan">Kewarganegaraan (Nationality) <span class="text-red-500">*</span></label>
                                        <select name="nationality_pimpinan"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nationality-pimpinan">
                                            <option value="" disabled {{ !isset($rep) ? 'selected' : '' }}>Pilih Negara...</option>
                                            @foreach(['Malaysia', 'Singapura', 'Jepang', 'Korea Selatan', 'Amerika Serikat', 'Tiongkok', 'Inggris', 'Lainnya'] as $nat)
                                                <option value="{{ $nat }}" {{ old('nationality_pimpinan', $rep->nationality ?? '') == $nat ? 'selected' : '' }}>{{ $nat }}</option>
                                            @endforeach
                                        </select>
                                        @if(isset($feedbacks['nationality-pimpinan']))
                                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                                <i class="ph ph-warning-circle mt-0.5"></i> 
                                                <div>
                                                    <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                    {{ $feedbacks['nationality-pimpinan']->message }}
                                                </div>
                                            </div>
                                        @endif
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
                                    <input name="nib_number" value="{{ old('nib_number', $company->nib_number ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 mb-3" id="nib-number" type="text" placeholder="13 Digit Nomor NIB">
                                    @if(isset($feedbacks['nib-number']))
                                        <div class="mt-2 mb-3 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                            <i class="ph ph-warning-circle mt-0.5"></i> 
                                            <div>
                                                <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                {{ $feedbacks['nib-number']->message }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-1 relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="ph ph-link text-gray-400 text-lg"></i>
                                        </div>
                                        <input type="url" id="nib-link" value="{{ old('nib_link', $company->nib_link ?? '') }}" name="nib_link" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white transition-colors text-sm" placeholder="Link Google Drive Dokumen NIB">
                                    </div>
                                    @if(isset($feedbacks['nib-link']))
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                            <i class="ph ph-warning-circle mt-0.5"></i> 
                                            <div>
                                                <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                {{ $feedbacks['nib-link']->message }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- NPWP -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-sm font-medium text-gray-700" for="npwp-number">Nomor NPWP <span id="label-npwp-perusahaan">Perusahaan </span><span class="text-red-500">*</span></label>
                                        <div id="container-sama-dengan-nik" class="{{ old('pelaku_usaha', $company->pelaku_usaha_type ?? '') == 'orang-perseorangan' ? 'flex items-center' : 'hidden flex items-center' }}">
                                            <input name="sama_dengan_nik" {{ old('sama_dengan_nik', $company->is_npwp_same_as_nik ?? false) ? 'checked' : '' }} id="sama-dengan-nik" type="checkbox" class="ml-1 h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                                            <label for="sama-dengan-nik" class="ml-2 block text-xs font-medium text-gray-700 cursor-pointer select-none">
                                                Sama dengan NIK
                                            </label>
                                        </div>
                                    </div>
                                    <input name="npwp_number" value="{{ old('npwp_number', $company->npwp_number ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 mb-3" id="npwp-number" type="text" placeholder="15 Digit Nomor NPWP">
                                    @if(isset($feedbacks['npwp-number']))
                                        <div class="mt-2 mb-3 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                            <i class="ph ph-warning-circle mt-0.5"></i> 
                                            <div>
                                                <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                {{ $feedbacks['npwp-number']->message }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-1 relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="ph ph-link text-gray-400 text-lg"></i>
                                        </div>
                                        <input type="url" id="npwp-link" value="{{ old('npwp_link', $company->npwp_link ?? '') }}" name="npwp_link" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white transition-colors text-sm" placeholder="Link Google Drive Kartu NPWP">
                                    </div>
                                    @if(isset($feedbacks['npwp-link']))
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                            <i class="ph ph-warning-circle mt-0.5"></i> 
                                            <div>
                                                <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                                {{ $feedbacks['npwp-link']->message }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- PKP Section -->
                            <div class="mt-6 border-t border-gray-100 pt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Apakah Perusahaan Anda PKP (Pengusaha Kena Pajak)? <span class="text-red-500">*</span></label>
                                <div class="flex gap-4 mb-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="is_pkp" value="1" id="pkp-yes" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('is_pkp', $company->is_pkp ?? null) === true ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-700">Ya, Sudah PKP</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="is_pkp" value="0" id="pkp-no" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('is_pkp', $company->is_pkp ?? null) === false ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-700">Belum PKP</span>
                                    </label>
                                </div>
                                @if(isset($feedbacks['pkp-yes']))
                                    <div class="mt-2 mb-3 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['pkp-yes']->message }}
                                        </div>
                                    </div>
                                @endif
                                <div id="container-pkp-link" class="{{ old('is_pkp', $company->is_pkp ?? null) === true ? '' : 'hidden' }} mt-3 relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="ph ph-link text-gray-400 text-lg"></i>
                                    </div>
                                    <input type="url" id="pkp-link" value="{{ old('pkp_link', $company->pkp_link ?? '') }}" name="pkp_link" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white transition-colors text-sm" placeholder="Link Google Drive Dokumen / SPPKP">
                                </div>
                                @if(isset($feedbacks['pkp-link']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['pkp-link']->message }}
                                        </div>
                                    </div>
                                @endif
                                <p id="pkp-helper-text" class="text-xs text-amber-600 mt-2 hidden"><i class="ph ph-info"></i> Skala usaha Menengah/Besar wajib memiliki status PKP.</p>
                            </div>
                            
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Lokasi -->
