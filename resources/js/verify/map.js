export let interactiveMap = null;
export let previewMap = null;
export let marker = null;
export let previewMarker = null;
export let currentLat = -0.789275; // Default center (Indonesia)
export let currentLng = 113.921327;

export function initMaps() {
    const tempCoordinate = document.getElementById('temp-coordinate');
    
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
        if(tempCoordinate) tempCoordinate.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    });
}

export function openMapModal() {
    const mapModal = document.getElementById('map-picker-modal');
    const coordinateInput = document.getElementById('coordinate-input');
    const tempCoordinate = document.getElementById('temp-coordinate');
    
    if(!mapModal || !coordinateInput) return;
    
    mapModal.classList.remove('hidden');
    
    // Parse existing input if available
    if(coordinateInput.value) {
        const parts = coordinateInput.value.split(',');
        if(parts.length === 2) {
            currentLat = parseFloat(parts[0].trim());
            currentLng = parseFloat(parts[1].trim());
            if(tempCoordinate) tempCoordinate.textContent = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
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

export function closeMapModal() {
    const mapModal = document.getElementById('map-picker-modal');
    if(mapModal) mapModal.classList.add('hidden');
}

export function saveCoordinates() {
    const coordinateInput = document.getElementById('coordinate-input');
    const previewPlaceholder = document.getElementById('map-preview-placeholder');
    const previewContainer = document.getElementById('map-preview');
    
    if (marker && coordinateInput) {
        coordinateInput.value = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
        
        // Update preview map
        if(previewPlaceholder) {
            previewPlaceholder.style.opacity = '0';
            setTimeout(() => previewPlaceholder.classList.add('hidden'), 300);
        }
        
        if(previewContainer) previewContainer.style.opacity = '1';
        
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

export function setupMapEvents() {
    const btnOpenMap = document.getElementById('btn-open-map');
    const btnCloseMap = document.getElementById('btn-close-map');
    const btnCancelMap = document.getElementById('btn-cancel-map');
    const btnSaveMap = document.getElementById('btn-save-map');
    const coordinateInput = document.getElementById('coordinate-input');
    
    if (btnOpenMap) btnOpenMap.addEventListener('click', openMapModal);
    if (btnCloseMap) btnCloseMap.addEventListener('click', closeMapModal);
    if (btnCancelMap) btnCancelMap.addEventListener('click', closeMapModal);
    if (btnSaveMap) btnSaveMap.addEventListener('click', saveCoordinates);
    
    if (coordinateInput) {
        coordinateInput.addEventListener('blur', function() {
            const val = this.value;
            if(val) {
                const parts = val.split(',');
                if(parts.length === 2) {
                    currentLat = parseFloat(parts[0].trim());
                    currentLng = parseFloat(parts[1].trim());
                    if(!isNaN(currentLat) && !isNaN(currentLng)) {
                        coordinateInput.value = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                        
                        if (!marker) {
                            marker = L.marker([currentLat, currentLng]).addTo(interactiveMap);
                        } else {
                            marker.setLatLng([currentLat, currentLng]);
                        }
                        
                        saveCoordinates();
                    }
                }
            }
        });
        
        coordinateInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.blur();
            }
        });
    }
}
