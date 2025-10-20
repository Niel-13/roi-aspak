<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail RS: {{ $hospital->nama_rs }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f2f5; }
        
        /* Tombol Lantai */
        .floor-button {
            background-color: #fff; border: 1px solid #ccc;
            padding: 8px 16px; margin-bottom: 5px; border-radius: 6px;
            cursor: pointer; transition: background-color 0.2s;
        }
        .floor-button:hover { background-color: #f0f0f0; }
        .floor-button.active {
            background-color: #007bff; color: white; border-color: #007bff;
        }

        /* Area Denah */
        #floor-plan-container {
            position: relative;
            width: 100%;
            border: 1px solid #ccc;
            background-color: #fafafa;
        }
        #floor-plan-image {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* Titik Ruangan */
        .room-dot {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: rgba(0, 123, 255, 0.7);
            border: 2px solid white;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            
            /* Trik untuk menengahkan titik */
            transform: translate(-50%, -50%);
        }
        .room-dot:hover {
            transform: translate(-50%, -50%) scale(1.5);
            background-color: rgba(0, 80, 200, 0.9);
        }

        /* Sidebar Produk */
        #product-list { height: 60vh; overflow-y: auto; } /* Atur tinggi sidebar */
        .product-card {
            display: flex;
            align-items: center;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }
        .product-card img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 12px;
        }
        .availability-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col h-screen">

    <div class="header shadow-md p-4 grid grid-cols-3 items-center bg-white">
        <div class="flex items-center space-x-4">
             <select id="provinsi-select-detail" class="border rounded-md py-1 px-3 pr-8 text-sm ...">
                <option value="all">Kementerian Kesehatan</option>
                @foreach($all_provinsis as $nama_prov => $data_prov)
                    <option value="{{ $nama_prov }}" @selected($nama_prov == $provinsi->nama)>
                        Dinas Kesehatan {{ $nama_prov }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="navbar flex space-x-1 justify-center items-center">
            <h1 class="text-lg font-semibold">{{ $kabupaten->nama }}</h1>
        </div>
        <h1 class="text-xl font-semibold text-gray-700 text-right">ASPAK KEMENKES</h1>
    </div>

    <div class="flex-grow overflow-auto p-4">
        
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $hospital->nama_rs }}</h2>

        <div class="flex space-x-4">

            <div class="w-2/3">
                <div class="flex space-x-2 mb-2">
                    @foreach($floors as $floor)
                        <button class="floor-button {{ $floor->id == $currentFloor->id ? 'active' : '' }}" 
                                data-floor-id="{{ $floor->id }}"
                                data-denah-src="{{ asset($floor->gambar_denah) }}">
                            {{ $floor->nama_lantai }}
                        </button>
                    @endforeach
                </div>
                
               <div id="floor-plan-container">

                    @if ($currentFloor)
                        {{-- Tampilkan denah HANYA JIKA ada data lantai --}}
                        <img id="floor-plan-image" src="{{ asset($currentFloor->gambar_denah) }}" alt="Denah Lantai">
                        
                        <div id="room-layer">
                            @foreach($rooms as $room)
                                <div class="room-dot" 
                                     title="{{ $room->nama_ruangan }}" 
                                     data-room-id="{{ $room->id }}"
                                     style="left: {{ $room->posisi_x }}; top: {{ $room->posisi_y }};">
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Tampilkan pesan jika tidak ada data lantai --}}
                        <div class_name="p-10 text-center text-gray-500">
                            <p>Data denah untuk rumah sakit ini belum tersedia.</p>
                        </div>
                    @endif

                </div>
            </div>

            <div class="w-1/3">
                <div class="bg-white p-4 shadow-md rounded-lg">
                    <h3 class="font-semibold text-lg mb-2">Daftar Produk</h3>
                    <p id="room-name" class="text-md font-bold text-blue-600 mb-2">Pilih ruangan untuk melihat produk...</p>
                    
                    <div id="product-list" class="space-y-3">
                        </div>
                </div>
            </div>

        </div>
    </div> 
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const roomLayer = document.getElementById('room-layer');
    const productList = document.getElementById('product-list');
    const roomNameEl = document.getElementById('room-name');
    const provinsiSelectDetail = document.getElementById('provinsi-select-detail');

    // Tambahkan event listener ke semua titik ruangan
    roomLayer.querySelectorAll('.room-dot').forEach(dot => {
        dot.addEventListener('click', function() {
            const roomId = this.dataset.roomId;
            const roomName = this.getAttribute('title');
            
            roomNameEl.textContent = `Produk di: ${roomName}`;
            productList.innerHTML = '<p>Memuat produk...</p>'; // Tampilkan placeholder

            // Panggil API untuk mengambil data produk
            fetch(`/api/rooms/${roomId}/products`)
                .then(response => response.json())
                .then(products => {
                    productList.innerHTML = ''; // Kosongkan daftar

                    if (products.length === 0) {
                        productList.innerHTML = '<p>Tidak ada produk di ruangan ini.</p>';
                        return;
                    }

                    // Bangun HTML untuk setiap produk
                    products.forEach(product => {
                        const availabilityClass = product.ketersediaan ? 'bg-green-500' : 'bg-red-500';
                        const availabilityText = product.ketersediaan ? 'Tersedia' : 'Tidak Tersedia';

                        const productHtml = `
                            <div class="product-card">
                                <img src="{{ asset('/') }}${product.gambar_produk}" alt="${product.nama_produk}">
                                <div class="flex-grow">
                                    <h4 class="font-bold">${product.nama_produk}</h4>
                                    <p class="text-sm">
                                        <span class="availability-dot ${availabilityClass}"></span>
                                        ${availabilityText}
                                    </p>
                                </div>
                                <a href="${product.link_detail || '#'}" target="_blank" 
                                   class="bg-blue-500 text-white text-xs py-1 px-3 rounded hover:bg-blue-600">
                                   Detail
                                </a>
                            </div>
                        `;
                        productList.insertAdjacentHTML('beforeend', productHtml);
                    });
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    productList.innerHTML = '<p class="text-red-500">Gagal memuat produk.</p>';
                });
        });
    });
    
    if (provinsiSelectDetail) {
            provinsiSelectDetail.addEventListener('change', function() {
                const selectedValue = this.value;
                if (selectedValue === 'all') { window.location.href = '/'; }
                else { window.location.href = `/provinsi/${selectedValue}`; }
            });
        }

    });
</script>
</body>
</html>