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
