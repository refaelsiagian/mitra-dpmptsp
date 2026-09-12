import { selectedKbli } from './kbli.js';
export function populateSummary() {
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
