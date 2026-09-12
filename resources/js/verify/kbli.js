// kbli.js
export let selectedKbli = [];
let kbliData = [];

export function initKbli() {
    if (!window.VERIFY_DATA) return;
    
    kbliData = window.VERIFY_DATA.kbliData || [];
    let existingKblis = window.VERIFY_DATA.existingKblis || [];
    
    if (typeof existingKblis === 'string') {
        try {
            existingKblis = JSON.parse(existingKblis);
        } catch (e) {
            existingKblis = [];
        }
    }
    
    selectedKbli = existingKblis.map(code => {
        return kbliData.find(k => k.id == code) || { id: code, nama: 'Unknown' };
    });
    
    setupKbliEvents();
    
    if (selectedKbli.length > 0) {
        renderKbliChips();
    }
}

function renderKbliChips() {
    const kbliChips = document.getElementById('kbli-chips');
    const kblisInput = document.getElementById('kblis-input');
    
    if (!kbliChips) return;
    
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
    const kbliList = document.getElementById('kbli-list');
    const kbliSearch = document.getElementById('kbli-search');
    
    if (!kbliList) return;
    
    kbliList.innerHTML = '';
    const lowerFilter = filter.toLowerCase();
    const filtered = kbliData.filter(item => 
        (String(item.id).toLowerCase().includes(lowerFilter) || String(item.nama).toLowerCase().includes(lowerFilter)) &&
        !selectedKbli.some(selected => String(selected.id) === String(item.id))
    ).slice(0, 50);
    
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
            e.preventDefault();
            selectedKbli.push(item);
            renderKbliChips();
            if (kbliSearch) {
                kbliSearch.value = '';
                kbliSearch.focus();
            }
            renderKbliDropdown();
        });
        kbliList.appendChild(li);
    });
}

function setupKbliEvents() {
    const kbliContainer = document.getElementById('kbli-container');
    const kbliSearch = document.getElementById('kbli-search');
    const kbliDropdown = document.getElementById('kbli-dropdown');
    
    if (!kbliSearch || !kbliDropdown || !kbliContainer) return;
    
    kbliSearch.addEventListener('focus', () => {
        kbliDropdown.classList.remove('hidden');
        renderKbliDropdown(kbliSearch.value);
    });
    
    kbliContainer.addEventListener('click', () => {
        kbliSearch.focus();
    });
    
    kbliSearch.addEventListener('input', (e) => {
        kbliDropdown.classList.remove('hidden');
        renderKbliDropdown(e.target.value);
    });
    
    kbliSearch.addEventListener('blur', () => {
        setTimeout(() => {
            kbliDropdown.classList.add('hidden');
        }, 200);
    });
}
