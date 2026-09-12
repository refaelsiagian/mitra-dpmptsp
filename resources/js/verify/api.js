import { state } from './store.js';
import { updateUI } from './ui.js';

export async function checkNib(val) {
    const nibInput = document.getElementById('nib-number');
    const nibError = document.getElementById('nib-error-message');
    
    try {
        const res = await fetch(`/api/check-nib/${val}`);
        const data = await res.json();
        if (data.exists) {
            state.isNibValid = false;
            nibError.classList.remove('hidden');
            nibInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            nibInput.classList.remove('border-gray-300', 'focus:border-blue-600', 'focus:ring-blue-600');
        } else {
            state.isNibValid = true;
        }
    } catch (e) {
        console.error('NIB check failed:', e);
        state.isNibValid = true; // allow if API fails
    } finally {
        state.isNibChecking = false;
        // Optionally trigger UI update if needed here
    }
}

function updateDropdown(id, html, disabled) {
    const el = document.getElementById(id);
    if (el) {
        el.innerHTML = html;
        el.disabled = disabled;
    }
}

export async function loadRegencies(provinceId, targetSelectId) {
    updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
    
    let isKantor = targetSelectId.includes('kantor');
    updateDropdown(isKantor ? 'kecamatan-kantor' : 'kecamatan-usaha', '<option selected disabled value="">Pilih Kecamatan...</option>', true);
    updateDropdown(isKantor ? 'desa-kantor' : 'desa-usaha', '<option selected disabled value="">Pilih Desa...</option>', true);
    
    const response = await fetch(`/api/regencies/${provinceId}`);
    const data = await response.json();
    
    let html = '<option selected disabled value="">Pilih Kabupaten...</option>';
    data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
    updateDropdown(targetSelectId, html, false);
}

export async function loadDistricts(regencyId, targetSelectId) {
    updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
    
    let isKantor = targetSelectId.includes('kantor');
    updateDropdown(isKantor ? 'desa-kantor' : 'desa-usaha', '<option selected disabled value="">Pilih Desa...</option>', true);
    
    const response = await fetch(`/api/districts/${regencyId}`);
    const data = await response.json();
    
    let html = '<option selected disabled value="">Pilih Kecamatan...</option>';
    data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
    updateDropdown(targetSelectId, html, false);
}

export async function loadVillages(districtId, targetSelectId) {
    updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
    
    const response = await fetch(`/api/villages/${districtId}`);
    const data = await response.json();
    
    let html = '<option selected disabled value="">Pilih Desa...</option>';
    data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
    updateDropdown(targetSelectId, html, false);
}

// Attach to window so inline HTML onchange events can trigger them
window.loadRegencies = loadRegencies;
window.loadDistricts = loadDistricts;
window.loadVillages = loadVillages;
