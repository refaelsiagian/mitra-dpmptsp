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

                    // Skala Usaha Logic
                    const skalaUsahaContainer = document.getElementById('container-skala-usaha');
                    const skalaUsahaSelect = document.getElementById('skala-usaha');
                    
                    if (skalaUsahaContainer && skalaUsahaSelect) {
                        skalaUsahaContainer.classList.remove('hidden');
                        skalaUsahaSelect.disabled = false;
                        
                        // Enable all options first
                        Array.from(skalaUsahaSelect.options).forEach(opt => opt.disabled = false);
                        
                        if (val === 'orang-perseorangan') {
                            // Only allow mikro and kecil
                            Array.from(skalaUsahaSelect.options).forEach(opt => {
                                if (opt.value === 'menengah' || opt.value === 'besar') opt.disabled = true;
                            });
                            // If current selection is invalid, reset it
                            if (['menengah', 'besar'].includes(skalaUsahaSelect.value)) {
                                skalaUsahaSelect.value = '';
                            }
                        } else if (val === 'kantor-perwakilan' || val === 'badan-usaha-luar-negeri') {
                            // Force besar and lock options instead of the select itself
                            skalaUsahaSelect.value = 'besar';
                            skalaUsahaSelect.disabled = false; // Must be false so it submits
                            Array.from(skalaUsahaSelect.options).forEach(opt => {
                                if (opt.value !== 'besar' && opt.value !== '') opt.disabled = true;
                            });
                        } else {
                            // Badan Usaha: all open
                            // No options disabled
                        }
                    }
                    
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

            // PKP Logic
            const pkpYes = document.querySelector('input[name="is_pkp"][value="1"]');
            const pkpNo = document.querySelector('input[name="is_pkp"][value="0"]');
            const pkpLinkContainer = document.getElementById('container-pkp-link');
            const pkpHelperText = document.getElementById('pkp-helper-text');
            const pkpLinkInput = document.getElementById('pkp-link');
            const skalaUsahaSelectPKP = document.getElementById('skala-usaha');

            function updatePKPVisibility() {
                if (pkpYes && pkpYes.checked) {
                    pkpLinkContainer.classList.remove('hidden');
                } else {
                    pkpLinkContainer.classList.add('hidden');
                }
            }
            
            window.enforcePKPRules = function() {
                if (skalaUsahaSelectPKP && pkpYes && pkpNo) {
                    const skala = skalaUsahaSelectPKP.value;
                    if (skala === 'menengah' || skala === 'besar') {
                        pkpYes.checked = true;
                        pkpNo.disabled = true;
                        pkpHelperText.classList.remove('hidden');
                        updatePKPVisibility();
                    } else {
                        pkpNo.disabled = false;
                        pkpHelperText.classList.add('hidden');
                    }
                }
            };

            if (pkpYes && pkpNo) {
                pkpYes.addEventListener('change', updatePKPVisibility);
                pkpNo.addEventListener('change', updatePKPVisibility);
            }
            
            if (skalaUsahaSelectPKP) {
                skalaUsahaSelectPKP.addEventListener('change', window.enforcePKPRules);
            }
