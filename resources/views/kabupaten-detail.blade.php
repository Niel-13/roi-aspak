<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail: {{ $kabupaten->nama }}</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body { 
      font-family: 'Inter', sans-serif; 
      background-color: #f8fafc; 
      color: #1e293b;
    }

    /* HEADER STYLE */
    .header {
      background: linear-gradient(90deg, #007bff, #2563eb);
      color: white;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .navbar a {
      padding: 0.4rem 0.4rem;
      font-weight: 500;
      border-radius: 0.25rem;
      transition: all 0.2s ease-in-out;
    }
    .navbar a:hover {
      background-color: rgba(255,255,255,0.2);
    }
    .navbar a.active {
      background-color: white;
      color: #2563eb;
      font-weight: 600;
    }

    /* MAP WRAPPER */
    #map-container {
      position: relative;
      width: 100%;
      background: white;
      border-radius: 0.75rem;
      overflow: hidden;
      border: 1px solid #e2e8f0;
      transition: box-shadow 0.3s;
    }
    #map-container:hover {
      box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    }

    .hospital-item {
      position: absolute;
      text-align: center;
      pointer-events: auto;
      cursor: pointer;
      font-size: 10px;
      font-weight: bold;
      color: #111827;
      text-shadow: 0px 0px 3px rgba(255,255,255,0.7);
      transition: transform 0.2s ease-in-out;
    }
    .hospital-item:hover {
      transform: scale(1.1);
    }

    .hospital-item img {
      width: 36px;
      height: 36px;
      margin-bottom: 2px;
      filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
    }

    /* LEGEND */
    #map-legend {
      background-color: rgba(255,255,255,0.9);
      backdrop-filter: blur(4px);
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .legend-box {
      width: 14px; 
      height: 14px; 
      display: inline-block; 
      border-radius: 2px; 
      margin-right: 6px;
    }

    /* TOOLTIP */
    #map-tooltip {
      position: absolute;
      z-index: 9999;
      pointer-events: none;
      background: rgba(30,41,59,0.9);
      color: white;
      padding: 6px 10px;
      border-radius: 4px;
      font-size: 12px;
      white-space: nowrap;
      box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    }

    /* COLORS */
    .color-81-100 { fill: #2D9CDB; } .bg-81-100 { background-color: #2D9CDB; }
    .color-61-80 { fill: #34D399; } .bg-61-80 { background-color: #34D399; }
    .color-41-60 { fill: #FFFF00; } .bg-41-60 { background-color: #FFFF00; }
    .color-21-40 { fill: #FFA500; } .bg-21-40 { background-color: #FFA500; }
    .color-0-20 { fill: #EF4444; }  .bg-0-20  { background-color: #EF4444; }

  </style>
</head>

<body class="flex flex-col h-screen">

  <!-- HEADER -->
  <div class="header shadow-md p-4 flex justify-between items-center">
    <div class="flex items-center space-x-4">
      <!-- Search -->
      <div class="relative">
        <input type="text" placeholder="Pencarian..." class="border rounded-md py-1 px-3 pl-8 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </div>

      <!-- Dropdown -->
      <div class="relative">
        <select id="provinsi-select-detail" class="border rounded-md py-1 px-3 pr-8 text-sm bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
          <option value="all">Kementerian Kesehatan</option>
          @foreach($all_provinsis as $nama_prov => $data_prov)
            <option value="{{ $nama_prov }}" @selected($nama_prov == $provinsi->nama)>
              Dinas Kesehatan {{ $nama_prov }}
            </option>
          @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>

    <h1 class="text-lg font-semibold tracking-wide text-center">ASPAK KEMENKES</h1>

    <!-- Navbar -->
    <div class="navbar flex space-x-1 text-center justify-center items-center">
            <a href="#" class="active text-sm py-1 px-3 rounded-md">Rumah Sakit</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Sarana</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Prasarana</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Alat Kesehatan</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">Bahan</a>
            <a href="#" class="text-sm py-1 px-3 rounded-md">SDM</a>
    </div>
  </div>

  <!-- MAP SECTION -->
  <div class="w-full px-6 py-6 flex flex-col space-y-6 overflow-visible">
    <div id="map-container" class="shadow-lg ">
      @php
        $pathSvg = public_path('images/maps/' . $namaFileSvg);
        if (file_exists($pathSvg)) {
          echo file_get_contents($pathSvg);
        } else {
          echo "<p class='text-red-500'>Peta untuk provinsi ini belum tersedia.</p>";
        }
      @endphp

      <div id="hospital-layer" class="absolute inset-0 w-full h-full pointer-events-none"></div>

      <!-- Legend -->
      <div id="map-legend" class="absolute bottom-4 left-4 p-3 text-xs">
        <h3 class="font-semibold mb-2 text-gray-800">Legend</h3>
        <div class="space-y-1 text-gray-700">
          <div><span class="legend-box bg-81-100"></span>81–100%</div>
          <div><span class="legend-box bg-61-80"></span>61–80%</div>
          <div><span class="legend-box bg-41-60"></span>41–60%</div>
          <div><span class="legend-box bg-21-40"></span>21–40%</div>
          <div><span class="legend-box bg-0-20"></span>0–20%</div>
        </div>
      </div>

      <!-- Time display -->
      <div class="absolute bottom-4 w-full flex justify-center">
        <div class="text-center space-x-2">
        <span id="current-date" class="inline-block bg-blue-600 text-white font-semibold py-1 px-3 rounded shadow"></span>
        <span id="current-time" class="inline-block bg-white text-gray-900 font-semibold py-1 px-3 rounded shadow"></span>
      </div>
      </div>
    </div>

    <!-- Info Panels -->
    <div class="flex space-x-6">
      <div class="w-1/2 bg-white p-5 shadow-md rounded-lg">
        <h3 class="font-semibold text-lg mb-2">Kondisi:</h3>
        <div id="kondisi-kabupaten" class="text-gray-700 space-y-1">
          <p>Pilih untuk melihat kondisi.</p>
        </div>
      </div>

      <div class="w-1/2 bg-white p-5 shadow-md rounded-lg">
        <h3 class="font-semibold text-lg mb-2">Rekomendasi:</h3>
        <p id="rekomendasi-kabupaten" class="text-gray-700">Rekomendasi akan muncul di sini.</p>
      </div>
    </div>
  </div>

  <!-- Tooltip -->
  <div id="map-tooltip" class="hidden"></div>

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