<!DOCTYPE html>
<html>

<head>
    <title>Map Kecamatan</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <h1>Map Kecamatan</h1>
    <div id="map" style="height: 600px;"></div>

    <script>
        // Inisialisasi Peta
        var map = L.map('map').setView([-6.2, 106.8], 10); // Jakarta

        // Tambahkan Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        // Tambahkan GeoJSON
        $.getJSON("/indonesia-prov.geojson", function(data) {
            L.geoJSON(data, {
                style: function(feature) {
                    return {
                        color: "#0077b6",
                        weight: 2
                    };
                },
                onEachFeature: function(feature, layer) {
                    console.log(feature)
                    layer.bindPopup("Kecamatan: " + feature.properties.name);
                }
            }).addTo(map);
        });
    </script>
</body>

</html>