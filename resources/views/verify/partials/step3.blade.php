                    <div id="step-3" class="p-6 sm:p-10 step-section hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-map-pin text-blue-600 text-3xl"></i> Informasi Lokasi
                        </h2>
                        
                        <div class="space-y-8">
                            @php 
                                $kantorUtama = $company->locations->where('type', 'KANTOR_UTAMA')->first() ?? null;
                                $lokasiUsaha = $company->locations->where('type', 'LOKASI_USAHA')->first() ?? null;
                            @endphp
                            
                            @if(isset($feedbacks['lokasi-perusahaan']))
                                <div class="mb-4 text-sm text-red-600 bg-red-50 p-4 rounded-xl border border-red-200 shadow-sm flex gap-2 items-start">
                                    <i class="ph ph-warning-circle text-lg mt-0.5"></i> 
                                    <div>
                                        <span class="font-bold text-xs uppercase tracking-wider block mb-1">Catatan Revisi Lokasi Perusahaan</span>
                                        {{ $feedbacks['lokasi-perusahaan']->message }}
                                    </div>
                                </div>
                            @endif
                            <!-- Kantor Utama -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2"><i class="ph ph-office-chair text-xl text-gray-500"></i> Alamat Kantor Utama</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Provinsi <span class="text-red-500">*</span></label>
                                        <select name="provinsi_kantor"  id="provinsi-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadRegencies(this.value, 'kabupaten-kantor')">
                                            <option {{ !isset($kantorUtama) ? 'selected' : '' }} disabled value="">Pilih Provinsi...</option>
                                            @foreach($provinces as $prov)
                                                <option value="{{ $prov->id }}" {{ old('provinsi_kantor', $kantorUtama->province_id ?? '') == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                        <select name="kabupaten_kantor" data-old="{{ old('kabupaten_kantor', $kantorUtama->regency_id ?? '') }}" id="kabupaten-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadDistricts(this.value, 'kecamatan-kantor')" disabled>
                                            <option selected disabled value="">Pilih Kabupaten...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                        <select name="kecamatan_kantor" data-old="{{ old('kecamatan_kantor', $kantorUtama->district_id ?? '') }}" id="kecamatan-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadVillages(this.value, 'desa-kantor')" disabled>
                                            <option selected disabled value="">Pilih Kecamatan...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                        <select name="desa_kantor" data-old="{{ old('desa_kantor', $kantorUtama->village_id ?? '') }}" id="desa-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" disabled>
                                            <option selected disabled value="">Pilih Desa...</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <textarea name="alamat_kantor"  id="alamat-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" rows="2" placeholder="Detail alamat (Jalan, RT/RW, Gedung, Patokan)">{{ old('alamat_kantor', $kantorUtama->address ?? '') }}</textarea>
                                </div>
                                @if(isset($feedbacks['alamat-kantor']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['alamat-kantor']->message }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Lokasi Usaha -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2"><i class="ph ph-storefront text-xl text-gray-500"></i> Lokasi Usaha/Proyek</h3>
                                <div class="flex items-center mb-4">
                                    <input type="hidden" name="same_as_office" value="0">
                                    <input name="same_as_office" id="same-as-office" type="checkbox" value="1" class="ml-1 h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer" {{ old('same_as_office', $company->is_usaha_same_as_office ?? false) ? 'checked' : '' }}>
                                    <label for="same-as-office" class="ml-2 block text-sm font-medium text-gray-700 cursor-pointer select-none">
                                        Sama dengan kantor utama
                                    </label>
                                </div>
                                
                                <div id="usaha-location-fields" class="{{ old('same_as_office', $company->is_usaha_same_as_office ?? false) ? 'opacity-50 pointer-events-none' : 'transition-opacity duration-300' }}">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Provinsi <span class="text-red-500">*</span></label>
                                            <select name="provinsi_usaha"  id="provinsi-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadRegencies(this.value, 'kabupaten-usaha')">
                                                <option {{ !isset($lokasiUsaha) ? 'selected' : '' }} disabled value="">Pilih Provinsi...</option>
                                                @foreach($provinces as $prov)
                                                    <option value="{{ $prov->id }}" {{ old('provinsi_usaha', $lokasiUsaha->province_id ?? '') == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                            <select name="kabupaten_usaha" data-old="{{ old('kabupaten_usaha', $lokasiUsaha->regency_id ?? '') }}" id="kabupaten-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadDistricts(this.value, 'kecamatan-usaha')" disabled>
                                                <option selected disabled value="">Pilih Kabupaten...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                            <select name="kecamatan_usaha" data-old="{{ old('kecamatan_usaha', $lokasiUsaha->district_id ?? '') }}" id="kecamatan-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadVillages(this.value, 'desa-usaha')" disabled>
                                                <option selected disabled value="">Pilih Kecamatan...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                            <select name="desa_usaha" data-old="{{ old('desa_usaha', $lokasiUsaha->village_id ?? '') }}" id="desa-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" disabled>
                                                <option selected disabled value="">Pilih Desa...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Alamat Lengkap Usaha <span class="text-red-500">*</span></label>
                                        <textarea name="alamat_usaha"  id="alamat-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" rows="2" placeholder="Detail alamat usaha/proyek">{{ old('alamat_usaha', $lokasiUsaha->address ?? '') }}</textarea>
                                    </div>
                                </div>
                                @if(isset($feedbacks['alamat-usaha']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['alamat-usaha']->message }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Google Maps Coordinate -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Koordinat Maps Lokasi Usaha <span class="text-red-500">*</span></label>
                                <div class="flex gap-2">
                                    <input name="coordinate_input" value="{{ old('coordinate_input', ($kantorUtama && $kantorUtama->latitude) ? $kantorUtama->latitude . ', ' . $kantorUtama->longitude : '') }}" class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 bg-white" type="text" placeholder="-6.200000, 106.816666" id="coordinate-input">
                                    <button type="button" id="btn-open-map" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg border border-gray-300 flex items-center gap-2 transition-colors font-medium text-sm whitespace-nowrap">
                                        <i class="ph ph-map-pin-plus"></i> Ambil Titik Maps
                                    </button>
                                </div>
                                @if(isset($feedbacks['coordinate-input']))
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
                                        <i class="ph ph-warning-circle mt-0.5"></i> 
                                        <div>
                                            <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                                            {{ $feedbacks['coordinate-input']->message }}
                                        </div>
                                    </div>
                                @endif
                                <div id="map-preview-container" class="w-full h-48 bg-gray-100 rounded-lg mt-3 flex flex-col items-center justify-center text-gray-500 border border-gray-300 relative overflow-hidden z-0">
                                    <div id="map-preview-placeholder" class="flex flex-col items-center justify-center z-10 absolute inset-0 bg-gray-100">
                                        <i class="ph ph-map text-4xl mb-2 opacity-50"></i>
                                        <span class="text-sm">Tekan di sini atau Enter setelah tiap memasukkan koordinat untuk menampilkan preview, atau Ambil Titik Maps</span>
                                    </div>
                                    <div id="map-preview" class="w-full h-full absolute inset-0 opacity-0 z-0 transition-opacity duration-300"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- STEP 4: Konfirmasi -->
