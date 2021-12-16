<div id="mapid" class="h-96"></div>

<script type="text/javascript">
    // init leaflet
    var map = L.map('mapid').setView(
            [{{ $latitude }}, {{ $longitude }}], {{ config('leaflet.zoom_level') }}
        );

    // add layer from OpenStreatMap
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // add marker
    // L.marker([36.180199, 1.527296]).addTo(map);

    var popup = L.popup();

    function onMapClick(e) {
        var latlng = e.latlng
        popup
            .setLatLng(latlng)
            .setContent("You clicked the map at " + latlng.toString())
            .openOn(map);
        L.marker([latlng.lat, latlng.lng]).addTo(map);
    }

    map.on('click', onMapClick);
</script>