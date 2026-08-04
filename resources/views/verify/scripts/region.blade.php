            // Custom Searchable Dropdown Logic
            function makeSearchable(selectId) {
                const select = document.getElementById(selectId);
                if (!select) return;

                select.style.display = 'none';

                const existingWrapper = select.parentNode.querySelector('.custom-search-wrapper');
                if (existingWrapper) {
                    existingWrapper.remove();
                }

                const wrapper = document.createElement('div');
                wrapper.className = 'relative custom-search-wrapper w-full';
                
                const getSelectedText = () => {
                    const opt = select.options[select.selectedIndex];
                    return opt ? opt.text : 'Pilih...';
                };

                const isDisabled = select.disabled;

                wrapper.innerHTML = `
                    <div class="search-select-trigger flex items-center justify-between w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-colors ${isDisabled ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white cursor-pointer hover:border-blue-400'}">
                        <span class="truncate display-text">${getSelectedText()}</span>
                        <i class="ph ph-caret-down text-gray-400"></i>
                    </div>
                    <div class="search-select-dropdown absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-xl hidden flex flex-col">
                        <div class="p-2 border-b border-gray-100 sticky top-0 bg-white z-10">
                            <div class="relative">
                                <i class="ph ph-magnifying-glass absolute left-2 top-2 text-gray-400"></i>
                                <input type="text" class="w-full text-sm outline-none pl-7 pr-2 py-1.5 bg-gray-50 rounded border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 search-input" placeholder="Cari...">
                            </div>
                        </div>
                        <ul class="py-1 text-sm text-gray-700 max-h-48 overflow-y-auto option-list">
                        </ul>
                    </div>
                `;

                select.parentNode.insertBefore(wrapper, select.nextSibling);

                const trigger = wrapper.querySelector('.search-select-trigger');
                const dropdown = wrapper.querySelector('.search-select-dropdown');
                const searchInput = wrapper.querySelector('.search-input');
                const optionList = wrapper.querySelector('.option-list');
                const displayText = wrapper.querySelector('.display-text');

                function renderOptions(filter = '') {
                    optionList.innerHTML = '';
                    const lowerFilter = filter.toLowerCase();
                    let hasOptions = false;

                    Array.from(select.options).forEach((opt, index) => {
                        if (opt.disabled || opt.value === '') return;

                        if (opt.text.toLowerCase().includes(lowerFilter)) {
                            hasOptions = true;
                            const li = document.createElement('li');
                            li.className = 'px-3 py-2 hover:bg-blue-50 cursor-pointer transition-colors';
                            if (select.selectedIndex === index) {
                                li.className += ' bg-blue-100 text-blue-700 font-medium';
                            }
                            li.textContent = opt.text;
                            li.addEventListener('mousedown', (e) => {
                                e.preventDefault(); // prevent input blur
                                select.selectedIndex = index;
                                displayText.textContent = opt.text;
                                closeDropdown();
                                select.dispatchEvent(new Event('change'));
                            });
                            optionList.appendChild(li);
                        }
                    });

                    if (!hasOptions) {
                        optionList.innerHTML = '<li class="px-3 py-2 text-gray-400 italic text-center">Tidak ditemukan</li>';
                    }
                }

                function openDropdown() {
                    if (select.disabled) return;
                    dropdown.classList.remove('hidden');
                    renderOptions();
                    searchInput.value = '';
                    setTimeout(() => searchInput.focus(), 10);
                }

                function closeDropdown() {
                    dropdown.classList.add('hidden');
                }

                trigger.addEventListener('click', (e) => {
                    if (dropdown.classList.contains('hidden')) {
                        document.querySelectorAll('.search-select-dropdown:not(.hidden)').forEach(d => d.classList.add('hidden'));
                        openDropdown();
                    } else {
                        closeDropdown();
                    }
                });

                searchInput.addEventListener('input', (e) => {
                    renderOptions(e.target.value);
                });

                document.addEventListener('mousedown', (e) => {
                    if (!wrapper.contains(e.target)) {
                        closeDropdown();
                    }
                });
            }

            // Region Cascading Logic
            const selectIds = [
                'provinsi-kantor', 'kabupaten-kantor', 'kecamatan-kantor', 'desa-kantor',
                'provinsi-usaha', 'kabupaten-usaha', 'kecamatan-usaha', 'desa-usaha'
            ];
            
            // Initialize on load
            selectIds.forEach(id => makeSearchable(id));

            function updateDropdown(id, html, disabled) {
                const el = document.getElementById(id);
                el.innerHTML = html;
                el.disabled = disabled;
                makeSearchable(id);
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
