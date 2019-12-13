<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 

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
        <!-- <div style="display:flex; flex-direction:row; align-content:center; justify-content:center; margin:10px">
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
        </div> -->
        <div style="display:flex; flex-direction:row    ;">
            <div id="option-container" style="padding:20px;border-style: solid;border-width:1px;border-radius:5px;border-color:black;margin-right:20px;margin-left:20px;width:20%;height:600px;">
                <h4 style="text-decoration: underline;">Option Surakarta:</h4><br>
                <form>
                    <div class="checkbox">
                        <label><input id="Surakarta" type="checkbox" value="" checked disabled>Surakarta</label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="rawan_banjir" type="checkbox" value="" >Rawan Bajir </label>
                    </div>    
                    <div class="checkbox">
                        <label><input id="Kec_Jebres" type="checkbox" value="" checked>Kec Jebres</label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="Kec_Laweyan" type="checkbox" value="" checked>Kec Laweyan </label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="Kec_Banjarsari" type="checkbox" value="" checked>Kec Banjarsari </label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="Kec_Pasar" type="checkbox" value="" checked>Kec Pasar Kliwon</label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="Kec_Serengan" type="checkbox" value="" checked>Kec Serengan </label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="Jalan_Lokal" type="checkbox" value="" checked>Jalan Lokal </label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="Jalan_Kereta_Api" type="checkbox" value="" checked>Jalan Kereta_Api </label>
                    </div>        
                    <div class="checkbox">
                        <label><input id="Sungai" type="checkbox" value="" checked>Sungai</label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="Jalan_Arteri" type="checkbox" value="" checked>Jalan Arteri </label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="sekolahan" type="checkbox" value="" checked>sekolahan </label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input id="Kantor_Pemerintah" type="checkbox" value="" checked>Kantor Pemerintah </label>
                    </div>            
                    <div class="checkbox disabled">
                        <label><input id="Perguruan_Tinggi" type="checkbox" value="" checked>Perguruan Tinggi </label>
                    </div>   
        
                </form>
            </div>
            <div id="map" style="margin-right:10px;align-self:center; background-color:white; width:80%; height:600px; border-width:1px; border-color:black; border-style:solid">

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
        var surakarta;

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
            map.addControl(searchMap);
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
                polygonSurakarta = L.polygon(dataSurakarta);
                map.fitBounds(polygonSurakarta.getBounds());

                                // loadGempa();
                loadSurakarta(polygonSurakarta.getBounds());
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

        function loadSurakarta(bounds){
            console.log(bounds);
            map.createPane('imagebg');
            map.getPane('imagebg').style.zIndex = 650;
            
            Surakarta = new L.ImageOverlay('{{asset("surakarta/assets/Surakarta.svg")}}', bounds, {
                pane: 'imagebg'
            });
            rawan_banjir = new L.ImageOverlay('{{asset("surakarta/assets/Kec_Laweyan.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Kec_Jebres = new L.ImageOverlay('{{asset("surakarta/assets/Kec_Jebres.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Kec_Laweyan = new L.ImageOverlay('{{asset("surakarta/assets/Kec_Laweyan.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Kec_Banjarsari = new L.ImageOverlay('{{asset("surakarta/assets/Kec_Banjarsari.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Kec_Pasar_Kliwon = new L.ImageOverlay('{{asset("surakarta/assets/Kec_Pasar Kliwon.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Kec_Serengan = new L.ImageOverlay('{{asset("surakarta/assets/Kec_Serengan.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Jalan_Lokal = new L.ImageOverlay('{{asset("surakarta/assets/Jalan_Lokal.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Jalan_Kereta_Api = new L.ImageOverlay('{{asset("surakarta/assets/Jalan_Kereta_Api.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Sungai = new L.ImageOverlay('{{asset("surakarta/assets/Sungai.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Jalan_Arteri = new L.ImageOverlay('{{asset("surakarta/assets/Jalan_Arteri.svg")}}', bounds, {
                pane: 'imagebg'
            });
            sekolahan = new L.ImageOverlay('{{asset("surakarta/assets/Sekolahan.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Kantor_Pemerintah = new L.ImageOverlay('{{asset("surakarta/assets/Kantor_Pemerintah.svg")}}', bounds, {
                pane: 'imagebg'
            });
            Perguruan_Tinggi = new L.ImageOverlay('{{asset("surakarta/assets/Perguruan_Tinggi.svg")}}', bounds, {
                pane: 'imagebg'
            });
            map.addLayer(Surakarta);
            map.addLayer(Kec_Jebres);

            map.addLayer(Kec_Laweyan);
            map.addLayer(Kec_Banjarsari);
            map.addLayer(Kec_Pasar_Kliwon);
            map.addLayer(Kec_Serengan);
            map.addLayer(Jalan_Lokal);
            map.addLayer(Jalan_Kereta_Api);
            map.addLayer(Sungai);
            map.addLayer(Jalan_Arteri);
            map.addLayer(sekolahan);
            map.addLayer(Kantor_Pemerintah);
            map.addLayer(Perguruan_Tinggi);
        }

        $(document).ready(function(){
    console.log($("#Kec_Jebres").val()? "checked" : "not");
    $("#Surakarta").click(function(){
        
        if($("#Surakarta").is(":checked")){
            map.addLayer(Surakarta);
        }
        else {
            map.removeLayer(Surakarta);
        }
    })
    $("#rawan_banjir").click(function(){
        
        if($("#rawan_banjir").is(":checked")){
            map.addLayer(rawan_banjir);
            marker = new L.Marker(new L.latLng([-7.548038, 110.787964]), {icon: messageIcon}).bindPopup('Banjir adalah peristiwa yang terjadi ketika aliran air yang berlebihan merendam daratan. Pengarahan banjir Uni Eropa mengartikan banjir sebagai perendaman sementara oleh air pada daratan yang biasanya tidak terendam air. Dalam arti "air mengalir", kata ini juga dapat berarti masuknya pasang laut.'+
                                                '<audio controls><source src="{{asset("audio/banjir.mp3")}}" type="audio/mpeg"></audio>'+
                                                '<iframe width="100%" height="175" src="https://www.youtube.com/embed/SCLNqhLTTo0" allowfullscreen></iframe>');
                                                    map.addLayer(marker);
        }
        else {
            map.removeLayer(rawan_banjir);
            map.removeLayer(marker);
        }
    })
    $("#Kec_Jebres").click(function(){
        
        if($("#Kec_Jebres").is(":checked")){
            map.addLayer(Kec_Jebres);
        }
        else {
            map.removeLayer(Kec_Jebres);
        }
    })

       $("#Kec_Laweyan").click(function(){
        
        if($("#Kec_Laweyan").is(":checked")){
            map.addLayer(Kec_Laweyan);
        }
        else {
            map.removeLayer(Kec_Laweyan);
        }
    })
    
    $("#Kec_Banjarsari").click(function(){
        
        if($("#Kec_Banjarsari").is(":checked")){
            map.addLayer(Kec_Banjarsari);
        }
        else {
            map.removeLayer(Kec_Banjarsari);
        }
    })

       $("#Kec_Pasar").click(function(){
        
        if($("#Kec_Pasar").is(":checked")){
            map.addLayer(Kec_Pasar_Kliwon);
        }
        else {
            map.removeLayer(Kec_Pasar_Kliwon);
        }
    })

       $("#Kec_Serengan").click(function(){
        
        if($("#Kec_Serengan").is(":checked")){
            map.addLayer(Kec_Serengan);
        }
        else {
            map.removeLayer(Kec_Serengan);
        }
    })

       $("#Jalan_Lokal").click(function(){
        
        if($("#Jalan_Lokal").is(":checked")){
            map.addLayer(Jalan_Lokal);
        }
        else {
            map.removeLayer(Jalan_Lokal);
        }
    })

       $("#Jalan_Kereta_Api").click(function(){
        
        if($("#Jalan_Kereta_Api").is(":checked")){
            map.addLayer(Jalan_Kereta_Api);
        }
        else {
            map.removeLayer(Jalan_Kereta_Api);
        }
    })

       $("#Sungai").click(function(){
        
        if($("#Sungai").is(":checked")){
            map.addLayer(Sungai);
        }
        else {
            map.removeLayer(Sungai);
        }
    })

       $("#Jalan_Arteri").click(function(){
        
        if($("#Jalan_Arteri").is(":checked")){
            map.addLayer(Jalan_Arteri);
        }
        else {
            map.removeLayer(Jalan_Arteri);
        }
    })

       $("#sekolahan").click(function(){
        
        if($("#sekolahan").is(":checked")){
            map.addLayer(sekolahan);
        }
        else {
            map.removeLayer(sekolahan);
        }
    })

       $("#Kantor_Pemerintah").click(function(){
        
        if($("#Kantor_Pemerintah").is(":checked")){
            map.addLayer(Kantor_Pemerintah);
        }
        else {
            map.removeLayer(Kantor_Pemerintah);
        }
    })

       $("#Perguruan_Tinggi").click(function(){
        
        if($("#Perguruan_Tinggi").is(":checked")){
            map.addLayer(Perguruan_Tinggi);
        }
        else {
            map.removeLayer(Perguruan_Tinggi);
        }
    })

})


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

        var messageIcon = new L.Icon({
                            iconUrl: '{{asset("surakarta/assets/message.png")}}',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                            });

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
