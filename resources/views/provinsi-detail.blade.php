<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASPAK KEMENKES</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
        }
        .navbar a {
            padding: 0.5rem 1rem;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }
        .navbar a:hover {
            background-color: #f0f0f0;
            border-radius: 0.25rem;
        }
        .navbar a.active {
            background-color: #007bff; /* Blue for active button */
            color: #ffffff;
            border-radius: 0.25rem;
        }
        .legend-box {
            width: 20px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
            border-radius: 3px;
        }
        
        .color-81-100 { fill: #34D399; } /* Hijau terang */
        .color-61-80 { fill: #2D9CDB; } /* Biru terang */
        .color-41-60 { fill: #F7BF4F; } /* Kuning */
        .color-21-40 { fill: #FF7B7B; } /* Merah muda */
        .color-0-20 { fill: #EF4444; } /* Merah */

        /* SVG styles */
        #indonesia-map path {
            stroke: #fff;
            stroke-width: 0.5px;
            transition: fill 0.3s ease;
        }
        #indonesia-map path:hover {
            fill-opacity: 0.8;
            cursor: pointer;
        }

        #map-tooltip {
        pointer-events: none; 
        transition: opacity 0.2s;
        }

        .poi-dot {
        fill: #ff0000; 
        stroke: #fff;
        stroke-width: 1px;
        cursor: pointer;
        }

        .poi-dot:hover {
            fill: #cc0000; 
        }

        @keyframes pulse {
            0% { r: 3px; opacity: 1; }
            50% { r: 8px; opacity: 0.5; }
            100% { r: 3px; opacity: 1; }
        }
        .poi-pulse {
            animation: pulse 2s infinite;
        }

        #map-container {
        position: relative;
        overflow: hidden;
        }

        #map-container svg {
        position: relative;
        z-index: 1;
        }

        #map-tooltip {
        position: absolute;
        z-index: 9999;
        pointer-events: none;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        }

        #kondisi-kabuapaten,
        #rekomendasi-kabupaten {
        position: relative;
        z-index: 9998;
        }

        #map-container .zoom-controls {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1000;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div id="map-tooltip" class="hidden absolute bg-gray-800 text-white text-sm rounded-md py-1 px-2 shadow-lg"></div>
    <div class="header shadow-md p-4 flex justify-between items-center bg-white">
        <div class="flex items-center">
            <div class="relative mr-4">
                <input type="text" placeholder="Pencarian" class="border rounded-md py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="relative">
                <select class="border rounded-md py-2 px-4 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Dinas Kesehatan DKI Jakarta</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">ASPAK KEMENKES</h1>
        <div class="navbar flex space-x-2">
            <a href="#" class="active">Rumah Sakit</a>
            <a href="#">Sarana</a>
            <a href="#">Prasarana</a>
            <a href="#">Alat Kesehatan</a>
            <a href="#">Bahan</a>
            <a href="#">SDM</a>
        </div>
    </div>

    <div class="container mx-auto p-6 flex">
        <div class="w-1/5 bg-white p-4 shadow-md rounded-lg mr-6" style="height: fit-content;">
            <h3 class="font-semibold text-lg mb-4">Legend</h3>
            <div class="space-y-2">
               <div class="flex items-center">
                    <span class="legend-box bg-green-400 color-81-100"></span> <span>81-100%</span>
                </div>
                <div class="flex items-center">
                    <span class="legend-box bg-blue-400 color-61-80"></span> <span>61-80%</span>
                </div>
                <div class="flex items-center">
                    <span class="legend-box bg-yellow-400 color-41-60"></span> <span>41-60%</span>
                </div>
                <div class="flex items-center">
                    <span class="legend-box bg-red-300 color-21-40"></span> <span>21-40%</span>
                </div>
                <div class="flex items-center">
                    <span class="legend-box bg-red-600 color-0-20"></span> <span>0-20%</span>
                </div>
            </div>
        </div>

        <div class="w-4/5 bg-white p-4 shadow-md rounded-lg">
            <div id="map-container" class="w-full h-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-auto" viewBox="430 438 12 10">
                    <g id="DKI_Jakarta">
                        <path id="Kota_Adm._Jakarta_Pusat" title="Kota Adm. Jakarta Pusat" d="m436.91 441.5-0.75 1.03-0.09 0.13-0.13 0.18-1.6 0.65-0.08 0.03-0.06 0.02-0.11-0.7 0.45-1.1 0.18-0.43 0.31-0.77 0.45 0.22 0.08 0.05 0.17 0.08 0.3 0.16z" />
                        <path id="Kota_Adm._Jakarta_Selatan" title="Kota Adm. Jakarta Selatan" d="m435.94 442.84 0.45 1.25 0.04 0.11-0.38 1.38-0.04 0.13-0.01 0.02-0.02 0.11h-0.01l-0.15 0.55-0.08 0.3-0.01 0.03-0.03 0.11-0.02 0.07-0.03 0.11v0.01l-1.48 0.93h-0.01 0.01l0.47-1.62-0.95 0.05-0.01 0.01v-0.01l-0.16-0.34-0.04-0.09-0.05-0.09-0.05-0.11-0.13-0.28-0.04-0.07-0.11-0.24-0.02-0.03-0.22-0.47-0.02-0.05-0.03-0.06-0.16-0.33v-0.01l-0.37-0.84 0.02-0.01 1.49-0.43 0.3-0.09 0.11 0.7 0.06-0.02 0.08-0.03z" />
                        <path id="Kota_Adm._Jakarta_Timur" title="Kota Adm. Jakarta Timur" d="m439.93 441.11 0.01 0.15 0.03 0.43 0.01 0.09-0.05 0.13-0.44 1.17-0.45 1.22-0.93 0.18-0.01 0.01-0.3 0.06h-0.02v0.02l0.03 0.34 0.24 2.85v0.01l0.02 0.21-0.41 0.1-0.26 0.06-0.3 0.07-0.65-0.54-0.27-0.22-0.33-0.27-0.2-0.16v-0.01l0.03-0.11 0.02-0.07 0.03-0.11 0.01-0.03 0.08-0.3 0.15-0.55h0.01l0.02-0.11 0.01-0.02 0.04-0.13 0.38-1.38-0.04-0.11-0.45-1.25 0.13-0.18 0.09-0.13 0.75-1.03h0.01l1.41 0.54v-0.01l-0.01-0.67h0.02l0.71-0.11 0.49-0.08 0.32-0.05z" />
                        <path id="Kota_Adm._Jakarta_Barat" title="Kota Adm. Jakarta Barat" d="m431.45 439.21 1.98 1.45 0.09 0.07 0.07 0.04 0.77-0.12 0.67-0.11-0.31 0.77-0.18 0.43-0.45 1.1-0.3 0.09-1.49 0.43-0.02 0.01-0.01-0.01-0.47-0.49-1.15-1.18 0.01-0.64 0.01-0.36v-0.54l0.02-0.79v-0.12z" />
                        <path id="Kota_Adm._Jakarta_Utara" title="Kota Adm. Jakarta Utara" d="m439.88 439.03 0.04 1.5 0.01 0.58-0.07 0.01-0.32 0.05-0.49 0.08-0.71 0.11h-0.02l0.01 0.67v0.01l-1.41-0.54h-0.01l-0.88-0.45-0.3-0.16-0.17-0.08-0.08-0.05-0.45-0.22-0.67 0.11-0.77 0.12-0.07-0.04-0.09-0.07-1.98-1.45 0.37-0.18 0.1-0.03 0.05 0.02 0.09 0.18 0.32 0.2 0.27-0.07 0.27 0.13 0.26-0.08 0.14 0.05 0.11 0.07 0.06-0.02 0.07 0.02-0.06 0.16 0.07-0.13 0.29 0.17 0.01-0.1h0.01l0.7 0.21v0.01l0.15 0.25v-0.11l0.15 0.02 0.01-0.08 0.15 0.05 0.02 0.1 0.02-0.09 0.22 0.07 0.06-0.01h0.37l-0.08 0.09 0.56-0.24v-0.04l0.13-0.03v0.01l0.07-0.02 0.04-0.01-0.06 0.24 0.12-0.03-0.04-0.21 0.01-0.01 0.17-0.03-0.02 0.07 0.09-0.01 0.02-0.08 1.06-0.23 0.02 0.13 0.01-0.14 0.4-0.09 0.01 0.09 0.02-0.09 0.63-0.14 0.03 0.02 0.74-0.19 0.19-0.04z" />
                    </g>            
                </svg>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-6 flex justify-between">
        <div class="w-1/2 bg-white p-4 shadow-md rounded-lg mr-6">
            <p class="text-lg font-semibold mb-2">Tanggal:</p>
            <p class="text-xl font-bold" id="current-date">{{ $currentDateTime->format('d/m/Y') }}</p>
        </div>
        <div class="w-1/2 bg-white p-4 shadow-md rounded-lg">
            <p class="text-lg font-semibold mb-2">Waktu:</p>
            <p class="text-xl font-bold" id="current-time">{{ $currentDateTime->format('H:i:s') }}</p>
        </div>
    </div>

    <div class="container mx-auto p-6 flex">
        <div class="w-1/2 bg-white p-4 shadow-md rounded-lg mr-6">
            <h3 class="font-semibold text-lg mb-2">Kondisi:</h3>
            <p id="kondisi-kabupaten" class="text-gray-700">Pilih kabupaten/kota untuk melihat kondisi.</p>
        </div>
        <div class="w-1/2 bg-white p-4 shadow-md rounded-lg">
            <h3 class="font-semibold text-lg mb-2">Rekomendasi:</h3>
            <p id="rekomendasi-kabupaten" class="text-gray-700">Rekomendasi akan muncul di sini.</p>
        </div>
    </div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const provinsisData = @json($provinsis);
        const pointsData = @json($pointsOfInterest);
        const mapContainer = document.getElementById('map-container');
        const tooltip = document.getElementById('map-tooltip');
        const svgElement = mapContainer.querySelector('svg');
        const kondisiProvinsi = document.getElementById('kondisi-provinsi');
        const rekomendasiProvinsi = document.getElementById('rekomendasi-provinsi');
        const currentDate = document.getElementById('current-date');
        const currentTime = document.getElementById('current-time');

        function addPointsOfInterest() {
            if (!svgElement || !pointsData || pointsData.length === 0) {
                console.log("SVG Element or Points Data not found. Stopping.");
                return;
            }

            const poiGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');
            svgElement.appendChild(poiGroup);

            pointsData.forEach(point => {
                // Step 1: Find the province name using the provinsi_id from the point.
                let provinsiName = null;
                for (const name in provinsisData) {
                    if (provinsisData[name].id === point.provinsi_id) {
                        provinsiName = provinsisData[name].nama;
                        break;
                    }
                }

                // DEBUGGING: Check if we found the province name.
                if (!provinsiName) {
                    console.error(`Could not find a province with ID: ${point.provinsi_id}`);
                    return; // Skip this point if province not found
                }

                // Step 2: Use the found name to get the SVG element.
                const svgId = provinsiName.replace(/ /g, '_');
                const pathElement = svgElement.querySelector(`#${svgId}`);

                // DEBUGGING: Check if we found the SVG path.
                if (!pathElement) {
                    console.error(`Could not find SVG path with ID: #${svgId}`);
                    return; // Skip if path not found
                }

                // Step 3: Calculate center and draw the point (this logic is correct).
                const bbox = pathElement.getBBox();
                const cx = bbox.x + bbox.width / 2;
                const cy = bbox.y + bbox.height / 2;

                const pulseCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                pulseCircle.setAttribute('cx', cx);
                pulseCircle.setAttribute('cy', cy);
                pulseCircle.setAttribute('class', 'poi-dot poi-pulse');
                
                const mainCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                mainCircle.setAttribute('cx', cx);
                mainCircle.setAttribute('cy', cy);
                mainCircle.setAttribute('r', '3');
                mainCircle.setAttribute('class', 'poi-dot');
                
                poiGroup.appendChild(pulseCircle);
                poiGroup.appendChild(mainCircle);

                // Add tooltip events
                poiGroup.addEventListener('mouseover', () => { /* ... tooltip code ... */ });
                poiGroup.addEventListener('mouseleave', () => { /* ... tooltip code ... */ });
                poiGroup.addEventListener('mousemove', (e) => { /* ... tooltip code ... */ });
            });
        }

        // --- EVENT LISTENERS FOR PROVINCES (No changes here) ---
        mapContainer.querySelectorAll('path.land').forEach(path => {
            // ... all your existing mouseover, mouseleave, and click events ...
        });
        

        function updateDateTime() {
            const now = new Date();
            const optionsDate = { day: '2-digit', month: '2-digit', year: 'numeric' };
            currentDate.textContent = now.toLocaleDateString('id-ID', optionsDate);
            currentTime.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(/\./g, ':');
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        function getClassNameByPersentase(persentase) {
            if (persentase >= 81) return 'color-81-100';
            if (persentase >= 61) return 'color-61-80';
            if (persentase >= 41) return 'color-41-60';
            if (persentase >= 21) return 'color-21-40';
            return 'color-0-20';
        }

        function getTingkatanByPersentase(persentase) {
            if (persentase >= 81) return '81-100%';
            if (persentase >= 61) return '61-80%';
            if (persentase >= 41) return '41-60%';
            if (persentase >= 21) return '21-40%';
            return '0-20%';
        }

        // Menerapkan warna pada peta berdasarkan data
        for (const namaProvinsi in provinsisData) {
            // Mengganti spasi dengan underscore agar cocok dengan ID di SVG
            const provinsiId = namaProvinsi.replace(/ /g, '_');
            const pathElement = mapContainer.querySelector(`#${provinsiId}`);
            if (pathElement) {
                const persentase = provinsisData[namaProvinsi].persentase;
                pathElement.classList.add(getClassNameByPersentase(persentase));
            }
        }

        mapContainer.querySelectorAll('path.land').forEach(path => {

            path.addEventListener('mouseover', function() {
                const provinsiId = this.id;
                const namaProvinsi = provinsiId.replace(/_/g, ' '); 
                const data = provinsisData[namaProvinsi]; 
                if (data) {
                    tooltip.innerHTML = `<strong>${data.nama}</strong><br>${data.persentase}%`;
                    tooltip.classList.remove('hidden');
                }
            });

            path.addEventListener('mouseleave', function() {
                tooltip.classList.add('hidden');
            });

            path.addEventListener('mousemove', function(e) {
                tooltip.style.left = (e.pageX + 15) + 'px';
                tooltip.style.top = (e.pageY + 15) + 'px';
            });

            path.addEventListener('click', function() {
                const provinsiId = this.id;
                const namaProvinsi = provinsiId.replace(/_/g, ' ');
                const data = provinsisData[namaProvinsi];

                if (data) {
                    kondisiProvinsi.innerHTML = `
                        <p class="text-xl font-bold">${data.nama}</p>
                        <p class="text-lg">Tingkat Ketersediaan: <span class="font-bold">${getTingkatanByPersentase(data.persentase)}</span></p>
                        <p class="text-lg">Persentase: <span class="font-bold">${data.persentase}%</span></p>
                    `;
                    
                    let rekomendasiText = '';
                    if (data.persentase >= 81) {
                        rekomendasiText = 'Ketersediaan sangat baik. Pertahankan.';
                    } else if (data.persentase >= 61) {
                        rekomendasiText = 'Ketersediaan baik. Perlu pemantauan rutin.';
                    } else if (data.persentase >= 41) {
                        rekomendasiText = 'Ketersediaan cukup. Evaluasi kebutuhan dan lakukan penyesuaian.';
                    } else if (data.persentase >= 21) {
                        rekomendasiText = 'Ketersediaan kurang. Diperlukan tindakan segera untuk peningkatan.';
                    } else {
                        rekomendasiText = 'Ketersediaan sangat rendah. Urgent untuk dilakukan intervensi.';
                    }
                    rekomendasiProvinsi.textContent = rekomendasiText;
                } else {
                    kondisiProvinsi.textContent = `Data untuk ID ${namaProvinsi} tidak ditemukan.`;
                    rekomendasiProvinsi.textContent = '';
                }
            });
        });

        let isPanning = false;
        let startX = 0, startY = 0;
        let viewBox = { x: 0, y: 0, width: 0, height: 0 };

        const MIN_ZOOM = 0.5;   
        const MAX_ZOOM = 8;     
        let currentZoom = 1;

        if (svgElement) {
            const vb = svgElement.getAttribute('viewBox');
            if (vb) {
                const parts = vb.split(' ').map(parseFloat);
                viewBox = { x: parts[0], y: parts[1], width: parts[2], height: parts[3] };
            } else {
                const bbox = svgElement.getBBox();
                svgElement.setAttribute('viewBox', `${bbox.x} ${bbox.y} ${bbox.width} ${bbox.height}`);
                viewBox = { x: bbox.x, y: bbox.y, width: bbox.width, height: bbox.height };
            }
        }

        const originalViewBox = { ...viewBox };


        svgElement.addEventListener('wheel', function(e) {
            e.preventDefault();
            const zoomSpeed = 1.2;
            const direction = e.deltaY < 0 ? 1 : -1;
            const scale = direction > 0 ? (1 / zoomSpeed) : zoomSpeed;

            let newZoom = currentZoom * (direction > 0 ? zoomSpeed : 1 / zoomSpeed);
            if (newZoom > MAX_ZOOM) newZoom = MAX_ZOOM;
            if (newZoom < MIN_ZOOM) newZoom = MIN_ZOOM;

            const actualScale = newZoom / currentZoom;
            currentZoom = newZoom;

            const pt = svgElement.createSVGPoint();
            pt.x = e.offsetX;
            pt.y = e.offsetY;
            const cursorPt = pt.matrixTransform(svgElement.getScreenCTM().inverse());

            viewBox.x = cursorPt.x - (cursorPt.x - viewBox.x) * actualScale;
            viewBox.y = cursorPt.y - (cursorPt.y - viewBox.y) * actualScale;
            viewBox.width *= actualScale;
            viewBox.height *= actualScale;

            svgElement.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
        });

        // Pan (geser peta)
        svgElement.addEventListener('mousedown', (e) => {
            isPanning = true;
            startX = e.clientX;
            startY = e.clientY;
            svgElement.style.cursor = "grabbing";
        });

        svgElement.addEventListener('mousemove', (e) => {
            if (!isPanning) return;
            const dx = (e.clientX - startX) * (viewBox.width / svgElement.clientWidth);
            const dy = (e.clientY - startY) * (viewBox.height / svgElement.clientHeight);
            viewBox.x -= dx;
            viewBox.y -= dy;
            svgElement.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
            startX = e.clientX;
            startY = e.clientY;
        });

        svgElement.addEventListener('mouseup', () => {
            isPanning = false;
            svgElement.style.cursor = "grab";
        });
        svgElement.addEventListener('mouseleave', () => {
            isPanning = false;
            svgElement.style.cursor = "default";
        });

        // --- Tombol Kontrol Zoom ---
        const zoomControls = document.createElement('div');
        zoomControls.style.position = 'absolute';
        zoomControls.style.top = '20px';
        zoomControls.style.right = '20px';
        zoomControls.style.zIndex = '9999';
        zoomControls.style.display = 'flex';
        zoomControls.style.flexDirection = 'column';
        zoomControls.style.gap = '8px';

        zoomControls.innerHTML = `
        <button id="zoom-in" style="padding:6px 10px;background:#2e7d32;color:white;border:none;border-radius:4px;font-size:18px;cursor:pointer;">+</button>
        <button id="zoom-out" style="padding:6px 10px;background:#c62828;color:white;border:none;border-radius:4px;font-size:18px;cursor:pointer;">−</button>
        <button id="reset-zoom" style="padding:6px 10px;background:#1565c0;color:white;border:none;border-radius:4px;font-size:16px;cursor:pointer;">⟳</button>
        `;
        zoomControls.classList.add('zoom-controls');
        mapContainer.appendChild(zoomControls);


        // Fungsi bantu zoom manual
        function applyZoom(scaleFactor) {
            const newZoom = currentZoom * scaleFactor;
            if (newZoom > MAX_ZOOM || newZoom < MIN_ZOOM) return;

            currentZoom = newZoom;
            const centerX = viewBox.x + viewBox.width / 2;
            const centerY = viewBox.y + viewBox.height / 2;
            viewBox.width /= scaleFactor;
            viewBox.height /= scaleFactor;
            viewBox.x = centerX - viewBox.width / 2;
            viewBox.y = centerY - viewBox.height / 2;
            svgElement.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
        }

        // Event tombol
        document.getElementById('zoom-in').addEventListener('click', () => applyZoom(1.2));
        document.getElementById('zoom-out').addEventListener('click', () => applyZoom(1 / 1.2));
        document.getElementById('reset-zoom').addEventListener('click', () => {
            currentZoom = 1;
            viewBox = { ...originalViewBox };
            svgElement.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
        });
        addPointsOfInterest();
    });
</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
            const kabupatensData = @json($kabupatens);
            const pointsData = @json($pointsOfInterest);
            const mapContainer = document.getElementById('map-container');
            const tooltip = document.getElementById('map-tooltip');
            const kondisiKab = document.getElementById('kondisi-kabupaten');
            const rekomendasiKab = document.getElementById('rekomendasi-kabupaten');
            const currentDate = document.getElementById('current-date');
            const currentTime = document.getElementById('current-time');

        function updateDateTime() {
            const now = new Date();
            const optionsDate = { day: '2-digit', month: '2-digit', year: 'numeric' };
            currentDate.textContent = now.toLocaleDateString('id-ID', optionsDate);
            currentTime.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(/\./g, ':');
        }

        function getClassNameByPersentase(p) {
            if (p >= 81) return 'color-81-100';
            if (p >= 61) return 'color-61-80';
            if (p >= 41) return 'color-41-60';
            if (p >= 21) return 'color-21-40';
            return 'color-0-20';
        }

        function getTingkatanByPersentase(p) {
            if (p >= 81) return '81-100%';
            if (p >= 61) return '61-80%';
            if (p >= 41) return '41-60%';
            if (p >= 21) return '21-40%';
            return '0-20%';
        }

        function addPointsOfInterest() {
            console.log("--- Memulai Debug Titik Lokasi ---");

            if (!svgElement || !pointsData || pointsData.length === 0) {
                console.warn(" PERINGATAN: Elemen SVG atau data 'pointsData' tidak ditemukan/kosong.");
                return;
            }
            console.log(" Data Titik Lokasi Diterima:", pointsData);

            const poiGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');
            svgElement.appendChild(poiGroup);

            pointsData.forEach(point => {
                console.log(`Memproses titik: "${point.nama}" (kabupaten_id: ${point.kabupaten_id})`);
                
                let targetKabupatenName = null;
                for (const name in kabupatensData) {
                    if (kabupatensData[name].id === point.kabupaten_id) {
                        targetKabupatenName = name;
                        break;
                    }
                }

                if (!targetKabupatenName) {
                    console.error(` GAGAL: Tidak menemukan kabupaten/kota dengan ID: ${point.kabupaten_id});
                    return;
                }
                console.log(` Nama kabupaten ditemukan: "${targetKabupatenName}"`);

                const svgId = targetKabupatenName.replace(/ /g, '_');
                const pathElement = svgElement.querySelector(`#${svgId}`);

                if (!pathElement) {
                    console.error(` GAGAL: Tidak menemukan path SVG dengan ID #${svgId}. Pastikan ID di dalam kode SVG Anda sudah benar dan cocok (misal: 'DKI_Jakarta').`);
                    return;
                }
                console.log(` Path SVG #${svgId} ditemukan.`);

                const bbox = pathElement.getBBox();
                const cx = bbox.x + bbox.width / 2;
                const cy = bbox.y + bbox.height / 2;
                console.log(`Menggambar titik di koordinat SVG (x: ${cx}, y: ${cy})`);

                // Titik luar yang berkedip
                const pulseCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                pulseCircle.setAttribute('cx', cx);
                pulseCircle.setAttribute('cy', cy);
                pulseCircle.setAttribute('class', 'poi-dot poi-pulse');
                
                // Titik utama
                const mainCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                mainCircle.setAttribute('cx', cx);
                mainCircle.setAttribute('cy', cy);
                mainCircle.setAttribute('r', '3');
                mainCircle.setAttribute('class', 'poi-dot');
                
                poiGroup.appendChild(pulseCircle);
                poiGroup.appendChild(mainCircle);

                // Event untuk tooltip
                const groupWrapper = document.createElementNS('http://www.w3.org/2000/svg', 'g');
                groupWrapper.appendChild(pulseCircle);
                groupWrapper.appendChild(mainCircle);
                
                groupWrapper.addEventListener('mouseover', () => {
                    tooltip.innerHTML = `<strong>${point.nama}</strong><br>${point.alamat}`;
                    tooltip.classList.remove('hidden');
                });
                groupWrapper.addEventListener('mouseleave', () => {
                    tooltip.classList.add('hidden');
                });
                groupWrapper.addEventListener('mousemove', (e) => {
                    tooltip.style.left = (e.pageX + 15) + 'px';
                    tooltip.style.top = (e.pageY + 15) + 'px';
                });
                svgElement.appendChild(groupWrapper);
            });
        

        // Jalankan update waktu
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Warnai peta
        for (const namaKabupaten in kabupatensData) {
            const pathElement = mapContainer.querySelector(`[id="${namaKabupaten}"]`);
            if (pathElement) {
                pathElement.classList.add('kabupaten');
                pathElement.classList.add(getClassNameByPersentase(kabupatensData[namaKabupaten].persentase));
            } else {
                console.warn(`Peringatan: Path SVG dengan id="${namaKabupaten}" tidak ditemukan.`);
            }
        }


        mapContainer.querySelectorAll('path').forEach(path => {
            const data = kabupatensData[path.id];
            if (!data) return;

            // Event Hover
            path.addEventListener('mouseover', function() {
                tooltip.innerHTML = `<strong>${data.nama}</strong><br>${data.persentase}%`;
                tooltip.classList.remove('hidden');
            });
            path.addEventListener('mouseleave', () => tooltip.classList.add('hidden'));
            path.addEventListener('mousemove', e => {
                tooltip.style.left = (e.pageX + 15) + 'px';
                tooltip.style.top = (e.pageY + 15) + 'px';
            });

            // Event Klik
            path.addEventListener('click', function() {
                kondisiKab.innerHTML = `<p class="text-xl font-bold">${data.nama}</p><p>Tingkat Ketersediaan: <strong>${getTingkatanByPersentase(data.persentase)}</strong></p>`;
                rekomendasiKab.textContent = "Rekomendasi untuk " + data.nama;
            });

        let isPanning = false;
        let startX = 0, startY = 0;
        let viewBox = { x: 0, y: 0, width: 0, height: 0 };

        const MIN_ZOOM = 0.5;   
        const MAX_ZOOM = 8;     
        let currentZoom = 1;

        if (svgElement) {
            const vb = svgElement.getAttribute('viewBox');
            if (vb) {
                const parts = vb.split(' ').map(parseFloat);
                viewBox = { x: parts[0], y: parts[1], width: parts[2], height: parts[3] };
            } else {
                const bbox = svgElement.getBBox();
                svgElement.setAttribute('viewBox', `${bbox.x} ${bbox.y} ${bbox.width} ${bbox.height}`);
                viewBox = { x: bbox.x, y: bbox.y, width: bbox.width, height: bbox.height };
            }
        }

        const originalViewBox = { ...viewBox };

        svgElement.addEventListener('wheel', function(e) {
            e.preventDefault();
            const zoomSpeed = 1.2;
            const direction = e.deltaY < 0 ? 1 : -1;
            const scale = direction > 0 ? (1 / zoomSpeed) : zoomSpeed;

            let newZoom = currentZoom * (direction > 0 ? zoomSpeed : 1 / zoomSpeed);
            if (newZoom > MAX_ZOOM) newZoom = MAX_ZOOM;
            if (newZoom < MIN_ZOOM) newZoom = MIN_ZOOM;

            const actualScale = newZoom / currentZoom;
            currentZoom = newZoom;

            const pt = svgElement.createSVGPoint();
            pt.x = e.offsetX;
            pt.y = e.offsetY;
            const cursorPt = pt.matrixTransform(svgElement.getScreenCTM().inverse());

            viewBox.x = cursorPt.x - (cursorPt.x - viewBox.x) * actualScale;
            viewBox.y = cursorPt.y - (cursorPt.y - viewBox.y) * actualScale;
            viewBox.width *= actualScale;
            viewBox.height *= actualScale;

            svgElement.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
        });

        svgElement.addEventListener('mousedown', (e) => {
            isPanning = true;
            startX = e.clientX;
            startY = e.clientY;
            svgElement.style.cursor = "grabbing";
        });

        svgElement.addEventListener('mousemove', (e) => {
            if (!isPanning) return;
            const dx = (e.clientX - startX) * (viewBox.width / svgElement.clientWidth);
            const dy = (e.clientY - startY) * (viewBox.height / svgElement.clientHeight);
            viewBox.x -= dx;
            viewBox.y -= dy;
            svgElement.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
            startX = e.clientX;
            startY = e.clientY;
        });

        svgElement.addEventListener('mouseup', () => {
            isPanning = false;
            svgElement.style.cursor = "grab";
        });
        svgElement.addEventListener('mouseleave', () => {
            isPanning = false;
            svgElement.style.cursor = "default";
        });

        const zoomControls = document.createElement('div');
        zoomControls.style.position = 'absolute';
        zoomControls.style.top = '20px';
        zoomControls.style.right = '20px';
        zoomControls.style.zIndex = '9999';
        zoomControls.style.display = 'flex';
        zoomControls.style.flexDirection = 'column';
        zoomControls.style.gap = '8px';

        zoomControls.innerHTML = `
        <button id="zoom-in" style="padding:6px 10px;background:#2e7d32;color:white;border:none;border-radius:4px;font-size:18px;cursor:pointer;">+</button>
        <button id="zoom-out" style="padding:6px 10px;background:#c62828;color:white;border:none;border-radius:4px;font-size:18px;cursor:pointer;">−</button>
        <button id="reset-zoom" style="padding:6px 10px;background:#1565c0;color:white;border:none;border-radius:4px;font-size:16px;cursor:pointer;">⟳</button>
        `;
        zoomControls.classList.add('zoom-controls');
        mapContainer.appendChild(zoomControls);

        function applyZoom(scaleFactor) {
            const newZoom = currentZoom * scaleFactor;
            if (newZoom > MAX_ZOOM || newZoom < MIN_ZOOM) return;

            currentZoom = newZoom;
            const centerX = viewBox.x + viewBox.width / 2;
            const centerY = viewBox.y + viewBox.height / 2;
            viewBox.width /= scaleFactor;
            viewBox.height /= scaleFactor;
            viewBox.x = centerX - viewBox.width / 2;
            viewBox.y = centerY - viewBox.height / 2;
            svgElement.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
        }

        document.getElementById('zoom-in').addEventListener('click', () => applyZoom(1.2));
        document.getElementById('zoom-out').addEventListener('click', () => applyZoom(1 / 1.2));
        document.getElementById('reset-zoom').addEventListener('click', () => {
            currentZoom = 1;
            viewBox = { ...originalViewBox };
            svgElement.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
        });

        
        // fungsi untuk menambahkan titik lokasi
        addPointsOfInterest();
    });
    
 
</script>
</body>
</html>

