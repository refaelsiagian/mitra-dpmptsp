import { state } from './store.js';
import { initMaps, setupMapEvents } from './map.js';
import { initKbli } from './kbli.js';
import { initUI } from './ui.js';
import './api.js';

document.addEventListener("DOMContentLoaded", function() {
    // 1. Initialize Map
    initMaps();
    setupMapEvents();
    
    // 2. Initialize KBLI
    initKbli();
    
    // 3. Initialize UI & Form Events
    initUI();
    
    // 4. Pre-fill regions logic
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
    
    initializePreFilledRegions();
});
