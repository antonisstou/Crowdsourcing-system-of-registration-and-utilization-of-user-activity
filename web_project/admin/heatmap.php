<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" type="text/css" href="../style1.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
</head>
<body onload="data()">
<ul class="topnav">
    <li><a href="../index.php?logout='1'" style="color: red;">Logout</a></li>
    <li><a href="home.php" style="color: white;">Επιστροφή στην αρχική</a></li>
</ul>
<div id = "result"> </div>
<br><br><br><br>
<div id="mapid" class="center"></div>

<script>
var data;
function data(){
var ajax = new XMLHttpRequest();
ajax.open("POST", "data.php",true);
ajax.send();

ajax.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200)
{
 console.log(this.responseText);    
 data = JSON.parse(this.responseText);
 console.log(data);
}};
}

setTimeout(function(){heatmap()}, 1000);

var map = L.map('mapid',{drawControl: true}).setView([38.260110, 22.036360], 10);
	L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:  'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
	}).addTo(map);
function heatmap () {	
let testData = {
  max: 8,
  data: data
};
  
let cfg = {
  "radius": 40,
  "maxOpacity": 0.8,
  
  "scaleRadius": false,

  "useLocalExtrema": false,
  
  latField: 'latitudeE7',
  
  lngField: 'longitudeE7',
};

let heatmapLayer =  new HeatmapOverlay(cfg);
map.addLayer(heatmapLayer);
heatmapLayer.setData(testData);

 }
	
</script>
</body>
</html>