import { validateStep } from './validation.js';
import { populateSummary } from './summary.js';
import { state } from './store.js';
import { previewMap } from './map.js';
import { selectedKbli } from './kbli.js';

let btnNext, btnPrev, btnSubmit, progressLine, spacer;

export function initUI() {
    btnNext = document.getElementById("btn-next"); 
    btnPrev = document.getElementById("btn-prev"); 
    btnSubmit = document.getElementById("btn-submit"); 
    progressLine = document.getElementById("progress-line"); 
    spacer = document.getElementById("spacer");
    setupEvents();
    updateUI();
}

export function updateUI() {
    // Update sections visibility with a tiny fade effect consideration
    document.querySelectorAll('.step-section').forEach((el, index) => {
        if (index + 1 === state.currentStep) {
            el.classList.remove('hidden');
        } else {
            el.classList.add('hidden');
        }
                });
                
                // Update buttons
                if (state.currentStep === 1) {
                    btnPrev.classList.add('hidden');
                    spacer.classList.remove('hidden');
                } else {
                    btnPrev.classList.remove('hidden');
                    spacer.classList.add('hidden');
                }
                
                if (state.currentStep === state.totalSteps) {
                    btnNext.classList.add('hidden');
                    btnSubmit.classList.remove('hidden');
                } else {
                    btnNext.classList.remove('hidden');
                    btnSubmit.classList.add('hidden');
                }
                
                // Update Progress Bar & Indicators
                const progressWidth = ((state.currentStep - 1) / (state.totalSteps - 1)) * 100;
                progressLine.style.width = `${progressWidth}%`;
                
                for(let i = 1; i <= state.totalSteps; i++) {
                    const indicator = document.getElementById(`indicator-${i}`);
                    const label = document.getElementById(`label-${i}`);
                    
                    if (i < state.currentStep) {
                        // Completed step
                        indicator.className = "w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-md border-4 border-white transition-all duration-300";
                        indicator.innerHTML = '<i class="ph ph-check text-xl"></i>';
                        label.className = "text-xs font-semibold mt-2 text-blue-600";
                    } else if (i === state.currentStep) {
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
            
            function setupEvents() {
            btnNext.addEventListener('click', () => {
                if (typeof validateStep === 'function' && !validateStep(state.currentStep)) return;
                
                if (state.currentStep === 2) {
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
                
                if (state.currentStep < state.totalSteps) {
                    // normally validate form fields here
                    if (state.currentStep === 1 && typeof enforcePKPRules === 'function') {
                        enforcePKPRules();
                    }
                    
                    // If moving to step 4, populate summary
                    if (state.currentStep === 3) {
                        populateSummary();
                    }
                    
                    state.currentStep++;
                    updateUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    
                    // Fix map rendering issue when becoming visible
                    if (state.currentStep === 3 && typeof previewMap !== 'undefined' && previewMap) {
                        setTimeout(() => previewMap.invalidateSize(), 100);
                    }
                }
            });
            
            btnPrev.addEventListener('click', () => {
                if (state.currentStep > 1) {
                    state.currentStep--;
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
                        if (state.currentStep < state.totalSteps) {
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
}
