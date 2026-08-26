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
            
            btnNext.addEventListener('click', () => {
                if (typeof validateStep === 'function' && !validateStep(currentStep)) return;
                
                if (currentStep === 2) {
                    if (typeof window.isNibChecking !== 'undefined' && window.isNibChecking) {
                        const nibInput = document.getElementById('nib-number');
                        if (nibInput) nibInput.focus();
                        return;
                    }
                    
                    if (typeof window.isNibValid !== 'undefined' && !window.isNibValid) {
                        const nibInput = document.getElementById('nib-number');
                        if (nibInput) {
                            nibInput.focus();
                            // Flash the error
                            const err = document.getElementById('nib-error-message');
                            if(err) {
                                err.classList.add('animate-pulse');
                                setTimeout(() => err.classList.remove('animate-pulse'), 1000);
                            }
                        }
                        return;
                    }
                }
                
                if (currentStep < totalSteps) {
                    // normally validate form fields here
                    if (currentStep === 1 && typeof enforcePKPRules === 'function') {
                        enforcePKPRules();
                    }
                    
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
                        if (typeof selectedKbli !== 'undefined' && selectedKbli.length > 0) {
                            kbliSummaryContainer.innerHTML = selectedKbli.map(k => `<div class="mb-1 leading-tight"><span class="font-semibold">${k.id}</span> - <span class="text-xs text-gray-500 block">${k.nama}</span></div>`).join('');
                        } else {
                            kbliSummaryContainer.textContent = '-';
                        }
                        
                        document.getElementById('summary-pimpinan').textContent = document.getElementById('nama-pimpinan').value || '-';
                        document.getElementById('summary-jabatan').textContent = document.getElementById('jabatan-pimpinan').value || '-';
                        
                        // Kewarganegaraan & Identitas
                        const wniRadio = document.querySelector('input[name="kewarganegaraan"][value="WNI"]');
                        const isWNI = wniRadio && wniRadio.checked;
                        
                        if (isWNI) {
                            document.getElementById('summary-kewarganegaraan').textContent = 'WNI (Warga Negara Indonesia)';
                            document.getElementById('summary-label-identitas').textContent = 'NIK';
                            document.getElementById('summary-identitas').textContent = document.getElementById('nik-pimpinan').value || '-';
                        } else {
                            const nationalitySelect = document.getElementById('nationality-pimpinan');
                            const nationalityText = nationalitySelect.options[nationalitySelect.selectedIndex]?.text || '-';
                            document.getElementById('summary-kewarganegaraan').textContent = 'WNA (' + nationalityText + ')';
                            document.getElementById('summary-label-identitas').textContent = 'Nomor Paspor';
                            document.getElementById('summary-identitas').textContent = document.getElementById('nik-pimpinan').value || '-';
                        }

                        document.getElementById('summary-nib').textContent = document.getElementById('nib-number').value || '-';
                        document.getElementById('summary-npwp').textContent = document.getElementById('npwp-number').value || '-';
                        
                        const pkpCheckYes = document.querySelector('input[name="is_pkp"][value="1"]');
                        if (pkpCheckYes && pkpCheckYes.checked) {
                            document.getElementById('summary-pkp').innerHTML = `<span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded border border-green-200 font-bold">SUDAH PKP</span>`;
                        } else {
                            document.getElementById('summary-pkp').innerHTML = `<span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs rounded border border-gray-200 font-bold">BELUM PKP</span>`;
                        }
                        
                        // Region summary helper
                        const getRegionText = (type) => {
                            const prov = document.getElementById('provinsi-' + type);
                            const kab = document.getElementById('kabupaten-' + type);
                            const kec = document.getElementById('kecamatan-' + type);
                            const desa = document.getElementById('desa-' + type);
                            
                            const parts = [];
                            if (desa && desa.value) parts.push(desa.options[desa.selectedIndex]?.text);
                            if (kec && kec.value) parts.push(kec.options[kec.selectedIndex]?.text);
                            if (kab && kab.value) parts.push(kab.options[kab.selectedIndex]?.text);
                            if (prov && prov.value) parts.push(prov.options[prov.selectedIndex]?.text);
                            
                            return parts.join(', ');
                        };
                        
                        document.getElementById('summary-region-kantor').textContent = getRegionText('kantor') || '-';
                        document.getElementById('summary-alamat-kantor').textContent = document.getElementById('alamat-kantor').value || '-';
                        
                        // Check if same location checkbox is checked
                        const isSame = document.getElementById('same-as-office')?.checked;
                        
                        if (isSame) {
                            document.getElementById('summary-region-usaha').textContent = document.getElementById('summary-region-kantor').textContent;
                        } else {
                            document.getElementById('summary-region-usaha').textContent = getRegionText('usaha') || '-';
                        }
                        
                        document.getElementById('summary-alamat-usaha').textContent = isSame ? 
                            (document.getElementById('alamat-kantor').value || '-') : 
                            (document.getElementById('alamat-usaha').value || '-');
                    }
                    
                    currentStep++;
                    updateUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    
                    // Fix map rendering issue when becoming visible
                    if (currentStep === 3 && typeof previewMap !== 'undefined' && previewMap) {
                        setTimeout(() => previewMap.invalidateSize(), 100);
                    }
                }
            });
            
            btnPrev.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            // NIB Real-time Validation
            window.isNibValid = true;
            window.isNibChecking = false;
            const nibInput = document.getElementById('nib-number');
            const nibError = document.getElementById('nib-error-message');
            if (nibInput && nibError) {
                let nibTimeout = null;
                
                // Initialize state if it's already filled and invalid length
                if (nibInput.value.length > 0 && nibInput.value.length < 13) {
                    // Let normal validation handle this, we only check existence
                }

                nibInput.addEventListener('input', () => {
                    const val = nibInput.value.replace(/[^0-9]/g, '');
                    nibInput.value = val; // enforce numbers only
                    
                    // Reset styling immediately
                    nibError.classList.add('hidden');
                    nibInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                    nibInput.classList.add('border-gray-300', 'focus:border-blue-600', 'focus:ring-blue-600');
                    window.isNibValid = true;
                    window.isNibChecking = false;

                    if (val.length === 13) {
                        window.isNibChecking = true;
                        window.isNibValid = false; // assume invalid until API returns true
                        
                        clearTimeout(nibTimeout);
                        nibTimeout = setTimeout(async () => {
                            try {
                                const res = await fetch(`/api/check-nib/${val}`);
                                const data = await res.json();
                                if (data.exists) {
                                    window.isNibValid = false;
                                    nibError.classList.remove('hidden');
                                    nibInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                                    nibInput.classList.remove('border-gray-300', 'focus:border-blue-600', 'focus:ring-blue-600');
                                } else {
                                    window.isNibValid = true;
                                }
                            } catch (e) {
                                console.error('NIB check failed:', e);
                                window.isNibValid = true; // allow if API fails
                            } finally {
                                window.isNibChecking = false;
                            }
                        }, 400);
                    }
                });
            }

            // Prevent Enter key from submitting the form prematurely
            const verifyForm = document.getElementById('verify-form');
            if (verifyForm) {
                verifyForm.addEventListener('keydown', function(e) {
                    // Only intercept Enter key
                    if (e.key === 'Enter') {
                        // Allow enter in textareas to create new lines
                        if (e.target.tagName.toLowerCase() === 'textarea') {
                            return;
                        }
                        
                        // Prevent the default form submission
                        e.preventDefault();
                        
                        // Map it to the 'Next' button if not on the last step
                        if (currentStep < totalSteps) {
                            btnNext.click();
                        } else {
                            // If on the last step, allow submission
                            btnSubmit.click();
                        }
                    }
                });
                
                // Ensure disabled fields are submitted
                verifyForm.addEventListener('submit', function() {
                    verifyForm.querySelectorAll('select:disabled').forEach(el => {
                        el.disabled = false;
                    });
                });
            }

            // Skala Usaha -> Province lock logic
            const skalaUsahaSelect = document.getElementById('skala-usaha');
            if (skalaUsahaSelect) {
                skalaUsahaSelect.addEventListener('change', function() {
                    const notice = document.getElementById('umkm-notice');
                    if (['mikro', 'kecil', 'menengah'].includes(this.value)) {
                        if (notice) notice.classList.remove('hidden');
                        ['provinsi-kantor', 'provinsi-usaha'].forEach(id => {
                            const select = document.getElementById(id);
                            if (select) {
                                Array.from(select.options).forEach(opt => {
                                    if (opt.text.trim().toUpperCase() === 'SUMATERA UTARA') {
                                        if (select.value !== opt.value) {
                                            select.value = opt.value;
                                            select.dispatchEvent(new Event('change', { bubbles: true }));
                                        }
                                        select.disabled = true;
                                    }
                                });
                            }
                        });
                    } else {
                        if (notice) notice.classList.add('hidden');
                        // If changed back to non-umkm, unlock the province selects
                        ['provinsi-kantor', 'provinsi-usaha'].forEach(id => {
                            const select = document.getElementById(id);
                            if (select) {
                                select.disabled = false;
                            }
                        });
                    }
                });
                
                // Trigger once on load to lock if it was pre-filled with UMKM
                if (['mikro', 'kecil', 'menengah'].includes(skalaUsahaSelect.value)) {
                    skalaUsahaSelect.dispatchEvent(new Event('change'));
                }
            }
