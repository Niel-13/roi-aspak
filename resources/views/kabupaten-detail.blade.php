<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail: {{ $kabupaten->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
<style>
        body { font-family: Arial, sans-serif; background-color: #f0f2f5; }
        
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
        
        .legend-box { width: 12px; height: 12px; display: inline-block; vertical-align: middle; margin-right: 5px; border-radius: 2px; }
        
        /* Warna Peta */
        .color-81-100 { fill: #2D9CDB; } .bg-81-100 { background-color: #2D9CDB; }
        .color-61-80 { fill: #34D399; } .bg-61-80 { background-color: #34D399; }
        .color-41-60 { fill: #FFFF00; } .bg-41-60 { background-color: #FFFF00; }
        .color-21-40 { fill: #FFA500; } .bg-21-40 { background-color: #FFA500; }
        .color-0-20 { fill: #EF4444; } .bg-0-20 { background-color: #EF4444; }

        /* Style untuk Ikon RS (HTML) */
        .hospital-item {
            position: absolute;
            text-align: center;
            pointer-events: auto; /* Agar bisa di-hover */
            cursor: pointer;
            font-size: 10px;
            font-weight: bold;
            color: #333;
            text-shadow: 0px 0px 3px white;
        }
        .hospital-item img {
            width: 32px; /* Ukuran ikon statis */
            height: 32px;
            margin-bottom: 2px;
        }
        
        /* Style untuk Tooltip */
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
                <select id="provinsi-select-detail" class="border rounded-md py-1 px-3 pr-8 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                    <option value="all">Kementerian Kesehatan</option>
                    @foreach($all_provinsis as $nama_prov => $data_prov)
                        <option value="{{ $nama_prov }}" @selected($nama_prov == $provinsi->nama)>
                           Dinas Kesehatan {{ $nama_prov }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>

        <h1 class="text-xl font-semibold text-gray-700 text-center">ASPAK KEMENKES</h1>

        <div class="navbar flex space-x-1 text-center justify-center items-center" >
            <a href="#" class="active text-sm py-1 px-3 rounded-md">Rumah Sakit</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Sarana</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Prasarana</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Alat Kesehatan</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Bahan</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">SDM</a>
        </div>
    </div>

    <div class="w-full px-6 pb-6 pt-6 max-h-[65vh]">
        <div class="w-full bg-white p-4 shadow-md rounded-lg">
            <div id="map-container" class="w-full h-auto relative">
                @php
                    $pathSvg = public_path('images/maps/' . $namaFileSvg); 
                    if (file_exists($pathSvg)) {
                        echo file_get_contents($pathSvg); 
                    } else {
                        echo "<p class='text-red-500'>Peta untuk provinsi ini belum tersedia. Pastikan file '{$namaFileSvg}' ada di folder public/images/maps/</p>";
                    }
                @endphp

               <div id="hospital-layer" class="absolute inset-0 w-full h-full pointer-events-none">
                    </div>

                <div id="map-legend" class="absolute bottom-4 left-4 bg-gray-200 bg-opacity-80 p-3 rounded-md shadow text-xs z-10">
                <h3 class="font-semibold mb-2">Legend</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="legend-box" style="background-color: #2D9CDB;"></span> <span>81-100%</span>
                        </div>
                        <div class="flex items-center">
                            <span class="legend-box" style="background-color: #34D399;"></span> <span>61-80%</span>
                        </div>
                        <div class="flex items-center">
                            <span class="legend-box" style="background-color: #FFFF00;"></span> <span>41-60%</span>
                        </div>
                        <div class="flex items-center">
                            <span class="legend-box" style="background-color: #FFA500;"></span> <span>21-40%</span>
                        </div>
                        <div class="flex items-center">
                            <span class="legend-box" style="background-color: #EF4444;"></span> <span>0-20%</span>
                        </div>
                    </div>
                </div>

                <div class="w-full px-6 pb-6 text-center relative z-10">
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
                    <p>Pilih untuk melihat kondisi.</p>
                </div>
            </div>
            <div class="w-1/2 bg-white p-4 shadow-md rounded-lg">
                <h3 class="font-semibold text-lg mb-2">Rekomendasi:</h3>
                <p id="rekomendasi-kabupaten" class="text-gray-700">Rekomendasi akan muncul di sini.</p>
            </div>
        </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. DEKLARASI VARIABEL
        const kabupaten = @json($kabupaten);
        const hospitals = @json($hospitals);
        const mapContainer = document.getElementById('map-container');
        const svgElement = mapContainer.querySelector('svg');
        const tooltip = document.getElementById('map-tooltip');
        const currentDate = document.getElementById('current-date');
        const currentTime = document.getElementById('current-time');
        const provinsiSelectDetail = document.getElementById('provinsi-select-detail');

        // 2. FUNGSI HELPER
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
            const hospitalLayer = document.getElementById('hospital-layer');
            if (!svgElement || !hospitals || hospitals.length === 0 || !hospitalLayer) {
                console.warn("Data Rumah Sakit atau layer 'hospital-layer' tidak ditemukan.");
                return;
            }

            hospitals.forEach(hospital => {
                const xPos = '50%';
                const yPos = '50%';

                const hospitalDiv = document.createElement('div');
                hospitalDiv.className = 'hospital-item';
                hospitalDiv.style.position = 'absolute';
                hospitalDiv.style.left = xPos;
                hospitalDiv.style.top = yPos;
                hospitalDiv.style.transform = 'translate(-50%, -50%)'; 

                // === PERIKSA NAMA FILE INI ===
                hospitalDiv.innerHTML = `
                    <img src="{{ asset('images/hospital_icon.png') }}" alt="Ikon RS">
                    <span>${hospital.nama_rs}</span>
                `;
                
                hospitalLayer.appendChild(hospitalDiv);

                // Tambahkan event tooltip

                hospitalDiv.addEventListener('click', function() {
                    window.location.href = `/hospital/${hospital.id}`;
                });

                hospitalDiv.addEventListener('mouseover', () => {
                    tooltip.innerHTML = `<strong>${hospital.nama_rs}</strong>`;
                    tooltip.classList.remove('hidden');
                });
                hospitalDiv.addEventListener('mouseleave', () => {
                    tooltip.classList.add('hidden');
                });
                hospitalDiv.addEventListener('mousemove', (e) => {
                    tooltip.style.left = (e.pageX + 15) + 'px';
                    tooltip.style.top = (e.pageY + 15) + 'px';
                });
            });
        }
        
        // 3. JALANKAN KODE UTAMA
        updateDateTime();
        setInterval(updateDateTime, 1000);

        const mapShape = document.getElementById('kabupaten-shape'); 
        if (mapShape && kabupaten) { 
            const colorClass = getClassNameByPersentase(kabupaten.persentase); 
            mapShape.classList.add(colorClass); 
        } else {
            console.error("GAGAL: Tidak menemukan path #kabupaten-shape atau data 'kabupaten' tidak ada. Pastikan file SVG Anda memiliki <path id='kabupaten-shape'>.");
        }

        if (provinsiSelectDetail) {
            provinsiSelectDetail.addEventListener('change', function() {
                const selectedValue = this.value;
                if (selectedValue === 'all') { window.location.href = '/'; }
                else { window.location.href = `/provinsi/${selectedValue}`; }
            });
        }
        addPointsOfInterest();
        
    });
</script>
</body>
</html>