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
                        
                        if (elementId === 'nib-link' || elementId === 'npwp-link' || elementId === 'pkp-link') {
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
                    const pkpYesCheck = document.getElementById('pkp-yes').checked;
                    const pkpNoCheck = document.getElementById('pkp-no').checked;
                    if (!pkpYesCheck && !pkpNoCheck) {
                        showError('pkp-yes', 'Pilih status PKP perusahaan');
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
