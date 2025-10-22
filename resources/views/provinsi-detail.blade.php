<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ASPAK KEMENKES</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8fafc;
      color: #1e293b;
    }

    /* HEADER */
    .header {
      background: linear-gradient(90deg, #007bff, #2563eb);
      color: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .navbar a {
      padding: 0.4rem 0.4rem;
      font-weight: 500;
      border-radius: 0.25rem;
      transition: all 0.2s ease-in-out;
    }
    .navbar a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }
    .navbar a.active {
      background-color: white;
      color: #2563eb;
      font-weight: 600;
    }

    /* LEGEND */
    .legend-box {
      width: 14px;
      height: 14px;
      border-radius: 2px;
      display: inline-block;
      margin-right: 6px;
    }
    #map-legend {
      background-color: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(4px);
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* TOOLTIP */
    #map-tooltip {
      position: absolute;
      z-index: 9999;
      pointer-events: none;
      background: rgba(30, 41, 59, 0.9);
      color: white;
      padding: 6px 10px;
      border-radius: 4px;
      font-size: 12px;
      white-space: nowrap;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      transition: opacity 0.15s ease;
    }

    /* MAP & DOTS */
    #map-container {
      position: relative;
      overflow: visible;
      border-radius: 0.75rem;
      background: #fff;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }

    #indonesia-map path {
      stroke: #fff;
      stroke-width: 0.5px;
      transition: fill 0.3s ease;
    }
    #indonesia-map path:hover {
      fill-opacity: 0.8;
      cursor: pointer;
    }

    .poi-dot {
      fill: #ff3b3b;
      stroke: #fff;
      stroke-width: 1px;
      cursor: pointer;
    }
    .poi-dot:hover {
      fill: #c91818;
    }

    @keyframes pulse {
      0% {
        r: 3px;
        opacity: 1;
      }
      50% {
        r: 7px;
        opacity: 0.5;
      }
      100% {
        r: 3px;
        opacity: 1;
      }
    }
    .poi-pulse {
      animation: pulse 2s infinite;
    }

    /* ZOOM CONTROL */
    .zoom-controls button {
      width: 36px;
      height: 36px;
      font-weight: bold;
      border-radius: 0.4rem;
      border: none;
      color: white;
      cursor: pointer;
      transition: transform 0.1s ease, opacity 0.1s;
    }

    .zoom-controls button:hover {
      transform: scale(1.1);
      opacity: 0.9;
    }

    /* COLORS */
    .color-81-100 { fill: #2D9CDB; }
    .color-61-80 { fill: #34D399; }
    .color-41-60 { fill: #FFFF00; }
    .color-21-40 { fill: #FFA500; }
    .color-0-20 { fill: #EF4444; }
  </style>
</head>
<body class="flex flex-col h-screen">
  <!-- Tooltip -->
  <div id="map-tooltip" class="hidden"></div>

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
    <div id="map-container" class="w-full p-4 shadow-md rounded-lg relative">
      @php
      $pathSvg = public_path('images/maps/' . $namaFileSvg);
      if (file_exists($pathSvg)) {
          echo file_get_contents($pathSvg);
      } else {
          echo "<p class='text-red-500'>Peta belum tersedia.</p>";
      }
      @endphp

      <!-- LEGEND -->
      <div
        id="map-legend"
        class="absolute bottom-4 left-4 p-3 text-xs text-gray-800"
      >
        <h3 class="font-semibold mb-2">Legend</h3>
        <div class="space-y-1">
          <div><span class="legend-box" style="background:#2D9CDB"></span>81–100%</div>
          <div><span class="legend-box" style="background:#34D399"></span>61–80%</div>
          <div><span class="legend-box" style="background:#FFFF00"></span>41–60%</div>
          <div><span class="legend-box" style="background:#FFA500"></span>21–40%</div>
          <div><span class="legend-box" style="background:#EF4444"></span>0–20%</div>
        </div>
      </div>

      <!-- TIME -->
      <div class="absolute bottom-4 w-full flex justify-center">
        <div class="text-center space-x-2">
        <span id="current-date" class="inline-block bg-blue-600 text-white font-semibold py-1 px-3 rounded shadow"></span>
        <span id="current-time" class="inline-block bg-white text-gray-900 font-semibold py-1 px-3 rounded shadow"></span>
      </div>
      </div>
    </div>

    <!-- INFO PANELS -->
    <div class="flex space-x-6">
      <div class="w-1/2 bg-white p-5 shadow-md rounded-lg">
        <h3 class="font-semibold text-lg mb-2">Kondisi:</h3>
        <div id="kondisi-kabupaten" class="text-gray-700 space-y-1">
          <p>Pilih kota/kabupaten untuk melihat kondisi.</p>
        </div>
      </div>
      <div class="w-1/2 bg-white p-5 shadow-md rounded-lg">
        <h3 class="font-semibold text-lg mb-2">Rekomendasi:</h3>
        <p id="rekomendasi-kabupaten" class="text-gray-700">
          Rekomendasi akan muncul di sini.
        </p>
      </div>
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
    const provinsiSelectDetail = document.getElementById('provinsi-select-detail');
    // const svgId = path.id;
    // const namaKabupaten = svgId.replace(/_/g, ' ');
    // const data = kabupatensData[namaKabupaten];


    if (provinsiSelectDetail) {
        console.log("Event listener untuk 'provinsi-select-detail' (detail) berhasil dipasang."); // DEBUG
        
        provinsiSelectDetail.addEventListener('change', function() {
            const selectedValue = this.value;
            console.log("Dropdown diubah, nilai baru:", selectedValue); // DEBUG

            if (selectedValue === 'all') {
                window.location.href = '/';
            } else {
                window.location.href = `/provinsi/${selectedValue}`;
            }
        });
    } else {
        console.error("Gagal menemukan elemen #provinsi-select-detail."); // DEBUG
    }

    function updateDateTime() {
        const now = new Date();
        const optionsDate = { day: '2-digit', month: '2-digit', year: 'numeric' };
        currentDate.textContent = now.toLocaleDateString('id-ID', optionsDate);
        currentTime.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(/\./g, ':');
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    function getClassNameByPersentase(p) {
        if (p >= 81) return 'color-81-100';
        if (p >= 61) return 'color-61-80';
        if (p >= 41) return 'color-41-60';
        if (p >= 21) return 'color-21-40';
        return 'color-0-20';
    }

    function getTingkatanByPersentase(p) {
        if (p >= 81) return 'Sangat Baik';
        if (p >= 61) return 'Baik';
        if (p >= 41) return 'Cukup';
        if (p >= 21) return 'Kurang';
        return 'Sangat Rendah';
    }


    const paths = svgElement.querySelectorAll('path');
    paths.forEach(path => {
        const svgId = path.id; 
        const namaKabupaten = svgId.replace(/_/g, ' ');
        const data = kabupatensData[namaKabupaten];
        
        if (data) {
            const className = getClassNameByPersentase(data.persentase);
            path.classList.add('kabupaten'); 
            path.classList.add(className);
        }

        // --- 2. Event Listener Klik (Diperbaiki) ---
        path.addEventListener('click', function() {
            // Ambil data di DALAM event
            const klikSvgId = this.id;
            const klikNamaKabupaten = klikSvgId.replace(/_/g, ' ');
            const klikData = kabupatensData[klikNamaKabupaten];

            if (klikData) {
                window.location.href = `/kabupaten/${klikData.id}`;
            }
        });


        path.addEventListener('mouseover', function(event) {
            const hoverSvgId = this.id;
            const hoverNamaKabupaten = hoverSvgId.replace(/_/g, ' ');
            const hoverData = kabupatensData[hoverNamaKabupaten];

            if (hoverData) {
                tooltip.innerHTML = `<strong>${hoverData.nama}</strong><br>Tingkat: ${getTingkatanByPersentase(hoverData.persentase)}<br>Persentase: ${hoverData.persentase}%`;
                tooltip.classList.remove('hidden');
                // Update posisi di sini
                tooltip.style.left = (event.clientX + 15) + 'px';
                tooltip.style.top = (event.clientY + 15) + 'px';
            }
        });

        // --- 4. Event Listener Mouse Keluar (Tidak Berubah) ---
        path.addEventListener('mouseleave', function() {
            tooltip.classList.add('hidden');
        });

        // --- 5. Event Listener Mouse Bergerak (Hanya Update Posisi) ---
        path.addEventListener('mousemove', function(event) {
            // Hanya update posisi jika tooltip terlihat
            if (!tooltip.classList.contains('hidden')) {
                tooltip.style.left = (event.clientX + 15) + 'px';
                tooltip.style.top = (event.clientY + 15) + 'px';
            }
        });
    });

    function addPointsOfInterest() {
        const poiGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        svgElement.appendChild(poiGroup);

        pointsData.forEach(point => {
            const targetKabupatenName = Object.keys(kabupatensData)
                .find(k => kabupatensData[k].id === point.kabupaten_id);

            if (!targetKabupatenName) {
                console.error(`GAGAL: Tidak menemukan kabupaten/kota dengan ID: ${point.kabupaten_id}`);
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

    addPointsOfInterest();
});
</script>
</body>
</html>

