<?php include('functions.php') ?>
<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<ul class="topnav">
    <li><a href="../index.php?logout='1'" style="color: red;">Logout</a></li>
    <li><a href="home.php" style="color: white;">Επιστροφή στην αρχική</a></li>
</ul>
<br><br><br>
<div id="mapid" class="center"></div>
<script>
     var map = L.map('mapid',{drawControl: true}).setView([38.246242, 21.7350847], 16);
	L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
          attribution:  'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
	}).addTo(map);
     var options = { position: 'topleft', drawPolyline: false, drawCircle: false, drawCircleMarker: false, drawMarker: false, cutPolygon: false, drawPolygon: false};
     map.pm.addControls(options);
   
     var arr = new Array();  
     map.on('pm:create', function(e) {
          var type = e.shape;
          var layer = e.layer;
          arr = layer.getLatLngs();
          for ( let item of arr)
               {console.log(item);
          }
     });


     map.on('pm:create', function(e) 
     {
          e.layer.on('pm:edit', ({ layer }) => {
          console.log(layer.getLatLngs());
          })
          e.layer.on('pm:remove', ({layer}) => {
          arr.splice(0, arr.length)
          console.log("remove" + " " + e.shape ); 
          });
     });




</script>

        
     <script>
        function myFunction() {
          document.getElementById("custId").value = JSON.stringify(arr);
        }
     </script>
     
<div style="text-align:center">

<h3>Εδώ μπορείς να ανεβάσεις τα δεδομένα σου στην βάση του συστήματος</h3>
<form method="post" action="home.php" enctype="multipart/form-data">
	<label>Επέλεξε ένα αρχείο:</label>
     <input type="file" name="filename" accept=".json">
     <input type="hidden" id="custId" name="custId" value="">
	<input type="submit" value="Upload file" name="submit"  class="button"onclick="myFunction()";>
</form>     
</div>
</body>
</html>