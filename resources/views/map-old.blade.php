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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.rawgit.com/hayeswise/Leaflet.PointInPolygon/v1.0.0/wise-leaflet-pip.js"></script>
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
        <div style="display:flex; flex-direction:row; align-content:center; justify-content:center; margin:10px">
            <div style="width:300px">
                <div class="form-row">
                    <div class="col-md-6">
                        <select class="form-control" id="opsi1" name="opsi1">
                            <option value="0">--Semua Pilihan--</option>
                            <option value="kedalaman">Kedalaman</option>
                            <option value="kekuatan">Kekuatan Gempa</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" id="opsi2" name="opsi2">
                            <option value="0">--Semua Angka--</option>
                            <option value="1">< 5</option>
                            <option value="2">> 5</option>
                            <option value="3">> 10</option>
                        </select>
                    </div>
                </div>
            </div>

            <button id="searchbtn" style="margin-left:10px" class="btn btn-primary">Search</button>
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
        var polygon;

        $('#searchbtn').click(function(){
            console.log('click');
            markersLayer.clearLayers();
            map.removeLayer(polygon);
            loadGempa($('#opsi1').val(),$('#opsi2').val());
        })


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
            // map.addControl(searchMap);
            map.on('click', onMapClick);
            // loadGempa();
            // var states = [{
            //     "type": "Feature",
            //     "properties": {"party": "Republican"},
            //     "geometry": {
            //         "type": "Polygon",
            //         "coordinates": [[
            //             [48.99,-104.05],
            //             [48.98,-97.22],   
            //             [45.94,-96.58],
            //             [45.94,-104.03],
            //             [48.99,-104.05]
            //         ]]
            //     }
            // }];
            
            // polygon = L.polygon(states[0].geometry.coordinates).addTo(map);
            var dataJabar = [];
            var dataSurakarta = [];

            // $.getJSON('other/jawa_barat.json').then(function (responses){
            //     //  console.log(responses);
            //             $.each(responses.geometries[0].coordinates, function (i, val) {
            //                 $.each(val[i], function (i, val){
            //                     dataJabar.push([val[1],val[0]]);
            //                 })
            //             })
            //  }).then(()=>{
            //     polygon = L.polygon(dataJabar).addTo(map);
            //     loadGempaInside();
            //  });

             $.getJSON('other/surakarta.json').then(function (responses){
                //  console.log(responses);
                        $.each(responses.geometries[0].coordinates, function (i, val) {
                            $.each(val[i], function (i, val){
                                dataSurakarta.push([val[1],val[0]]);
                            })
                        })
             }).then(()=>{
                // console.log(data);
                polygonSurakarta = L.polygon(dataSurakarta).addTo(map);
                map.fitBounds(polygonSurakarta.getBounds());
                map.dragging.disable();
                map.touchZoom.disable();
                map.doubleClickZoom.disable();
                map.scrollWheelZoom.disable();

                                // loadGempa();
                loadSurakarta();
             });
         
          
                // var m1 = L.marker([51.515, -0.07]); // Outside and north of polygon
                // markersLayer.addLayer(m1);
                // var m2 = L.marker([51.506, -0.06]); // In polygon, not on border
                // markersLayer.addLayer(m2);
                // var m3 = L.marker([51.506232, -0.070295]); // Inside polygon boundary box but outside of polygon. 
                // markersLayer.addLayer(m3);
                // var m4 = L.marker([51.51, -0.067]); // On polygon border.
                // markersLayer.addLayer(m4);

                // console.log(polygon.contains(m1.getLatLng()));
                // // ==> false
                // console.log(polygon.contains(m2.getLatLng()));
                // // ==> true
                // console.log(polygon.contains(m3.getLatLng()));
                // // ==> false
                // console.log(polygon.contains(m4.getLatLng()));
                // // ==> true
        }

        function loadSurakarta(){
            $("#map").append("<div style='background-color:blue;width:200px;'></div>");

        }

        function onMapClick(e) {
              if(polygon.contains(e.latlng)){
                popup
                .setLatLng(e.latlng)
                .setContent("location: " + e.latlng.toString()+ ", jawa barat")
                .openOn(map);
                map.setView(e.latlng);
              }
              else{
                popup
                .setLatLng(e.latlng)
                .setContent("location: " + e.latlng.toString())
                .openOn(map);
                map.setView(e.latlng);
              }
            // document.getElementById('locLattitude').value =e.latlng.lat;
            // document.getElementById('locLongitude').value =e.latlng.lng;
        }

        function getJSONGempa() {
            return $.getJSON(apiRoot + '/gempa');
        }

        function loadGempaInside(){
            getJSONGempa().then(function (responses){
                        $.each(responses, function (i, val) {
                            let lat = val.lat;
                            let lng = val.lng;
                            let kedalaman = val.Kedalaman;
                            let magnitude = val.Magnitude;
                            let audio_link = val.Audio_Link;
                            let video_link = val.Video_Link;
                            // var mark = L.marker([lat, lng]);
                            // console.log(mark.getLatLng());
                            if(polygon.contains({'lat':lat,'lng':lng})){
                                var marker = new L.Marker(new L.latLng([lat,  lng]), {icon: redIcon}).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                    markersLayer.addLayer(marker);
                            }
                            else{
                                var marker = new L.Marker(new L.latLng([lat,  lng])).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                    markersLayer.addLayer(marker);
                            }

                        })
                        markersLayer.addTo(map);
                })
        }

        var redIcon = new L.Icon({
                            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                            });


            function loadGempa(opsi1=0, opsi2=0){
                console.log(opsi1+" "+opsi2);
                markersLayer.clearLayers();
                getJSONGempa().then(function (responses){
                        $.each(responses, function (i, val) {
                            let lat = val.lat;
                            let lng = val.lng;
                            let kedalaman = val.Kedalaman;
                            let magnitude = val.Magnitude;
                            let audio_link = val.Audio_Link;
                            let video_link = val.Video_Link;
                            if(opsi1!=0 && opsi2!=0){
                                if(opsi1=="kedalaman"){
                                    if(opsi2==1){
                                        if(kedalaman<5){
                                            var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                        markersLayer.addLayer(marker);
                                        }
                                    }
                                    else if(opsi2==2){
                                        if(kedalaman>5){
                                            var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                        markersLayer.addLayer(marker);
                                        }
                                    }
                                    else if(opsi2==3){
                                        if(kedalaman>10){
                                            var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                        markersLayer.addLayer(marker);
                                        }
                                    }
                                }
                                else if(opsi1=="kekuatan"){
                                    if(opsi2==1){
                                        if(magnitude<5){
                                            var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                        markersLayer.addLayer(marker);
                                        }
                                    }
                                    else if(opsi2==2){
                                        if(magnitude>5){
                                            var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                        markersLayer.addLayer(marker);
                                        }
                                    }
                                    else if(opsi2==3){
                                        if(magnitude>10){
                                            var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                        markersLayer.addLayer(marker);
                                        }
                                    }
                                }
                            }
                            else{
                                var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                                                'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                                                '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                                                    markersLayer.addLayer(marker);
                            }
                            markersLayer.addTo(map);
                    
                    });     
                })

                    //    $.ajax({
                    //                         url: 'https://nominatim.openstreetmap.org/search?format=json&q='+lat+", "+lng,
                    //                         type: 'GET',
                    //                         success: function(data){ 
                    //                             if(data[0]!=null){
                    //                             var marker = new L.Marker(new L.latLng([lat, lng]))
                    //                             .bindPopup('Nama Daerah :' + data[0].display_name+ '. gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                    //                             'dengan kekuatan gempa '+magnitude+ ' SR.\n'+
                    //                             '<audio controls><source src="'+audio_link+'" type="audio/mpeg"></audio>'+
                    //                             '<iframe width="100%" height="175" src="'+video_link+'" allowfullscreen></iframe>');
                    //                             }
                    //                             else{
                    //                                 var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Nama Daerah : Tidak diketahui. '+ 'gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                    //                                 'dengan kekuatan gempa '+magnitude + ' SR');
                    //                             }
                    //                             markersLayer.addLayer(marker);
                    //                         },
                    //                         error: function(xhr, status, error) {
                    //                             var marker = new L.Marker(new L.latLng([lat, lng])).bindPopup('Titik gempa (latitude:'+lat+', longitude:'+lng+').gempa terjadi di kedalaman '+kedalaman+' kilometer dan '+
                    //                                 'dengan kekuatan gempa '+magnitude + ' SR');
                    //                                 markersLayer.addLayer(marker);
                    //                         }
                    //                     });
             
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
