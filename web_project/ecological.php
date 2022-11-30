<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ecological Movement - Page</title>
     <link rel="stylesheet" type="text/css" href="style2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<ul class="topnav">
	<li><a href="index.php?logout='1'" style="color: red;">Logout</a></li>
	<li><a href="userPage.html" style="color: white;"> My Page </a><li>
	<li><a class="active" href="ecological.php" style="color: white;"> Οικολογική Μετακίνηση </a><li>
	<li><a href="heatmap_charts.html" style="color: white;"> Απεικόνιση σε χάρτη/γραφήματα </a><li>
</ul><br><br>

<ul class="fa-ul">
<li style="font-weight:bold;"><i class="fa fa-caret-right"></i> Το score οικολογικής μετακίνησης σου γι' αυτό τον μήνα είναι : <p id="percent" class="border" ></p> <p id="text" ></p> </li>
<br><br><br><br>
<li style="font-weight:bold;"><i class="fa fa-caret-right"></i> To score οικολογικής μετακίνησης σου για τους τελευταίους 12 μήνες  : </li> <div id="piechart"></div>
<p id="text"> ** Για τους μήνες που δεν φαίνονται στο γράφημα δεν υπάρχουν δεδομένα τοποθεσίας! </p>
<br><br><br><br>
</ul>
<ul class="fa-ul" style=" position: absolute; top: 100px; right: 500px;">
<li style="font-weight:bold;"><i class="fa fa-caret-right"></i> Κατάταξη χρηστών με την πιο οικολογική μετακίνηση : <p id="text1" ></p> </li>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<li style="font-weight:bold;"><i class="fa fa-caret-right"></i> Η περίοδος που καλύπτουν οι εγγραφές σου είναι : <p id="period" class="border" ></p></li> 
<br><br><br><br>
<li style="font-weight:bold;"><i class="fa fa-caret-right"></i> Ημερομηνία τελευταίου upload : <p id="upload" class="border" ></p></li> 
<br><br><br><br>
</ul>

<script src="https://www.gstatic.com/charts/loader.js"></script>

<script>
//ajax for current month
var x;
var ajax = new XMLHttpRequest();
ajax.open("POST", "ecologicalData.php",true);
ajax.send();
// receiving response
ajax.onreadystatechange = function(data) {
if (this.readyState == 4 && this.status == 200)
{   
   x = this.responseText;
   console.log(x);
   if ( x == "no")
   { document.getElementById("text").innerHTML = "** Δεν βρέθηκαν δεδομένα ιστορικού τοποθεσίας για τον τρέχων μήνα!"; 
    document.getElementById("percent").style.display = "none";   }
   else
   { document.getElementById("percent").innerHTML = x;
    document.getElementById("text").style.display = "none";   }  
}};

//ajax for last 12 months
var data;
var ajax = new XMLHttpRequest();
ajax.open("POST", "ecologicalData12Months.php",true);
ajax.send();
// receiving response
ajax.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200)
{
 receiveData = JSON.parse(this.responseText);
 console.log(receiveData);
}};


// Load google charts
google.charts.load('current', {packages: ['corechart']});
window.setTimeout(drawChart, 1000);
google.charts.setOnLoadCallback(drawChart);
// Draw the chart and set the chart values
    function drawChart() {
      
      var dataC = new google.visualization.DataTable();
      dataC.addColumn('string', 'Month');
      dataC.addColumn('number', 'Percentage');

	 for(i = 0; i < receiveData.length; i++)	  
	 { var month = receiveData[i]["month"].concat(receiveData[i]["year"]);
	   var percentage = receiveData[i]["percentage"];
	   console.log(month);
	   console.log(percentage);
	   dataC.addRow([ month, percentage ]); 
	   }
	 
    var options = {backgroundColor: "#B0E0E6" ,'width':550, 'height':400};
      // Instantiate and draw the chart.
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(dataC, options);
    }

//ajax for period of records
var data;
var ajax = new XMLHttpRequest();
ajax.open("POST", "PeriodOfRecords.php",true);
ajax.send();
// receiving response
ajax.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200)
{
 data = JSON.parse(this.responseText);
 console.log(data);
 document.getElementById("period").innerHTML = data["0"]["0"].concat("   -   ",data["1"]["0"]);
}};

//ajax for last upload
var data;
var ajax = new XMLHttpRequest();
ajax.open("POST", "lastUpload.php",true);
ajax.send();
// receiving response
ajax.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200)
{
 data = JSON.parse(this.responseText);
 console.log(data);
 document.getElementById("upload").innerHTML = data["0"]["0"];
}};

//ajax for leaderboard

var data1;
var ajax = new XMLHttpRequest();
ajax.open("POST", "leaderBoardData.php",true);
ajax.send();
// receiving response
ajax.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200)
{
 data1 = JSON.parse(this.responseText);
 console.log(data1);
}};

window.setTimeout(leader, 1000);
function leader()
{ 
if (data1.length != 0) {
var table = document.createElement("TABLE");
  table.setAttribute("id", "Activities");
  document.body.appendChild(table);

for(i = 2; i < data1.length; i++)
{  var name = data1[i][0].concat(" ",data1[i][1].charAt(0),".");
   var records = data1[i][2];
   var y = document.createElement("TR");
   var row = table.insertRow(y);
   var cell1 = row.insertCell(0);
   var t = document.createTextNode(name);
   cell1.appendChild(t);
   var cell2 = row.insertCell(1);
   var t = document.createTextNode(records);
   cell2.appendChild(t);
   }
var y = document.createElement("TR");
   var row = table.insertRow(y);
   var headerCell1 = document.createElement("TH");
   headerCell1.innerHTML = "Όνομα";
    row.appendChild(headerCell1);
	 var headerCell3 = document.createElement("TH");
   headerCell3.innerHTML = "Εγγραφές Οικολογικής Μετακίνησης";
    row.appendChild(headerCell3);
	}
else
{  document.getElementById("text1").innerHTML= "**Δεν βρέθηκαν χρήστες!"; }
}





</script>



</body>
</html>