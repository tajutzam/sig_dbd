<?= $this->include('templates/header_user.php'); ?>
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
        right: 0;
        z-index: 9999;
        padding: 10px 20px;
    }

    #map-container {
        position: relative;
        width: 100%;
        /* Make the container responsive */
        height: 500px;
        /* Set fixed height for better appearance */
    }

    #map {
        width: 100%;
        /* Ensure the map takes full width of its container */
        height: 100%;
        /* Ensure the map takes full height of its container */
    }
</style>
<main class="container">
    <div class="card mb-2">
        <div class="card-body">
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
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex gap-2">
                <div id="map-container">
                    <div class="overlay" style="bottom: 0px; height: 200px;">
                        <div>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <div class="box" style="height: 30px; width:30px; background-color: red;"></div>
                                <h5 style="font-weight: bold;" class="text-black">= Tinggi</h5>
                            </div>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <div class="box" style="height: 30px; width:30px; background-color: orange;"></div>
                                <h5 style="font-weight: bold;" class="text-black">= Sedang</h5>
                            </div>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <div class="box" style="height: 30px; width:30px; background-color: yellow;"></div>
                                <h5 style="font-weight: bold;" class="text-black">= Rendah</h5>
                            </div>
                        </div>
                    </div>
                    <div id="map"></div>
                </div>
                <div style="height: 600px;" class="overflow-scroll">
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
                                    <!--
                                        <small>
                                            Jumlah Kasus: <?= $dataKasus['jumlah_kasus'] ?><br>
                                            Jumlah Kematian: <?= $dataKasus['jumlah_kematian'] ?><br>
                                            Rumah Diperiksa: <?= $dataKasus['jumlah_rumah_diperiksa'] ?><br>
                                            Rumah Bebas Jentik: <?= $dataKasus['jumlah_rumah_bebas_jentik'] ?>
                                        </small>
                                    -->
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
</main>

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
        var dataKecamatan = kasusData.find(item => item.nama_kecamatan === district);

        return {
            fillColor: dataKecamatan ? dataKecamatan.warna_risiko : "gray", // Gunakan warna dari PHP, default ke abu-abu jika tidak ditemukan
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

    console.log(kasusData);

    var geojsonLayers = {};


    // Fungsi untuk memuat dan menambahkan data GeoJSON ke peta dengan gaya tertentu
    function addGeoJSONLayer(url, kecamatan) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                var geojsonLayer = L.geoJSON(data, {
                    style: style,
                    onEachFeature: function(feature, layer) {
                        var dataKecamatan = kasusData.find(item => item.nama_kecamatan === kecamatan);

                        if (dataKecamatan != undefined) {
                            if (feature.properties) {
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
                                    // document.getElementById('ir').textContent = 'IR = ' + dataKecamatan.IR.toFixed(2);
                                    // document.getElementById('abj').textContent = 'ABJ = ' + dataKecamatan.ABJ.toFixed(2) * 100 + "%";
                                    // document.getElementById('cfr').textContent = 'CFR = ' + dataKecamatan.CFR.toFixed(2);
                                });
                            }
                        }
                    }
                }).addTo(map);

                // Simpan layer ke dalam objek geojsonLayers
                geojsonLayers[kecamatan] = geojsonLayer;

                map.fitBounds(geojsonLayer.getBounds());
                updateKecamatanList();
            })
            .catch(error => console.error("Error loading GeoJSON file:", error));
    }


    // Fungsi untuk memperbarui daftar kecamatan dengan warna yang sesuai
    function updateKecamatanList() {
        kasusData.forEach(item => {
            var colorBox = document.getElementById("color-box-" + item.nama_kecamatan);
            if (colorBox) {
                colorBox.style.backgroundColor = item.warna_risiko;
            }
        });
    }

    // Menambahkan Marker untuk Puskesmas
    function addPuskesmasMarkers() {
        var puskesmasIcon = L.icon({
            iconUrl: "<?= base_url('/map/images/marker-icon.png'); ?>", // Pastikan ini menghasilkan URL yang benar
            iconSize: [32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
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
                <strong>Jumlah Kematian:</strong> ${item.jumlah_kematian}<br>
                <strong>IR:</strong> ${item.IR.toFixed(2)}<br>
                <strong>CFR:</strong> ${item.CFR.toFixed(2)} %<br>
                <strong>ABJ:</strong> ${item.ABJ.toFixed(2)}% <br>
                
            `);

                // Menambahkan event listener untuk klik pada marker
                marker.on('click', function() {
                    // Memperbarui nilai IR, CFR, dan ABJ di elemen HTML
                    // document.getElementById('ir').textContent = 'IR = ' + item.IR.toFixed(2);
                    // document.getElementById('abj').textContent = 'ABJ = ' + (item.ABJ * 100).toFixed(2) + "%";
                    // document.getElementById('cfr').textContent = 'CFR = ' + item.CFR.toFixed(2);

                    // Mengubah warna overlay kecamatan yang terkait
                    var kecamatan = item.nama_kecamatan;
                    var geojsonLayer = geojsonLayers[kecamatan];


                    console.log(item.warna_risiko)

                    if (geojsonLayer) {
                        geojsonLayer.setStyle({
                            fillColor: item.warna_risiko, // Gunakan warna_risiko dari data puskesmas
                            weight: 2,
                            opacity: 1,
                            color: "white",
                            fillOpacity: 0.7
                        });
                    }
                });
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
<?= $this->include('templates/footer_user.php'); ?>