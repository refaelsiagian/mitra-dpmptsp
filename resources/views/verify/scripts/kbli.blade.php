            // KBLI Multiselect Logic
            const kbliData = @json($kblis->map(function($kbli) {
                return ['id' => $kbli->code, 'nama' => $kbli->name];
            }));
            let selectedKbli = [];
            
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
                    (item.id.toLowerCase().includes(lowerFilter) || item.nama.toLowerCase().includes(lowerFilter)) &&
                    !selectedKbli.some(selected => selected.id === item.id)
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
                    kbliDropdown.classList.add('hidden');
                });
            }
