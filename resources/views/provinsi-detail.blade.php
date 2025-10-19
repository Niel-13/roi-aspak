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
            background-color: #007bff;
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
<body class="bg-gray-100 flex flex-col h-screen">
    <div id="map-tooltip" class="hidden absolute bg-gray-800 text-white text-sm rounded-md py-1 px-2 shadow-lg"></div>
    <div class="header shadow-md p-4 flex justify-between items-center bg-white">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Pencarian" class="border rounded-md py-1 px-3 pl-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="relative">
                <select class="border rounded-md py-1 px-3 pr-8 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                    <option>Dinas Kesehatan DKI Jakarta</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>

        <h1 class="text-xl font-semibold text-gray-700 text-center">ASPAK KEMENKES</h1>

        <div class="navbar flex space-x-1 text-center justify-center items-center">
            <a href="#" class="active text-sm py-1 px-3 rounded-md">Rumah Sakit</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Sarana</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Prasarana</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Alat Kesehatan</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Bahan</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">SDM</a>
        </div>
    </div>

    <!-- <div class="container mx-auto p-6 flex">
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
    </div> -->

        <div class="w-full px-6 pb-6 pt-6 max-h-[65vh]">
        <div class="w-full bg-white p-4 shadow-md rounded-lg">
            <div id="map-container" class="w-full h-auto relative">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" class="max-w-xl h-auto mx-auto pb-6" viewBox="430 438 12 10">
                    <g id="DKI_Jakarta">
                        <path id="Kota_Adm._Jakarta_Pusat" title="Kota Adm. Jakarta Pusat" d="m436.91 441.5-0.75 1.03-0.09 0.13-0.13 0.18-1.6 0.65-0.08 0.03-0.06 0.02-0.11-0.7 0.45-1.1 0.18-0.43 0.31-0.77 0.45 0.22 0.08 0.05 0.17 0.08 0.3 0.16z" />
                        <path id="Kota_Adm._Jakarta_Selatan" title="Kota Adm. Jakarta Selatan" d="m435.94 442.84 0.45 1.25 0.04 0.11-0.38 1.38-0.04 0.13-0.01 0.02-0.02 0.11h-0.01l-0.15 0.55-0.08 0.3-0.01 0.03-0.03 0.11-0.02 0.07-0.03 0.11v0.01l-1.48 0.93h-0.01 0.01l0.47-1.62-0.95 0.05-0.01 0.01v-0.01l-0.16-0.34-0.04-0.09-0.05-0.09-0.05-0.11-0.13-0.28-0.04-0.07-0.11-0.24-0.02-0.03-0.22-0.47-0.02-0.05-0.03-0.06-0.16-0.33v-0.01l-0.37-0.84 0.02-0.01 1.49-0.43 0.3-0.09 0.11 0.7 0.06-0.02 0.08-0.03z" />
                        <path id="Kota_Adm._Jakarta_Timur" title="Kota Adm. Jakarta Timur" d="m439.93 441.11 0.01 0.15 0.03 0.43 0.01 0.09-0.05 0.13-0.44 1.17-0.45 1.22-0.93 0.18-0.01 0.01-0.3 0.06h-0.02v0.02l0.03 0.34 0.24 2.85v0.01l0.02 0.21-0.41 0.1-0.26 0.06-0.3 0.07-0.65-0.54-0.27-0.22-0.33-0.27-0.2-0.16v-0.01l0.03-0.11 0.02-0.07 0.03-0.11 0.01-0.03 0.08-0.3 0.15-0.55h0.01l0.02-0.11 0.01-0.02 0.04-0.13 0.38-1.38-0.04-0.11-0.45-1.25 0.13-0.18 0.09-0.13 0.75-1.03h0.01l1.41 0.54v-0.01l-0.01-0.67h0.02l0.71-0.11 0.49-0.08 0.32-0.05z" />
                        <path id="Kota_Adm._Jakarta_Barat" title="Kota Adm. Jakarta Barat" d="m431.45 439.21 1.98 1.45 0.09 0.07 0.07 0.04 0.77-0.12 0.67-0.11-0.31 0.77-0.18 0.43-0.45 1.1-0.3 0.09-1.49 0.43-0.02 0.01-0.01-0.01-0.47-0.49-1.15-1.18 0.01-0.64 0.01-0.36v-0.54l0.02-0.79v-0.12z" />
                        <path id="Kota_Adm._Jakarta_Utara" title="Kota Adm. Jakarta Utara" d="m439.88 439.03 0.04 1.5 0.01 0.58-0.07 0.01-0.32 0.05-0.49 0.08-0.71 0.11h-0.02l0.01 0.67v0.01l-1.41-0.54h-0.01l-0.88-0.45-0.3-0.16-0.17-0.08-0.08-0.05-0.45-0.22-0.67 0.11-0.77 0.12-0.07-0.04-0.09-0.07-1.98-1.45 0.37-0.18 0.1-0.03 0.05 0.02 0.09 0.18 0.32 0.2 0.27-0.07 0.27 0.13 0.26-0.08 0.14 0.05 0.11 0.07 0.06-0.02 0.07 0.02-0.06 0.16 0.07-0.13 0.29 0.17 0.01-0.1h0.01l0.7 0.21v0.01l0.15 0.25v-0.11l0.15 0.02 0.01-0.08 0.15 0.05 0.02 0.1 0.02-0.09 0.22 0.07 0.06-0.01h0.37l-0.08 0.09 0.56-0.24v-0.04l0.13-0.03v0.01l0.07-0.02 0.04-0.01-0.06 0.24 0.12-0.03-0.04-0.21 0.01-0.01 0.17-0.03-0.02 0.07 0.09-0.01 0.02-0.08 1.06-0.23 0.02 0.13 0.01-0.14 0.4-0.09 0.01 0.09 0.02-0.09 0.63-0.14 0.03 0.02 0.74-0.19 0.19-0.04z"/> 
                    </g>
                </svg>

                <div id="map-legend" class="absolute bottom-4 left-4 bg-gray-200 bg-opacity-80 p-3 rounded-md shadow text-xs z-10">
                <h3 class="font-semibold mb-2">Legend</h3>
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

                <div class="w-full px-6 pb-6 -mt-4 text-center relative z-10">
                    <p class="inline-block text-base font-bold bg-blue-700 text-white rounded py-1 px-4 mr-1 shadow" id="current-date">
                    </p>
                    <p class="inline-block text-base font-bold bg-white text-black rounded py-1 px-4 ml-1 shadow" id="current-time">
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-6 pb-6 flex space-x-6">
        <div class="w-1/2 bg-white p-4 shadow-md rounded-lg">
            <h3 class="font-semibold text-lg mb-2">Kondisi:</h3>
            <div id="kondisi-kabupaten" class="text-gray-700 space-y-1">
                <p>Pilih kota/kabupaten untuk melihat kondisi.</p>
            </div>
        </div>
        <div class="w-1/2 bg-white p-4 shadow-md rounded-lg">
            <h3 class="font-semibold text-lg mb-2">Rekomendasi:</h3>
            <p id="rekomendasi-kabupaten" class="text-gray-700">Rekomendasi akan muncul di sini.</p>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const kabupatensData = @json($kabupatens);
    const pointsData = @json($pointsOfInterest);
    const mapContainer = document.getElementById('map-container');
    const svgElement = mapContainer.querySelector('svg');
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

    function addPointsOfInterest() {
        const poiGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        svgElement.appendChild(poiGroup);

        pointsData.forEach(point => {
            const targetKabupatenName = Object.keys(kabupatensData)
                .find(k => kabupatensData[k].id === point.kabupaten_id);

            if (!targetKabupatenName) {
                console.error(` GAGAL: Tidak menemukan kabupaten/kota dengan ID: ${point.kabupaten_id}`);
                return;
            }

            const svgId = targetKabupatenName.replace(/ /g, '_');
            const pathElement = svgElement.querySelector(`#${svgId}`);
            if (!pathElement) return;

            const bbox = pathElement.getBBox();
            const cx = bbox.x + bbox.width / 2;
            const cy = bbox.y + bbox.height / 2;

            const groupWrapper = document.createElementNS('http://www.w3.org/2000/svg', 'g');
            const pulseCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            pulseCircle.setAttribute('cx', cx);
            pulseCircle.setAttribute('cy', cy);
            pulseCircle.setAttribute('class', 'poi-dot poi-pulse');
            const mainCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            mainCircle.setAttribute('cx', cx);
            mainCircle.setAttribute('cy', cy);
            mainCircle.setAttribute('r', '3');
            mainCircle.setAttribute('class', 'poi-dot');

            groupWrapper.appendChild(pulseCircle);
            groupWrapper.appendChild(mainCircle);
            poiGroup.appendChild(groupWrapper);

            groupWrapper.addEventListener('mouseover', () => {
                tooltip.innerHTML = `<strong>${point.nama}</strong><br>${point.alamat}`;
                tooltip.classList.remove('hidden');
            });
            groupWrapper.addEventListener('mouseleave', () => tooltip.classList.add('hidden'));
            groupWrapper.addEventListener('mousemove', e => {
                tooltip.style.left = (e.clientX + 15) + 'px';
                tooltip.style.top = (e.clientY + 15) + 'px';
            });
        });
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
    addPointsOfInterest();
});
</script>
</body>
</html>

