<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GisMap</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    
        <!-- Scripts -->
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="{{ asset('js/leaflet-search.js') }}"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin="" />
        <link rel="stylesheet" href="{{ asset('css/leaflet-search.css') }}" />

        <style>
		.search-input {
			font-family: Courier
		}

		.search-input,
		.leaflet-control-search {
			max-width: 400px;
		}
	    </style>


    </head>
    <body style="background-color:white;">
        <div style="margin:0; display:flex; justify-content:center; align-content:center;">
            <h2>GIS GEMPA BUMI</h2>
        </div>      
        <div style="display:flex; flex-direction:column;">
            <div id="map" style="align-self:center; background-color:white; width:80%; height:550px; border-width:1px; border-color:black; border-style:solid">

            </div>
        </div>
   
    </body>
</html>

<script>
        var rad;
        var searchMap;
        var markers;
        var markerIcon;
        var lat;
        var lang;
        var markersLayer = new L.featureGroup();
        var map;
        var circle=L.circle([0,0]);
        var popup = L.popup();  
        var root = '{{ url("/") }}';
        var apiRoot = root + '/api/feature';


        inisiasi();
        function inisiasi(){
            map = L.map('map').setView( [-3.00, 115.00], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18}).addTo(map);
            L.control.scale().addTo(map);

            searchMap = new L.Control.Search({
                url: 'http://nominatim.openstreetmap.org/search?format=json&q={s}',
                jsonpParam: 'json_callback',
                propertyName: 'display_name',
                propertyLoc: ['lat', 'lon'],
                // marker:L.circle([0,0], { radius: this.getRadius(),color:"red" }),
                marker:false,
                autoCollapse: true,
                autoType: false,
                minLength: 2,
                zoom: 6,
                }).on('search:expanded', function(){
                    //  ClearCircle();
                }).on('search:locationfound', function(latlng){
                    // getRadius();
                    onMapClick(latlng);
                })
            map.addControl(searchMap);
            map.on('click', onMapClick);
            loadGempa();
        }

          function onMapClick(e) {
            popup
            .setLatLng(e.latlng)
            .setContent("location: " + e.latlng.toString())
            .openOn(map);
            map.setView(e.latlng);
            // document.getElementById('locLattitude').value =e.latlng.lat;
            // document.getElementById('locLongitude').value =e.latlng.lng;
        }

        function getJSONGempa() {
            return $.getJSON(apiRoot + '/gempa');
        }


            function loadGempa(){
                markersLayer.clearLayers();
                getJSONGempa().then(function (responses){
                        $.each(responses, function (i, val) {
                            let lat = val.lat;
                            let lng = val.lng;
                            let kedalaman = val.Kedalaman;
                            let magnitude = val.Magnitude;
                            let audio_link = val.Audio_Link;
                            let video_link = val.Video_Link;
                            $.get("https://nominatim.openstreetmap.org/search?format=json&q="+lat+", "+lng
                            ,function(data, status){
                                console.log(data);
                                window.scroll(0, 0);
                                if(data[0]!=null){
                                    var marker = new L.Marker(new L.latLng([lat, lng]))
                                    .bindPopup('Nama Daerah :' + data[0].display_name+ '. gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                    'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                    '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                    '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                }
                                else{
                                    var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Nama Daerah : Tidak diketahui. '+ 'gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                    'dengan kekuatan gempa '+magnitude + ' SR');
                                }
                                markersLayer.addLayer(marker);
                                markersLayer.addTo(map);
                                marker.openPopup();
                        });
                    });     
                })
             
            }


    function lokasiGempa(lat=null, lng=null, kedalaman=null, magnitude=null, audio_link=null, video_link=null){
        if(lat!=null&&lng!=null){
            $.get("https://nominatim.openstreetmap.org/search?format=json&q="+lat+", "+lng
            ,function(data, status){
                console.log(data);
                window.scroll(0, 0);
                markersLayer.clearLayers();
                if(data[0]!=null){
                    var marker = new L.Marker(new L.latLng([lat, lng]))
                    .bindPopup('Nama Daerah :' + data[0].display_name+ '. gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                    'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                    '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                    '<iframe width="100%" height="345" src="'+video_link+'" allowfullscreen></iframe>');
                }
                else{
                    var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Nama Daerah : Tidak diketahui. '+ 'gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                    'dengan kekuatan gempa '+magnitude + ' SR');
                }
                markersLayer.addLayer(marker);
                markersLayer.addTo(map);
                marker.openPopup();
            });
        }
        else{
        $.get("https://nominatim.openstreetmap.org/search?format=json&q="+document.getElementById('search').value
            ,function(data, status){
                console.log(data);
                window.scroll(0, 0);
                markersLayer.clearLayers();
                var position = document.getElementById('search').value;
                var hasil = position.split(", ");
                if(data[0]!=null){
                    var marker = new L.Marker(new L.latLng([hasil[0], hasil[1]])).bindPopup('Nama Daerah :' + data[0].display_name + '. gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                    'dengan kekuatan gempa '+magnitude+ ' SR');
                }
                else{
                    var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Nama Daerah : Tidak diketahui. '+ 'gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                    'dengan kekuatan gempa '+magnitude+ ' SR');
                }
                
                markersLayer.addLayer(marker);
                markersLayer.addTo(map);
                marker.openPopup();
            });
        }
    }

</script>
