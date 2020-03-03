
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Add multiple geometries from one GeoJSON source</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.css' rel='stylesheet' />
    <style>
        body { margin:0; padding:0; }
        #map { position:absolute; top:0; bottom:0; width:100%; }
    </style>
</head>
<body>

<div id="map"></div>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoiYmx1ZWdlYXJzdWUiLCJhIjoiY2praW5rOXR2MDJiNzNxbXVseWkwZHhwciJ9.kKJIS2GWV6hB0bwK_mBEXg';
var map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/bluegearsue/cjo8srrrt18q62rpf402dbgrv",
    center: [-70.627,  41.389],
                zoom: 11
});

map.on("load", function() {
    map.addSource('town', {
    type: 'geojson',
    data: '/js/data/oakbluffs.json'
}); 

 map.addLayer({
        "id": "town-layer",
        "type": "fill",
        "source": "town",
       "paint": {
"fill-color":  ['get', 'color'],
"fill-opacity": 0.4
},
"filter": ["==", "$type", "Polygon"]
	});
	

map.on('click', 'town-layer', function (e) {

new mapboxgl.Popup()
.setLngLat(e.lngLat)
.setHTML(e.features[0].properties.info)
.addTo(map);
});


    });



    

</script>

</body>
</html>