<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">

    <style>
        .overlay {
            width: 200px;
            height: 30%;
            background-color: #D9D9D9;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            position: absolute;
            top: 0;
            right: 0;
            z-index: 9999;
            padding: 10px 20px;
        }


        #map-container {
            position: relative;
            width: 80%;
            height: 500px;
        }

        #map {
            width: 100%;
            height: 100%;
        }
    </style>

    <main>
        <div class="container-fluid px-4 mt-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <form method="get" class="mb-3">
                            <label for="tahun" class="form-label">Tampilkan Berdasarkan Tahun</label>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <select name="tahun" id="tahun" class="form-select mt-2" onchange="this.form.submit()">
                                        <?php foreach ($tahunall as $item) : ?>
                                            <option value="<?= $item['tahun']; ?>" <?= ($item['tahun'] == $tahun) ? 'selected' : ''; ?>>
                                                <?= $item['tahun']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Pemetaan</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <div id="map-container">
                            <div class="overlay">
                                <div>
                                    <h5 id="ir" class="text-dark font-weight-bold">IR = </h5>
                                    <h5 id="cfr" class="text-dark font-weight-bold">CFR = </h5>
                                    <h5 id="abj" class="text-dark font-weight-bold">ABJ = </h5>
                                </div>
                            </div>
                            <div id="map"></div>
                        </div>
                        <div>
                            <h6 class="ml-2 bg-primary px-3 py-2 text-white">Pembagian <?= sizeof($kecamatan); ?> Kecamatan</h6>
                            <ol id="kecamatan-list">
                                <?php foreach ($kecamatan as $item) : ?>
                                    <?php
                                    // Cari data kasus DBD yang sesuai dengan kecamatan ini
                                    $dataKasus = array_filter($kasus, function ($kasusItem) use ($item) {
                                        return $kasusItem['nama_kecamatan'] === $item['nama_kecamatan'];
                                    });
                                    $dataKasus = !empty($dataKasus) ? array_values($dataKasus)[0] : null;
                                    ?>
                                    <li id="kecamatan-<?= $item['nama_kecamatan'] ?>">
                                        <strong><?= $item['nama_kecamatan'] ?></strong><br>
                                        <?php if ($dataKasus) : ?>
                                            <small>
                                                Jumlah Kasus: <?= $dataKasus['jumlah_kasus'] ?><br>
                                                Jumlah Kematian: <?= $dataKasus['jumlah_kematian'] ?><br>
                                                Rumah Diperiksa: <?= $dataKasus['jumlah_rumah_diperiksa'] ?><br>
                                                Rumah Bebas Jentik: <?= $dataKasus['jumlah_rumah_bebas_jentik'] ?>
                                            </small>
                                        <?php else : ?>
                                            <small>Tidak ada data kasus DBD untuk kecamatan ini.</small>
                                        <?php endif; ?>
                                        <div style="height: 40px; width: 40px;" class="color-box" id="color-box-<?= $item['nama_kecamatan'] ?>"></div>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.0.0/leaflet.ajax.min.js"></script>

<script>
    var map = L.map('map').setView([-7.756928, 113.211502], 7); // Koordinat awal dengan zoom level 7

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Object untuk menyimpan warna untuk setiap kecamatan
    var districtColors = {};

    // Fungsi untuk memberikan warna acak untuk setiap GeoJSON feature
    function style(feature) {
        var district = feature.properties.district;
        if (!districtColors[district]) {
            districtColors[district] = getRandomColor();
        }
        return {
            fillColor: districtColors[district],
            weight: 2,
            opacity: 1,
            color: "white",
            fillOpacity: 0.7
        };
    }

    // Fungsi untuk menghasilkan warna acak dalam format hex
    function getRandomColor() {
        var letters = "0123456789ABCDEF";
        var color = "#";
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Data kasus DBD dari PHP
    var kasusData = <?= json_encode($kasus); ?>;

    // Fungsi untuk memuat dan menambahkan data GeoJSON ke peta dengan gaya tertentu
    function addGeoJSONLayer(url, kecamatan) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                var geojsonLayer = L.geoJSON(data, {
                    style: style,
                    onEachFeature: function(feature, layer) {
                        if (feature.properties) {
                            var dataKecamatan = kasusData.find(item => item.nama_kecamatan === kecamatan);

                            var popupContent = `
                            <strong>Kecamatan:</strong> ${kecamatan}<br>
                            <strong>Puskesmas:</strong> ${dataKecamatan.nama_puskesmas}<br>
                            <strong>Jumlah Kasus DBD:</strong> ${dataKecamatan.jumlah_kasus}<br>
                            <strong>Jumlah Kematian:</strong> ${dataKecamatan.jumlah_kematian}<br>
                            <strong>Jumlah Rumah Diperiksa:</strong> ${dataKecamatan.jumlah_rumah_diperiksa}<br>
                            <strong>Jumlah Rumah Bebas Jentik:</strong> ${dataKecamatan.jumlah_rumah_bebas_jentik}
                        `;

                            layer.bindPopup(popupContent);

                            layer.on("click", function() {
                                document.getElementById('ir').textContent = 'IR = ' + dataKecamatan.IR.toFixed(2);
                                document.getElementById('abj').textContent = 'ABJ = ' + dataKecamatan.ABJ.toFixed(2);
                                document.getElementById('cfr').textContent = 'CFR = ' + dataKecamatan.CFR.toFixed(2);
                            });
                        }
                    }
                }).addTo(map);

                map.fitBounds(geojsonLayer.getBounds());
                updateKecamatanList();
            })
            .catch(error => console.error("Error loading GeoJSON file:", error));
    }


    // Fungsi untuk memperbarui daftar kecamatan dengan warna yang sesuai
    function updateKecamatanList() {
        <?php foreach ($kecamatan as $item) : ?>
            var kecamatan = "<?= $item['nama_kecamatan'] ?>";
            var colorBox = document.getElementById("color-box-" + kecamatan);
            if (districtColors[kecamatan]) {
                colorBox.style.backgroundColor = districtColors[kecamatan];
            }
        <?php endforeach; ?>
    }

    // Menambahkan Marker untuk Puskesmas
    function addPuskesmasMarkers() {
        var puskesmasIcon = L.icon({
            iconUrl: "<?= base_url('/map/images/marker-icon.png'); ?>", // Pastikan ini menghasilkan URL yang benar
            iconSize: [32, 32], // Ukuran ikon
            iconAnchor: [16, 32], // Posisi titik anchor
            popupAnchor: [0, -32] // Posisi popup relatif terhadap ikon
        });



        kasusData.forEach(function(item) {
            if (item.latitude_puskesmas && item.longitude_puskesmas) {
                var marker = L.marker([parseFloat(item.latitude_puskesmas), parseFloat(item.longitude_puskesmas)], {
                        icon: puskesmasIcon
                    })
                    .addTo(map)
                    .bindPopup(`
                    <strong>Puskesmas:</strong> ${item.nama_puskesmas}<br>
                    <strong>Kecamatan:</strong> ${item.nama_kecamatan}<br>
                    <strong>Jumlah Kasus:</strong> ${item.jumlah_kasus}<br>
                    <strong>Jumlah Kematian:</strong> ${item.jumlah_kematian}
                `);
            }
        });
    }


    // Loop untuk menambahkan GeoJSON berdasarkan data kecamatan
    <?php foreach ($kecamatan as $kec) : ?>
        addGeoJSONLayer("<?= base_url('/geojson/' . $kec['file_geojson']); ?>", "<?= $kec['nama_kecamatan']; ?>");
    <?php endforeach; ?>
    // Tambahkan marker puskesmas setelah peta selesai dimuat
    addPuskesmasMarkers();
</script>

<?= $this->include('/templates/footer.php'); ?>