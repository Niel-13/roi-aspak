<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail RS: {{ $hospital->nama_rs }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Header modern */
        .header {
            background: linear-gradient(90deg, #007bff, #005fcc);
            color: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            font-weight: 600;
        }

        /* Floor button modern */
        .floor-button {
            background-color: #fff;
            border: 1px solid #d1d5db;
            padding: 8px 14px;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease-in-out;
        }
        .floor-button:hover {
            background-color: #e0f2fe;
            transform: translateY(-2px);
        }
        .floor-button.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
            box-shadow: 0 3px 6px rgba(0,123,255,0.3);
        }

        /* Floor plan container */
        #floor-plan-container {
            position: relative;
            width: 100%;
            background: #ffffff;
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: box-shadow 0.3s;
        }
        #floor-plan-container:hover {
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        }
        #floor-plan-image {
            width: 100%;
            height: auto;
        }

        .room-path {
            transition: fill 0.2s ease-in-out;
            cursor: pointer;
        }
        .room-path:hover {
            fill: #93c5fd;
        }
        .room-path.active-room {
            fill: #2563eb !important;
        }

        /* Product card modern */
        #product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            height: 60vh;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .product-item {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.75rem;
            background: #ffffff;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s;
        }
        .product-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .product-item img {
            width: 100%;
            height: 100px;
            object-fit: contain;
            margin-bottom: 0.5rem;
        }

        /* Availability bar modern */
        .availability-bar {
            width: 40px;
            height: 10px;
            border-radius: 0.25rem;
            margin-right: 6px;
        }
        .avail-green { background-color: #22c55e; }
        .avail-yellow { background-color: #facc15; }
        .avail-red { background-color: #ef4444; }

        /* Detail button */
        .detail-button {
            background-color: #2563eb;
            color: white;
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .detail-button:hover {
            background-color: #1d4ed8;
        }

        /* Legend modern */
        .availability-legend {
            font-size: 0.9rem;
            color: #475569;
        }
        .availability-legend span {
            width: 16px;
            height: 16px;
            display: inline-block;
            border-radius: 0.25rem;
            margin-right: 6px;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="flex flex-col h-screen">

    <!-- Header -->
    <div class="header shadow-md p-4 grid grid-cols-3 items-center">
        <div class="flex items-center space-x-4">
            <select id="provinsi-select-detail" class="border rounded-md py-1 px-3 text-sm text-gray-700">
                <option value="all">Kementerian Kesehatan</option>
                @foreach($all_provinsis as $nama_prov => $data_prov)
                    <option value="{{ $nama_prov }}" @selected($nama_prov == $provinsi->nama)>
                        Dinas Kesehatan {{ $nama_prov }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="navbar flex justify-center">
            <h1 class="text-lg font-semibold tracking-wide">{{ $kabupaten->nama }}</h1>
        </div>

        <h1 class="text-lg font-bold text-right tracking-wide">ASPAK KEMENKES</h1>
    </div>

    <!-- Main content -->
    <div class="flex-grow overflow-auto p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $hospital->nama_rs }}</h2>

        <div class="flex space-x-6 items-start">
            <!-- Left: Floor plan -->
            <div class="w-1/2">
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($floors as $floor)
                        <button class="floor-button {{ $floor->id == $currentFloor->id ? 'active' : '' }}"
                                data-floor-id="{{ $floor->id }}"
                                data-denah-src="{{ asset($floor->gambar_denah) }}">
                            {{ $floor->nama_lantai }}
                        </button>
                    @endforeach
                </div>

                <div id="floor-plan-container" class="p-4 shadow-lg rounded-lg bg-white h-[60vh] overflow-auto">
                    @php
                        $pathSvg = public_path('images/denah/' . $namaFileDenah);
                        if (file_exists($pathSvg)) {
                            echo file_get_contents($pathSvg);
                        } else {
                            echo "<p class='text-red-500'>Data denah belum tersedia untuk lantai ini.</p>";
                        }
                    @endphp
                </div>
            </div>

            <!-- Right: Product list -->
            <div class="w-1/2">
                <div class="bg-white p-5 shadow-lg rounded-lg h-[60vh] flex flex-col justify-between">
                    <h3 class="font-semibold text-lg mb-2">Daftar Produk</h3>
                    <p id="room-name" class="text-md font-bold text-blue-600 mb-3">Pilih ruangan di denah...</p>
                    <div id="product-list"></div>

                    <div class="mt-6 border-t pt-4 availability-legend">
                        <div class="flex items-center mb-2">
                            <span class="avail-green"></span><p>&gt; 70% Tersedia</p>
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="avail-yellow"></span><p>50–70%</p>
                        </div>
                        <div class="flex items-center">
                            <span class="avail-red"></span><p>&lt; 50%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roomsData = @json($rooms);
    const svgElement = document.querySelector('#floor-plan-container svg');
    const productList = document.getElementById('product-list');
    const roomNameEl = document.getElementById('room-name');
    const provinsiSelectDetail = document.getElementById('provinsi-select-detail');
    const floorButtons = document.querySelectorAll('.floor-button');
    const currentUrl = window.location.pathname;

    floorButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.classList.contains('active')) return;
            const floorId = this.dataset.floorId;
            window.location.href = `${currentUrl}?floor=${floorId}`;
        });
    });

    function getAvailabilityClasses(percent) {
        if (percent > 70) return 'avail-green';
        else if (percent >= 50) return 'avail-yellow';
        else return 'avail-red';
    }

    if (svgElement) {
        for (const kodeSvg in roomsData) {
            const roomData = roomsData[kodeSvg];
            const pathElement = svgElement.querySelector(`#${kodeSvg}`);
            if (pathElement) {
                pathElement.classList.add('room-path');
                pathElement.addEventListener('click', function() {
                    svgElement.querySelectorAll('.room-path.active-room').forEach(p => p.classList.remove('active-room'));
                    this.classList.add('active-room');
                    const roomId = roomData.id;
                    roomNameEl.textContent = `Produk di: ${roomData.nama_ruangan}`;
                    productList.innerHTML = '<p>Memuat produk...</p>';

                    fetch(`/api/rooms/${roomId}/products`)
                        .then(res => res.json())
                        .then(products => {
                            productList.innerHTML = '';
                            if (products.length === 0) {
                                productList.innerHTML = '<p class="text-gray-500">Tidak ada produk di ruangan ini.</p>';
                                return;
                            }
                            products.forEach(product => {
                                const availClass = getAvailabilityClasses(product.persentase);
                                const html = `
                                    <div class="product-item">
                                        <img src="{{ asset('/') }}${product.gambar_produk}" alt="${product.nama_produk}">
                                        <h5 class="font-semibold text-sm mt-1">${product.nama_produk}</h5>
                                        <div class="flex justify-center items-center mt-2">
                                            <span class="availability-bar ${availClass}"></span>
                                            <a href="${product.link_detail || '#'}" target="_blank" class="detail-button">Detail</a>
                                        </div>
                                    </div>`;
                                productList.insertAdjacentHTML('beforeend', html);
                            });
                        })
                        .catch(err => {
                            console.error(err);
                            productList.innerHTML = '<p class="text-red-500">Gagal memuat produk.</p>';
                        });
                });
            }
        }
    }

    if (provinsiSelectDetail) {
        provinsiSelectDetail.addEventListener('change', function() {
            const val = this.value;
            if (val === 'all') window.location.href = '/';
            else window.location.href = `/provinsi/${val}`;
        });
    }
});
</script>
</body>
</html>
