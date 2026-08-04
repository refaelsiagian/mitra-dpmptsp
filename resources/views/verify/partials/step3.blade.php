                    <div id="step-3" class="p-6 sm:p-10 step-section hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-map-pin text-blue-600 text-3xl"></i> Informasi Lokasi
                        </h2>
                        
                        <div class="space-y-8">
                            <!-- Kantor Utama -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2"><i class="ph ph-office-chair text-xl text-gray-500"></i> Alamat Kantor Utama</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Provinsi <span class="text-red-500">*</span></label>
                                        <select name="provinsi_kantor"  id="provinsi-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadRegencies(this.value, 'kabupaten-kantor')">
                                            <option selected disabled value="">Pilih Provinsi...</option>
                                            @foreach($provinces as $prov)
                                                <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                        <select name="kabupaten_kantor"  id="kabupaten-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadDistricts(this.value, 'kecamatan-kantor')" disabled>
                                            <option selected disabled value="">Pilih Kabupaten...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                        <select name="kecamatan_kantor"  id="kecamatan-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadVillages(this.value, 'desa-kantor')" disabled>
                                            <option selected disabled value="">Pilih Kecamatan...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                        <select name="desa_kantor"  id="desa-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" disabled>
                                            <option selected disabled value="">Pilih Desa...</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <textarea name="alamat_kantor"  id="alamat-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" rows="2" placeholder="Detail alamat (Jalan, RT/RW, Gedung, Patokan)"></textarea>
                                </div>
                            </div>

                            <!-- Lokasi Usaha -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2"><i class="ph ph-storefront text-xl text-gray-500"></i> Lokasi Usaha/Proyek</h3>
                                <div class="flex items-center mb-4">
                                    <input type="hidden" name="same_as_office" value="0">
                                    <input name="same_as_office" id="same-as-office" type="checkbox" value="1" class="ml-1 h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                                    <label for="same-as-office" class="ml-2 block text-sm font-medium text-gray-700 cursor-pointer select-none">
                                        Sama dengan kantor utama
                                    </label>
                                </div>
                                
                                <div id="usaha-location-fields" class="transition-opacity duration-300">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Provinsi <span class="text-red-500">*</span></label>
                                            <select name="provinsi_usaha"  id="provinsi-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadRegencies(this.value, 'kabupaten-usaha')">
                                                <option selected disabled value="">Pilih Provinsi...</option>
                                                @foreach($provinces as $prov)
                                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                            <select name="kabupaten_usaha"  id="kabupaten-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadDistricts(this.value, 'kecamatan-usaha')" disabled>
                                                <option selected disabled value="">Pilih Kabupaten...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                            <select name="kecamatan_usaha"  id="kecamatan-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadVillages(this.value, 'desa-usaha')" disabled>
                                                <option selected disabled value="">Pilih Kecamatan...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                            <select name="desa_usaha"  id="desa-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" disabled>
                                                <option selected disabled value="">Pilih Desa...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Alamat Lengkap Usaha <span class="text-red-500">*</span></label>
                                        <textarea name="alamat_usaha"  id="alamat-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" rows="2" placeholder="Detail alamat usaha/proyek"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Google Maps Coordinate -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Koordinat Maps Lokasi Usaha <span class="text-red-500">*</span></label>
                                <div class="flex gap-2">
                                    <input name="coordinate_input"  class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 bg-white" type="text" placeholder="-6.200000, 106.816666" id="coordinate-input">
                                    <button type="button" id="btn-open-map" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg border border-gray-300 flex items-center gap-2 transition-colors font-medium text-sm whitespace-nowrap">
                                        <i class="ph ph-map-pin-plus"></i> Ambil Titik Maps
                                    </button>
                                </div>
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
