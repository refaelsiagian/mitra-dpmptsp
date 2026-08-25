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
