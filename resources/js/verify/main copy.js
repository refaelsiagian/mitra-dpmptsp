document.addEventListener("DOMContentLoaded", function() {
let currentStep = 1; const totalSteps = 4; const btnNext = document.getElementById("btn-next"); const btnPrev = document.getElementById("btn-prev"); const btnSubmit = document.getElementById("btn-submit"); const progressLine = document.getElementById("progress-line"); const spacer = document.getElementById("spacer");
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
            function validateStep(step) {
                let isValid = true;
                
                // Helper to remove all existing errors for a given step
                const stepSection = document.getElementById(`step-${step}`);
                if (!stepSection) return true;
                
                stepSection.querySelectorAll('.error-msg').forEach(el => el.remove());
                stepSection.querySelectorAll('.border-red-500').forEach(el => {
                    el.classList.remove('border-red-500');
                    if(el.tagName.toLowerCase() === 'input' || el.tagName.toLowerCase() === 'button' || el.tagName.toLowerCase() === 'textarea') {
                        el.classList.add('border-gray-300');
                    }
                });
                
                function showError(elementId, message, borderElementId = null) {
                    isValid = false;
                    let el = document.getElementById(borderElementId || elementId);
                    
                    if (el) {
                        // If it's the hidden native select, target its Alpine button instead
                        if (el.tagName.toLowerCase() === 'select') {
                            const customBtn = el.nextElementSibling?.querySelector('button') || el.nextElementSibling;
                            if (customBtn && customBtn.tagName.toLowerCase() === 'button') {
                                el = customBtn;
                            }
                        }
                        el.classList.remove('border-gray-300');
                        el.classList.add('border-red-500');
                    }
                    
                    const targetEl = document.getElementById(elementId);
                    if (targetEl) {
                        const p = document.createElement('p');
                        p.className = 'text-red-500 text-xs mt-1 error-msg';
                        p.textContent = message;
                        
                        if (targetEl.tagName.toLowerCase() === 'select') {
                            // targetEl is hidden select inside the custom form select component, append to its root wrapper
                            targetEl.parentNode.appendChild(p);
                        } else if (elementId === 'coordinate-input') {
                            targetEl.parentNode.parentNode.insertBefore(p, targetEl.parentNode.nextSibling);
                        } else if (elementId === 'kbli-search') {
                            const kbliContainer = document.getElementById('kbli-container');
                            kbliContainer.parentNode.insertBefore(p, kbliContainer.nextSibling);
                        } else if (targetEl.nextElementSibling && targetEl.nextElementSibling.classList.contains('custom-search-wrapper')) {
                            targetEl.parentNode.insertBefore(p, targetEl.nextElementSibling.nextSibling);
                        } else if (targetEl.parentNode && targetEl.parentNode.classList.contains('relative') && targetEl.parentNode.classList.contains('rounded-lg')) {
                            targetEl.parentNode.parentNode.insertBefore(p, targetEl.parentNode.nextSibling);
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
                        if (pelakuUsaha === 'orang-perseorangan') {
                            const nikVal = document.getElementById('nik-perseorangan').value.trim();
                            if (!nikVal) {
                                showError('nik-perseorangan', 'NIK wajib diisi');
                            } else if (!/^\d{16}$/.test(nikVal)) {
                                showError('nik-perseorangan', 'NIK harus berupa 16 digit angka');
                            }
                        } else if (pelakuUsaha === 'badan-usaha' && !document.getElementById('jenis-badan-usaha').value) {
                            showError('jenis-badan-usaha', 'Pilih jenis badan usaha');
                        } else if (pelakuUsaha === 'kantor-perwakilan' && !document.getElementById('jenis-kantor-perwakilan').value) {
                            showError('jenis-kantor-perwakilan', 'Pilih jenis kantor perwakilan');
                        } else if (pelakuUsaha === 'badan-usaha-luar-negeri' && !document.getElementById('jenis-badan-usaha-luar-negeri').value) {
                            showError('jenis-badan-usaha-luar-negeri', 'Pilih jenis badan usaha luar negeri');
                        }
                    }
                    
                    if (typeof selectedKbli !== 'undefined' && selectedKbli.length === 0) {
                        showError('kbli-search', 'Pilih setidaknya satu kode KBLI', 'kbli-container');
                    }
                    
                    const skalaUsaha = document.getElementById('skala-usaha').value;
                    if (!skalaUsaha) {
                        showError('skala-usaha', 'Pilih skala usaha');
                    }
                }
                else if (step === 2) {
                    const nationality = document.querySelector('input[name="kewarganegaraan"]:checked');
                    
                    if (!document.getElementById('nama-pimpinan').value.trim()) showError('nama-pimpinan', 'Nama pimpinan wajib diisi');
                    
                    const containerJabatan = document.getElementById('container-jabatan');
                    if (containerJabatan && !containerJabatan.classList.contains('hidden')) {
                        if (!document.getElementById('jabatan-pimpinan').value.trim()) showError('jabatan-pimpinan', 'Jabatan pimpinan wajib diisi');
                    }
                    
                    if (nationality && nationality.value === 'WNA') {
                        const pasporVal = document.getElementById('nik-pimpinan').value.trim();
                        if (!pasporVal) {
                            showError('nik-pimpinan', 'Nomor paspor wajib diisi');
                        } else if (pasporVal.length < 5) {
                            showError('nik-pimpinan', 'Nomor paspor minimal 5 karakter');
                        }
                        if (!document.getElementById('nationality-pimpinan').value) showError('nationality-pimpinan', 'Pilih negara kewarganegaraan');
                    } else {
                        const pimpinanContainer = document.getElementById('container-nik-pimpinan');
                        if (pimpinanContainer && !pimpinanContainer.classList.contains('hidden')) {
                            const nikPimVal = document.getElementById('nik-pimpinan').value.trim();
                            if (!nikPimVal) {
                                showError('nik-pimpinan', 'NIK wajib diisi');
                            } else if (!/^\d{16}$/.test(nikPimVal)) {
                                showError('nik-pimpinan', 'NIK harus berupa 16 digit angka');
                            }
                        }
                    }
                    
                    const nibVal = document.getElementById('nib-number').value.trim();
                    if (!nibVal) {
                        showError('nib-number', 'NIB wajib diisi');
                    } else if (!/^\d{13}$/.test(nibVal)) {
                        showError('nib-number', 'NIB harus berupa 13 digit angka');
                    }
                    
                    const nibLink = document.getElementById('nib-link').value.trim();
                    if (!nibLink) {
                        showError('nib-link', 'Link dokumen NIB wajib diisi');
                    } else if (!/^(https?:\/\/)/i.test(nibLink)) {
                        showError('nib-link', 'Masukkan URL yang valid (harus diawali http:// atau https://)');
                    }
                    
                    const npwpVal = document.getElementById('npwp-number').value.trim();
                    if (!npwpVal) {
                        showError('npwp-number', 'NPWP wajib diisi');
                    } else if (!/^\d{15,16}$/.test(npwpVal)) {
                        showError('npwp-number', 'NPWP harus berupa 15 atau 16 digit angka');
                    }
                    
                    const npwpLink = document.getElementById('npwp-link').value.trim();
                    if (!npwpLink) {
                        showError('npwp-link', 'Link dokumen NPWP wajib diisi');
                    } else if (!/^(https?:\/\/)/i.test(npwpLink)) {
                        showError('npwp-link', 'Masukkan URL yang valid (harus diawali http:// atau https://)');
                    }

                    // PKP Validation
                    const pkpYesCheck = document.querySelector('input[name="is_pkp"][value="1"]')?.checked;
                    const pkpNoCheck = document.querySelector('input[name="is_pkp"][value="0"]')?.checked;
                    
                    if (!pkpYesCheck && !pkpNoCheck) {
                        showError('radio-is-pkp', 'Pilih status PKP perusahaan');
                    } else if (pkpYesCheck) {
                        const pkpLinkVal = document.getElementById('pkp-link').value.trim();
                        if (!pkpLinkVal) {
                            showError('pkp-link', 'Link dokumen SPPKP wajib diisi');
                        } else if (!/^(https?:\/\/)/i.test(pkpLinkVal)) {
                            showError('pkp-link', 'Masukkan URL yang valid (harus diawali http:// atau https://)');
                        }
                    }
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
                    
                    const coordVal = document.getElementById('coordinate-input').value.trim();
                    if (!coordVal) {
                        showError('coordinate-input', 'Koordinat lokasi wajib diisi');
                    } else if (!/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/.test(coordVal)) {
                        showError('coordinate-input', 'Format koordinat tidak valid (contoh: -6.200000, 106.816666)');
                    } else {
                        const parts = coordVal.split(',');
                        const lat = parseFloat(parts[0]);
                        const lng = parseFloat(parts[1]);
                        if (lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                            showError('coordinate-input', 'Nilai latitude (-90 s/d 90) atau longitude (-180 s/d 180) tidak valid');
                        }
                    }
                }
                
                return isValid;
            }
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
            // Region Cascading Logic
            function updateDropdown(id, html, disabled) {
                const el = document.getElementById(id);
                if (el) {
                    el.innerHTML = html;
                    el.disabled = disabled;
                }
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

            // Initialize from old data
            async function initializePreFilledRegions() {
                async function loadChain(type) {
                    const prov = document.getElementById('provinsi-' + type);
                    if (!prov || !prov.value) return;
                    
                    const kab = document.getElementById('kabupaten-' + type);
                    const kec = document.getElementById('kecamatan-' + type);
                    const desa = document.getElementById('desa-' + type);
                    
                    if (kab && kab.dataset.old) {
                        await window.loadRegencies(prov.value, 'kabupaten-' + type);
                        kab.value = kab.dataset.old;
                        
                        if (kec && kec.dataset.old) {
                            await window.loadDistricts(kab.value, 'kecamatan-' + type);
                            kec.value = kec.dataset.old;
                            
                            if (desa && desa.dataset.old) {
                                await window.loadVillages(kec.value, 'desa-' + type);
                                desa.value = desa.dataset.old;
                            }
                        }
                    }
                }
                
                await loadChain('kantor');
                await loadChain('usaha');
            }
            
            // Start the initialization chain
            initializePreFilledRegions();
            // KBLI Multiselect Logic
            const kbliData = @json($kblis->map(function($kbli) {
                return ['id' => $kbli->code, 'nama' => $kbli->name];
            }));
            
            let existingKblis = @json(old('kblis', isset($company) ? $company->kblis->pluck('code')->toArray() : []));
            if (typeof existingKblis === 'string') {
                try {
                    existingKblis = JSON.parse(existingKblis);
                } catch (e) {
                    existingKblis = [];
                }
            }
            
            let selectedKbli = existingKblis.map(code => {
                return kbliData.find(k => k.id == code) || { id: code, nama: 'Unknown' };
            });
            
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
                    (String(item.id).toLowerCase().includes(lowerFilter) || String(item.nama).toLowerCase().includes(lowerFilter)) &&
                    !selectedKbli.some(selected => String(selected.id) === String(item.id))
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
                    setTimeout(() => {
                        kbliDropdown.classList.add('hidden');
                    }, 200);
                });
            }
            
            // Initialize on load
            if (selectedKbli.length > 0) {
                renderKbliChips();
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
            
            // Auto-load pre-filled coordinates
            if (coordinateInput && coordinateInput.value) {
                const parts = coordinateInput.value.split(',');
                if(parts.length === 2) {
                    currentLat = parseFloat(parts[0].trim());
                    currentLng = parseFloat(parts[1].trim());
                    if(!isNaN(currentLat) && !isNaN(currentLng)) {
                        marker = L.marker([currentLat, currentLng]).addTo(interactiveMap);
                        
                        // Update preview map right away (will render when step 3 is shown)
                        previewPlaceholder.style.opacity = '0';
                        previewPlaceholder.classList.add('hidden');
                        previewContainer.style.opacity = '1';
                        previewMap.setView([currentLat, currentLng], 15);
                        previewMarker = L.marker([currentLat, currentLng]).addTo(previewMap);
                    }
                }
            }
});
