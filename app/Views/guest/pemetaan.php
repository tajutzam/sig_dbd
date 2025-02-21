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
                                <div class="box" style="height: 30px; width:30px; background-color: yellow;"></div>
                                <h5 style="font-weight: bold;" class="text-black">= Sedang</h5>
                            </div>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <div class="box" style="height: 30px; width:30px; background-color: green;"></div>
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
                                <div style="height: 40px; width: 40px;" id="color-box-<?= $item['nama_kecamatan']; ?>"></div>
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
    var map = L.map('map').setView([-7.756928, 113.211502], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    function getRandomColor() {
        var letters = "0123456789ABCDEF";
        var color = "#";
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    var kasusData = <?= json_encode($kasus); ?>;
    var kecamatanData = <?= json_encode($kecamatan); ?>;

    var geojsonLayers = {};
    var districtColors = {};

    // Inisialisasi warna untuk setiap kecamatan
    kecamatanData.forEach(item => {
        districtColors[item.nama_kecamatan] = getRandomColor();
    });


    Object.keys(districtColors).forEach(district => {
        var colorBox = document.getElementById('color-box-' + district);
        if (colorBox) {
            colorBox.style.backgroundColor = districtColors[district];
            colorBox.style.border = `2px solid ${districtColors[district]}`;
        }
    });



    function style(feature) {
        var district = feature.properties.district;
        return {
            fillColor: "gray",
            weight: 2,
            opacity: 1,
            color: districtColors[district],
            fillOpacity: 0.7
        };
    }

    function addGeoJSONLayer(url, kecamatan) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                var geojsonLayer = L.geoJSON(data, {
                    style: style,
                    onEachFeature: function(feature, layer) {
                        var dataKecamatan = kasusData.find(item => item.nama_kecamatan === kecamatan);

                        if (dataKecamatan) {
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
                                highlightKecamatan(kecamatan, dataKecamatan.warna_risiko);
                            });
                        }
                    }
                }).addTo(map);

                geojsonLayers[kecamatan] = geojsonLayer;
            })
            .catch(error => console.error("Error loading GeoJSON file:", error));
    }

    // Menambahkan marker untuk setiap Puskesmas
    kasusData.forEach(data => {
        if (data.latitude_puskesmas && data.longitude_puskesmas) {
            var lat = parseFloat(data.latitude_puskesmas);
            var lng = parseFloat(data.longitude_puskesmas);

            var marker = L.marker([lat, lng]).addTo(map);

            var popupContent = `
            <strong>Kecamatan:</strong> ${data.nama_kecamatan}<br>
            <strong>Puskesmas:</strong> ${data.nama_puskesmas}<br>
            <strong>Jumlah Kasus:</strong> ${data.jumlah_kasus}<br>
            <strong>Jumlah Kematian:</strong> ${data.jumlah_kematian}<br>
            <strong>CFR:</strong> ${data.CFR.toFixed(2)}%<br>
            <strong>ABJ:</strong> ${(data.ABJ.toFixed(2))}%<br>
            <strong>IR:</strong> ${data.IR.toFixed(2)}<br>
        `;
            marker.bindPopup(popupContent);

            marker.on("click", function(e) {
                var kecamatan = data.nama_kecamatan;
                highlightKecamatan(kecamatan, data.warna_risiko);
            });
        }
    });


    function highlightKecamatan(kecamatan, warna) {
        resetKecamatanColors();
        if (geojsonLayers[kecamatan]) {
            geojsonLayers[kecamatan].eachLayer(function(layer) {
                layer.setStyle({
                    fillColor: warna,
                    weight: 3,
                    opacity: 1,
                    color: districtColors[kecamatan],
                    fillOpacity: 0.7
                });
            });
        }
    }

    function resetKecamatanColors() {
        Object.keys(geojsonLayers).forEach(kecamatan => {
            geojsonLayers[kecamatan].eachLayer(function(layer) {
                layer.setStyle({
                    fillColor: "gray",
                    weight: 2,
                    opacity: 1,
                    color: districtColors[kecamatan],
                    fillOpacity: 0.7
                });
            });
        });
    }

    <?php foreach ($kecamatan as $kec) : ?>
        addGeoJSONLayer("<?= base_url('/geojson/' . $kec['file_geojson']); ?>", "<?= $kec['nama_kecamatan']; ?>");
    <?php endforeach; ?>
</script>
<?= $this->include('templates/footer_user.php'); ?>