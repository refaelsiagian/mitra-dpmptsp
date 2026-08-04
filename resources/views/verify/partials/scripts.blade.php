    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;
            
            const btnNext = document.getElementById('btn-next');
            const btnPrev = document.getElementById('btn-prev');
            const btnSubmit = document.getElementById('btn-submit');
            const progressLine = document.getElementById('progress-line');
            const spacer = document.getElementById('spacer');
            
            function updateUI() {
                // Update sections visibility with a tiny fade effect consideration
                document.querySelectorAll('.step-section').forEach((el, index) => {
                    if (index + 1 === currentStep) {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                });
                
                // Update buttons
                if (currentStep === 1) {
                    btnPrev.classList.add('hidden');
                    spacer.classList.remove('hidden');
                } else {
                    btnPrev.classList.remove('hidden');
                    spacer.classList.add('hidden');
                }
                
                if (currentStep === totalSteps) {
                    btnNext.classList.add('hidden');
                    btnSubmit.classList.remove('hidden');
                } else {
                    btnNext.classList.remove('hidden');
                    btnSubmit.classList.add('hidden');
                }
                
                // Update Progress Bar & Indicators
                const progressWidth = ((currentStep - 1) / (totalSteps - 1)) * 100;
                progressLine.style.width = `${progressWidth}%`;
                
                for(let i = 1; i <= totalSteps; i++) {
                    const indicator = document.getElementById(`indicator-${i}`);
                    const label = document.getElementById(`label-${i}`);
                    
                    if (i < currentStep) {
                        // Completed step
                        indicator.className = "w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-md border-4 border-white transition-all duration-300";
                        indicator.innerHTML = '<i class="ph ph-check text-xl"></i>';
                        label.className = "text-xs font-semibold mt-2 text-blue-600";
                    } else if (i === currentStep) {
                        // Current step
                        indicator.className = "w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg border-4 border-blue-100 transition-all duration-300 transform scale-110";
                        indicator.innerHTML = i;
                        label.className = "text-xs font-bold mt-2 text-blue-700";
                    } else {
                        // Future step
                        indicator.className = "w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-bold shadow-sm border-4 border-white transition-all duration-300";
                        indicator.innerHTML = i;
                        label.className = "text-xs font-medium mt-2 text-gray-400";
                    }
                }
            }
            
            function validateStep(step) {
                let isValid = true;
                
                // Helper to remove all existing errors for a given step
                const stepSection = document.getElementById(`step-${step}`);
                if (!stepSection) return true;
                
                stepSection.querySelectorAll('.error-msg').forEach(el => el.remove());
                stepSection.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
                
                function showError(elementId, message, borderElementId = null) {
                    isValid = false;
                    const el = document.getElementById(borderElementId || elementId);
                    if (el) el.classList.add('border-red-500');
                    
                    const targetEl = document.getElementById(elementId);
                    if (targetEl) {
                        const p = document.createElement('p');
                        p.className = 'text-red-500 text-xs mt-1 error-msg';
                        p.textContent = message;
                        
                        if (elementId === 'nib-link' || elementId === 'npwp-link') {
                            targetEl.parentNode.parentNode.insertBefore(p, targetEl.parentNode.nextSibling);
                        } else if (elementId === 'coordinate-input') {
                            targetEl.parentNode.parentNode.insertBefore(p, targetEl.parentNode.nextSibling);
                        } else if (elementId === 'kbli-search') {
                            const kbliContainer = document.getElementById('kbli-container');
                            kbliContainer.parentNode.insertBefore(p, kbliContainer.nextSibling);
                        } else if (targetEl.nextElementSibling && targetEl.nextElementSibling.classList.contains('custom-search-wrapper')) {
                            targetEl.parentNode.insertBefore(p, targetEl.nextElementSibling.nextSibling);
                        } else {
                            targetEl.parentNode.insertBefore(p, targetEl.nextSibling);
                        }
                    }
                }
                
                if (step === 1) {
                    if (!document.getElementById('company-name').value.trim()) showError('company-name', 'Nama perusahaan wajib diisi');
                    
                    const pelakuUsaha = document.getElementById('pelaku-usaha').value;
                    if (!pelakuUsaha) {
                        showError('pelaku-usaha', 'Pilih jenis pelaku usaha');
                    } else {
                        if (pelakuUsaha === 'orang-perseorangan' && !document.getElementById('nik-perseorangan').value.trim()) {
                            showError('nik-perseorangan', 'NIK wajib diisi');
                        } else if (pelakuUsaha === 'badan-usaha' && !document.getElementById('jenis-badan-usaha').value) {
                            showError('jenis-badan-usaha', 'Pilih jenis badan usaha');
                        } else if (pelakuUsaha === 'kantor-perwakilan' && !document.getElementById('jenis-kantor-perwakilan').value) {
                            showError('jenis-kantor-perwakilan', 'Pilih jenis kantor perwakilan');
                        } else if (pelakuUsaha === 'badan-usaha-luar-negeri' && !document.getElementById('jenis-badan-usaha-luar-negeri').value) {
                            showError('jenis-badan-usaha-luar-negeri', 'Pilih jenis badan usaha luar negeri');
                        }
                    }
                    
                    if (selectedKbli.length === 0) {
                        showError('kbli-search', 'Pilih setidaknya satu kode KBLI', 'kbli-container');
                    }
                }
                else if (step === 2) {
                    const nationality = document.querySelector('input[name="kewarganegaraan"]:checked');
                    
                    if (!document.getElementById('nama-pimpinan').value.trim()) showError('nama-pimpinan', 'Nama pimpinan wajib diisi');
                    if (!document.getElementById('jabatan-pimpinan').value.trim()) showError('jabatan-pimpinan', 'Jabatan pimpinan wajib diisi');
                    
                    if (nationality && nationality.value === 'WNA') {
                        if (!document.getElementById('nik-pimpinan').value.trim()) showError('nik-pimpinan', 'Nomor paspor wajib diisi');
                        if (!document.getElementById('nationality-pimpinan').value) showError('nationality-pimpinan', 'Pilih negara kewarganegaraan');
                    } else {
                        const pimpinanContainer = document.getElementById('container-nik-pimpinan');
                        if (pimpinanContainer && !pimpinanContainer.classList.contains('hidden') && !document.getElementById('nik-pimpinan').value.trim()) {
                            showError('nik-pimpinan', 'NIK wajib diisi');
                        }
                    }
                    
                    if (!document.getElementById('nib-number').value.trim()) showError('nib-number', 'NIB wajib diisi');
                    if (!document.getElementById('nib-link').value.trim()) showError('nib-link', 'Link dokumen NIB wajib diisi');
                    
                    if (!document.getElementById('npwp-number').value.trim()) showError('npwp-number', 'NPWP wajib diisi');
                    if (!document.getElementById('npwp-link').value.trim()) showError('npwp-link', 'Link dokumen NPWP wajib diisi');
                }
                else if (step === 3) {
                    if (!document.getElementById('provinsi-kantor').value) showError('provinsi-kantor', 'Provinsi wajib dipilih');
                    if (!document.getElementById('kabupaten-kantor').value) showError('kabupaten-kantor', 'Kabupaten/Kota wajib dipilih');
                    if (!document.getElementById('kecamatan-kantor').value) showError('kecamatan-kantor', 'Kecamatan wajib dipilih');
                    if (!document.getElementById('desa-kantor').value) showError('desa-kantor', 'Desa/Kelurahan wajib dipilih');
                    if (!document.getElementById('alamat-kantor').value.trim()) showError('alamat-kantor', 'Alamat lengkap wajib diisi');
                    
                    const isSameLocation = document.getElementById('same-as-office').checked;
                    if (!isSameLocation) {
                        if (!document.getElementById('provinsi-usaha').value) showError('provinsi-usaha', 'Provinsi wajib dipilih');
                        if (!document.getElementById('kabupaten-usaha').value) showError('kabupaten-usaha', 'Kabupaten/Kota wajib dipilih');
                        if (!document.getElementById('kecamatan-usaha').value) showError('kecamatan-usaha', 'Kecamatan wajib dipilih');
                        if (!document.getElementById('desa-usaha').value) showError('desa-usaha', 'Desa/Kelurahan wajib dipilih');
                        if (!document.getElementById('alamat-usaha').value.trim()) showError('alamat-usaha', 'Alamat lengkap usaha wajib diisi');
                    }
                    
                    if (!document.getElementById('coordinate-input').value.trim()) showError('coordinate-input', 'Koordinat lokasi wajib diisi');
                }
                
                return isValid;
            }

            btnNext.addEventListener('click', () => {
                if (!validateStep(currentStep)) return;
                
                if (currentStep < totalSteps) {
                    // normally validate form fields here
                    
                    // If moving to step 4, populate summary
                    if (currentStep === 3) {
                        document.getElementById('summary-company-name').textContent = document.getElementById('company-name').value || '-';
                        const pelakuUsahaSelectEl = document.getElementById('pelaku-usaha');
                        const pelakuUsahaVal = pelakuUsahaSelectEl.value;
                        let pelakuUsahaText = pelakuUsahaSelectEl.options[pelakuUsahaSelectEl.selectedIndex]?.text || '-';
                        let detailUsahaText = '';
                        
                        if (pelakuUsahaVal === 'orang-perseorangan') {
                            detailUsahaText = ' (NIK: ' + (document.getElementById('nik-perseorangan').value || '-') + ')';
                        } else if (pelakuUsahaVal === 'badan-usaha') {
                            const detailSelect = document.getElementById('jenis-badan-usaha');
                            detailUsahaText = detailSelect.value ? (' - ' + (detailSelect.options[detailSelect.selectedIndex]?.text || '')) : '';
                        } else if (pelakuUsahaVal === 'kantor-perwakilan') {
                            const detailSelect = document.getElementById('jenis-kantor-perwakilan');
                            detailUsahaText = detailSelect.value ? (' - ' + (detailSelect.options[detailSelect.selectedIndex]?.text || '')) : '';
                        } else if (pelakuUsahaVal === 'badan-usaha-luar-negeri') {
                            const detailSelect = document.getElementById('jenis-badan-usaha-luar-negeri');
                            detailUsahaText = detailSelect.value ? (' - ' + (detailSelect.options[detailSelect.selectedIndex]?.text || '')) : '';
                        }
                        
                        document.getElementById('summary-jenis-usaha').textContent = pelakuUsahaText + detailUsahaText;
                        const kbliSummaryContainer = document.getElementById('summary-kode-kbli');
                        if (selectedKbli.length > 0) {
                            kbliSummaryContainer.innerHTML = selectedKbli.map(k => `<div class="mb-1 leading-tight"><span class="font-semibold">${k.id}</span> - <span class="text-xs text-gray-500 block">${k.nama}</span></div>`).join('');
                        } else {
                            kbliSummaryContainer.textContent = '-';
                        }
                        
                        document.getElementById('summary-pimpinan').textContent = document.getElementById('nama-pimpinan').value || '-';
                        document.getElementById('summary-jabatan').textContent = document.getElementById('jabatan-pimpinan').value || '-';
                        document.getElementById('summary-nib').textContent = document.getElementById('nib-number').value || '-';
                        document.getElementById('summary-npwp').textContent = document.getElementById('npwp-number').value || '-';
                        
                        document.getElementById('summary-alamat-kantor').textContent = document.getElementById('alamat-kantor').value || '-';
                        
                        // Check if same location checkbox is checked
                        const isSame = document.getElementById('same-as-office')?.checked;
                        document.getElementById('summary-alamat-usaha').textContent = isSame ? 
                            (document.getElementById('alamat-kantor').value || '-') : 
                            (document.getElementById('alamat-usaha').value || '-');
                    }
                    
                    currentStep++;
                    updateUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
            
            btnPrev.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
            
            // Checkbox logic for same location
            const sameAsOffice = document.getElementById('same-as-office');
            const usahaFields = document.getElementById('usaha-location-fields');
            
            if(sameAsOffice) {
                sameAsOffice.addEventListener('change', function() {
                    if(this.checked) {
                        usahaFields.classList.add('opacity-40', 'pointer-events-none', 'grayscale');
                        // Optional: Clear values or copy values from primary office fields
                    } else {
                        usahaFields.classList.remove('opacity-40', 'pointer-events-none', 'grayscale');
                    }
                });
            }
            
            // Pelaku Usaha Logic
            const pelakuUsahaSelect = document.getElementById('pelaku-usaha');
            const subPelakuUsahaContainer = document.getElementById('sub-pelaku-usaha-container');
            const containerNik = document.getElementById('container-nik');
            const containerBadanUsaha = document.getElementById('container-badan-usaha');
            const containerKantorPerwakilan = document.getElementById('container-kantor-perwakilan');
            const containerBadanUsahaLuarNegeri = document.getElementById('container-badan-usaha-luar-negeri');
            const pimpinanGrid = document.getElementById('pimpinan-grid');
            const containerJabatan = document.getElementById('container-jabatan');
            const containerSamaDenganNik = document.getElementById('container-sama-dengan-nik');
            const labelNpwpPerusahaan = document.getElementById('label-npwp-perusahaan');
            
            // New UI Elements
            const containerKewarganegaraanRadio = document.getElementById('container-kewarganegaraan-radio');
            const containerNikPimpinan = document.getElementById('container-nik-pimpinan');
            const wniRadio = document.querySelector('input[name="kewarganegaraan"][value="WNI"]');
            
            // Kewarganegaraan Logic
            const kewarganegaraanRadios = document.querySelectorAll('input[name="kewarganegaraan"]');
            const labelNikPimpinan = document.getElementById('label-nik-pimpinan');
            const inputNikPimpinan = document.getElementById('nik-pimpinan');
            const containerNationality = document.getElementById('container-nationality');

            function triggerKewarganegaraanChange() {
                const selected = document.querySelector('input[name="kewarganegaraan"]:checked');
                if (!selected) return;
                
                if (selected.value === 'WNA') {
                    if (labelNikPimpinan) labelNikPimpinan.innerHTML = 'Nomor Paspor / Passport <span class="text-red-500">*</span>';
                    if (inputNikPimpinan) inputNikPimpinan.placeholder = 'Nomor Paspor / Passport Number';
                    if (containerNationality) containerNationality.classList.remove('hidden');
                } else {
                    if (labelNikPimpinan) labelNikPimpinan.innerHTML = 'NIK <span class="text-red-500">*</span>';
                    if (inputNikPimpinan) inputNikPimpinan.placeholder = '16 Digit NIK';
                    if (containerNationality) containerNationality.classList.add('hidden');
                }
            }

            if (kewarganegaraanRadios) {
                kewarganegaraanRadios.forEach(radio => {
                    radio.addEventListener('change', triggerKewarganegaraanChange);
                });
            }

            if (pelakuUsahaSelect) {
                pelakuUsahaSelect.addEventListener('change', function() {
                    const val = this.value;
                    
                    subPelakuUsahaContainer.classList.remove('hidden');
                    containerNik.classList.add('hidden');
                    containerBadanUsaha.classList.add('hidden');
                    containerKantorPerwakilan.classList.add('hidden');
                    containerBadanUsahaLuarNegeri.classList.add('hidden');
                    
                    // Reset step 2 fields
                    if (containerJabatan) containerJabatan.classList.remove('hidden');
                    if (pimpinanGrid) pimpinanGrid.classList.add('md:grid-cols-2');
                    if (containerSamaDenganNik) containerSamaDenganNik.classList.add('hidden');
                    if (labelNpwpPerusahaan) labelNpwpPerusahaan.style.display = 'inline';
                    
                    // Reset New UI Elements
                    if (containerKewarganegaraanRadio) containerKewarganegaraanRadio.classList.add('hidden');
                    if (containerNikPimpinan) containerNikPimpinan.classList.add('hidden');
                    if (wniRadio) wniRadio.checked = true;
                    triggerKewarganegaraanChange();
                    
                    if (val === 'orang-perseorangan') {
                        containerNik.classList.remove('hidden');
                        if (containerJabatan) containerJabatan.classList.add('hidden');
                        if (pimpinanGrid) pimpinanGrid.classList.remove('md:grid-cols-2');
                        if (containerSamaDenganNik) containerSamaDenganNik.classList.remove('hidden');
                        if (labelNpwpPerusahaan) labelNpwpPerusahaan.style.display = 'none';
                    } else {
                        // All non-perseorangan have NIK pimpinan
                        if (containerNikPimpinan) containerNikPimpinan.classList.remove('hidden');

                        if (val === 'badan-usaha') {
                            containerBadanUsaha.classList.remove('hidden');
                        } else if (val === 'kantor-perwakilan') {
                            containerKantorPerwakilan.classList.remove('hidden');
                            if (containerKewarganegaraanRadio) containerKewarganegaraanRadio.classList.remove('hidden');
                        } else if (val === 'badan-usaha-luar-negeri') {
                            containerBadanUsahaLuarNegeri.classList.remove('hidden');
                            if (containerKewarganegaraanRadio) containerKewarganegaraanRadio.classList.remove('hidden');
                        }
                    }
                });
            }
            
            // Sama dengan NIK Logic
            const samaDenganNik = document.getElementById('sama-dengan-nik');
            const nikInput = document.getElementById('nik-perseorangan');
            const npwpInput = document.getElementById('npwp-number');

            if (samaDenganNik && nikInput && npwpInput) {
                samaDenganNik.addEventListener('change', function() {
                    if (this.checked) {
                        npwpInput.value = nikInput.value;
                        npwpInput.readOnly = true;
                        npwpInput.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                    } else {
                        npwpInput.value = '';
                        npwpInput.readOnly = false;
                        npwpInput.classList.remove('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                    }
                });
                
                nikInput.addEventListener('input', function() {
                    if (samaDenganNik.checked) {
                        npwpInput.value = this.value;
                    }
                });
            }

            // Custom Searchable Dropdown Logic
            function makeSearchable(selectId) {
                const select = document.getElementById(selectId);
                if (!select) return;

                select.style.display = 'none';

                const existingWrapper = select.parentNode.querySelector('.custom-search-wrapper');
                if (existingWrapper) {
                    existingWrapper.remove();
                }

                const wrapper = document.createElement('div');
                wrapper.className = 'relative custom-search-wrapper w-full';
                
                const getSelectedText = () => {
                    const opt = select.options[select.selectedIndex];
                    return opt ? opt.text : 'Pilih...';
                };

                const isDisabled = select.disabled;

                wrapper.innerHTML = `
                    <div class="search-select-trigger flex items-center justify-between w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-colors ${isDisabled ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white cursor-pointer hover:border-blue-400'}">
                        <span class="truncate display-text">${getSelectedText()}</span>
                        <i class="ph ph-caret-down text-gray-400"></i>
                    </div>
                    <div class="search-select-dropdown absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-xl hidden flex flex-col">
                        <div class="p-2 border-b border-gray-100 sticky top-0 bg-white z-10">
                            <div class="relative">
                                <i class="ph ph-magnifying-glass absolute left-2 top-2 text-gray-400"></i>
                                <input type="text" class="w-full text-sm outline-none pl-7 pr-2 py-1.5 bg-gray-50 rounded border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 search-input" placeholder="Cari...">
                            </div>
                        </div>
                        <ul class="py-1 text-sm text-gray-700 max-h-48 overflow-y-auto option-list">
                        </ul>
                    </div>
                `;

                select.parentNode.insertBefore(wrapper, select.nextSibling);

                const trigger = wrapper.querySelector('.search-select-trigger');
                const dropdown = wrapper.querySelector('.search-select-dropdown');
                const searchInput = wrapper.querySelector('.search-input');
                const optionList = wrapper.querySelector('.option-list');
                const displayText = wrapper.querySelector('.display-text');

                function renderOptions(filter = '') {
                    optionList.innerHTML = '';
                    const lowerFilter = filter.toLowerCase();
                    let hasOptions = false;

                    Array.from(select.options).forEach((opt, index) => {
                        if (opt.disabled || opt.value === '') return;

                        if (opt.text.toLowerCase().includes(lowerFilter)) {
                            hasOptions = true;
                            const li = document.createElement('li');
                            li.className = 'px-3 py-2 hover:bg-blue-50 cursor-pointer transition-colors';
                            if (select.selectedIndex === index) {
                                li.className += ' bg-blue-100 text-blue-700 font-medium';
                            }
                            li.textContent = opt.text;
                            li.addEventListener('mousedown', (e) => {
                                e.preventDefault(); // prevent input blur
                                select.selectedIndex = index;
                                displayText.textContent = opt.text;
                                closeDropdown();
                                select.dispatchEvent(new Event('change'));
                            });
                            optionList.appendChild(li);
                        }
                    });

                    if (!hasOptions) {
                        optionList.innerHTML = '<li class="px-3 py-2 text-gray-400 italic text-center">Tidak ditemukan</li>';
                    }
                }

                function openDropdown() {
                    if (select.disabled) return;
                    dropdown.classList.remove('hidden');
                    renderOptions();
                    searchInput.value = '';
                    setTimeout(() => searchInput.focus(), 10);
                }

                function closeDropdown() {
                    dropdown.classList.add('hidden');
                }

                trigger.addEventListener('click', (e) => {
                    if (dropdown.classList.contains('hidden')) {
                        document.querySelectorAll('.search-select-dropdown:not(.hidden)').forEach(d => d.classList.add('hidden'));
                        openDropdown();
                    } else {
                        closeDropdown();
                    }
                });

                searchInput.addEventListener('input', (e) => {
                    renderOptions(e.target.value);
                });

                document.addEventListener('mousedown', (e) => {
                    if (!wrapper.contains(e.target)) {
                        closeDropdown();
                    }
                });
            }

            // Region Cascading Logic
            const selectIds = [
                'provinsi-kantor', 'kabupaten-kantor', 'kecamatan-kantor', 'desa-kantor',
                'provinsi-usaha', 'kabupaten-usaha', 'kecamatan-usaha', 'desa-usaha'
            ];
            
            // Initialize on load
            selectIds.forEach(id => makeSearchable(id));

            function updateDropdown(id, html, disabled) {
                const el = document.getElementById(id);
                el.innerHTML = html;
                el.disabled = disabled;
                makeSearchable(id);
            }

            window.loadRegencies = async function(provinceId, targetSelectId) {
                updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
                
                let isKantor = targetSelectId.includes('kantor');
                updateDropdown(isKantor ? 'kecamatan-kantor' : 'kecamatan-usaha', '<option selected disabled value="">Pilih Kecamatan...</option>', true);
                updateDropdown(isKantor ? 'desa-kantor' : 'desa-usaha', '<option selected disabled value="">Pilih Desa...</option>', true);
                
                const response = await fetch(`/api/regencies/${provinceId}`);
                const data = await response.json();
                
                let html = '<option selected disabled value="">Pilih Kabupaten...</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
                updateDropdown(targetSelectId, html, false);
            };

            window.loadDistricts = async function(regencyId, targetSelectId) {
                updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
                
                let isKantor = targetSelectId.includes('kantor');
                updateDropdown(isKantor ? 'desa-kantor' : 'desa-usaha', '<option selected disabled value="">Pilih Desa...</option>', true);
                
                const response = await fetch(`/api/districts/${regencyId}`);
                const data = await response.json();
                
                let html = '<option selected disabled value="">Pilih Kecamatan...</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
                updateDropdown(targetSelectId, html, false);
            };

            window.loadVillages = async function(districtId, targetSelectId) {
                updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
                
                const response = await fetch(`/api/villages/${districtId}`);
                const data = await response.json();
                
                let html = '<option selected disabled value="">Pilih Desa...</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
                updateDropdown(targetSelectId, html, false);
            };

            // KBLI Multiselect Logic
            const kbliData = @json($kblis->map(function($kbli) {
                return ['id' => $kbli->code, 'nama' => $kbli->name];
            }));
            let selectedKbli = [];
            
            const kbliContainer = document.getElementById('kbli-container');
            const kbliSearch = document.getElementById('kbli-search');
            const kbliDropdown = document.getElementById('kbli-dropdown');
            const kbliList = document.getElementById('kbli-list');
            const kbliChips = document.getElementById('kbli-chips');
            
            function renderKbliChips() {
                kbliChips.innerHTML = '';
                selectedKbli.forEach(item => {
                    const chip = document.createElement('div');
                    chip.className = 'flex items-center gap-1 bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium border border-blue-200';
                    chip.innerHTML = `
                        <span>${item.id}</span>
                        <button type="button" class="text-blue-600 hover:text-blue-900 focus:outline-none" onclick="window.removeKbli('${item.id}')">
                            <i class="ph ph-x"></i>
                        </button>
                    `;
                    kbliChips.appendChild(chip);
                });
                
                // Update hidden input for form submission
                const kblisInput = document.getElementById('kblis-input');
                if (kblisInput) {
                    kblisInput.value = JSON.stringify(selectedKbli.map(k => k.id));
                }
            }
            
            window.removeKbli = function(id) {
                selectedKbli = selectedKbli.filter(item => item.id !== id);
                renderKbliChips();
                renderKbliDropdown();
            };
            
            function renderKbliDropdown(filter = '') {
                kbliList.innerHTML = '';
                const lowerFilter = filter.toLowerCase();
                const filtered = kbliData.filter(item => 
                    (item.id.toLowerCase().includes(lowerFilter) || item.nama.toLowerCase().includes(lowerFilter)) &&
                    !selectedKbli.some(selected => selected.id === item.id)
                );
                
                if (filtered.length === 0) {
                    kbliList.innerHTML = '<li class="px-4 py-2 text-gray-500 italic">Tidak ada hasil ditemukan</li>';
                    return;
                }
                
                filtered.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-2 hover:bg-blue-50 cursor-pointer flex flex-col border-b border-gray-100 last:border-0';
                    li.innerHTML = `
                        <span class="font-semibold text-blue-700">${item.id}</span>
                        <span class="text-xs text-gray-600">${item.nama}</span>
                    `;
                    li.addEventListener('mousedown', (e) => {
                        e.preventDefault(); // prevent input blur
                        selectedKbli.push(item);
                        renderKbliChips();
                        kbliSearch.value = '';
                        renderKbliDropdown();
                        kbliSearch.focus();
                    });
                    kbliList.appendChild(li);
                });
            }
            
            // Show dropdown on focus or click
            if(kbliSearch) {
                kbliSearch.addEventListener('focus', () => {
                    kbliDropdown.classList.remove('hidden');
                    renderKbliDropdown(kbliSearch.value);
                });
                kbliContainer.addEventListener('click', () => {
                    kbliSearch.focus();
                });
                
                // Filter on input
                kbliSearch.addEventListener('input', (e) => {
                    kbliDropdown.classList.remove('hidden');
                    renderKbliDropdown(e.target.value);
                });
                
                // Hide dropdown on blur
                kbliSearch.addEventListener('blur', () => {
                    kbliDropdown.classList.add('hidden');
                });
            }
            
            // Map Implementation Logic
            let interactiveMap = null;
            let previewMap = null;
            let marker = null;
            let previewMarker = null;
            let currentLat = -0.789275; // Default center (Indonesia)
            let currentLng = 113.921327;
            
            const btnOpenMap = document.getElementById('btn-open-map');
            const mapModal = document.getElementById('map-picker-modal');
            const btnCloseMap = document.getElementById('btn-close-map');
            const btnCancelMap = document.getElementById('btn-cancel-map');
            const btnSaveMap = document.getElementById('btn-save-map');
            const tempCoordinate = document.getElementById('temp-coordinate');
            const coordinateInput = document.getElementById('coordinate-input');
            const previewPlaceholder = document.getElementById('map-preview-placeholder');
            const previewContainer = document.getElementById('map-preview');

            function initMaps() {
                // Initialize Preview Map
                previewMap = L.map('map-preview', {
                    zoomControl: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    touchZoom: false,
                    dragging: false
                }).setView([currentLat, currentLng], 5);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(previewMap);

                // Initialize Interactive Map
                interactiveMap = L.map('interactive-map').setView([currentLat, currentLng], 5);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(interactiveMap);

                // Add marker on click
                interactiveMap.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    
                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(interactiveMap);
                    }
                    
                    currentLat = lat;
                    currentLng = lng;
                    tempCoordinate.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                });
            }

            function openMapModal() {
                mapModal.classList.remove('hidden');
                
                // Parse existing input if available
                if(coordinateInput.value) {
                    const parts = coordinateInput.value.split(',');
                    if(parts.length === 2) {
                        currentLat = parseFloat(parts[0].trim());
                        currentLng = parseFloat(parts[1].trim());
                        tempCoordinate.textContent = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                    }
                }

                // Leaflet requires invalidateSize when container changes visibility
                setTimeout(() => {
                    interactiveMap.invalidateSize();
                    interactiveMap.setView([currentLat, currentLng], marker ? 15 : 5);
                    if(coordinateInput.value && !marker) {
                        marker = L.marker([currentLat, currentLng]).addTo(interactiveMap);
                    } else if (marker) {
                        marker.setLatLng([currentLat, currentLng]);
                    }
                }, 100);
            }

            function closeMapModal() {
                mapModal.classList.add('hidden');
            }

            function saveCoordinates() {
                if (marker) {
                    coordinateInput.value = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                    
                    // Safe check if summary field exists (it doesn't currently)
                    const summaryKoor = document.getElementById('summary-koordinat');
                    if (summaryKoor) {
                        summaryKoor.textContent = coordinateInput.value;
                    }
                    
                    // Update preview map
                    previewPlaceholder.style.opacity = '0';
                    setTimeout(() => previewPlaceholder.classList.add('hidden'), 300);
                    
                    previewContainer.style.opacity = '1';
                    previewMap.invalidateSize();
                    previewMap.setView([currentLat, currentLng], 15);
                    
                    if (previewMarker) {
                        previewMarker.setLatLng([currentLat, currentLng]);
                    } else {
                        previewMarker = L.marker([currentLat, currentLng]).addTo(previewMap);
                    }
                }
                closeMapModal();
            }

            // Bind Events
            if (btnOpenMap) btnOpenMap.addEventListener('click', openMapModal);
            if (btnCloseMap) btnCloseMap.addEventListener('click', closeMapModal);
            if (btnCancelMap) btnCancelMap.addEventListener('click', closeMapModal);
            if (btnSaveMap) btnSaveMap.addEventListener('click', saveCoordinates);
            
            // Allow manual input formatting
            if (coordinateInput) {
                const processManualInput = function(val) {
                    if(val) {
                        const parts = val.split(',');
                        if(parts.length === 2) {
                            currentLat = parseFloat(parts[0].trim());
                            currentLng = parseFloat(parts[1].trim());
                            if(!isNaN(currentLat) && !isNaN(currentLng)) {
                                coordinateInput.value = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                                
                                // Create or update the real Leaflet marker
                                if (!marker) {
                                    marker = L.marker([currentLat, currentLng]).addTo(interactiveMap);
                                } else {
                                    marker.setLatLng([currentLat, currentLng]);
                                }
                                
                                saveCoordinates();
                            }
                        }
                    }
                };

                coordinateInput.addEventListener('blur', function() {
                    processManualInput(this.value);
                });

                coordinateInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault(); // Prevent form submission
                        processManualInput(this.value);
                    }
                });
            }

            // Initialize maps on load
            initMaps();
        });
    </script>
