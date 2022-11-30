<?php include('ajaxDataMap.php') ?>
<!DOCTYPE html>
<html>
     <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Data on map</title>
          <link rel="stylesheet" type="text/css" href="../style1.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     </head>
<body onload="addOptions()">

<ul class="topnav">
    <li><a href="../index.php?logout='1'" style="color: red;">Logout</a></li>
    <li><a href="home.php" style="color: white;">Επιστροφή στην αρχική</a></li>
</ul>

<br><br><br><br><br><br>
<div class="round">
     <form method="POST" action="ajaxDataMap.php" id="formID">
          <label>Επέλεξε έτος:</label> <br> <br>
          <label>Από:</label>
          <input  name ="FromYear" id ="FromYear" type="number" min="2010" max="2020">
          <label>Έως:</label>
          <input  name ="ToYear" id ="ToYear" type="number" min="2010" max="2020" title = "Επέλεξε το ίδιο έτος αν ψάχνεις για ένα συγκεκριμένο έτος πχ. Από: 2013 Εώς: 2013" required > <br>
           <br> <br>

          <label> Επέλεξε Μήνα:</label> <br> <br>
          <label> Από:</label>
          <select name="FromMonth" id="FromMonth">
               <option disabled selected value> -- select an option -- </option>
               <option value="01">Ιανουάριος</option>
               <option value="02">Φεβρουάριος</option>
               <option value="03">Μάρτιος</option>
               <option value="04">Απρίλιος</option>
               <option value="05">ΜάΪος</option>
               <option value="06">Ιούνιος</option>
               <option value="07">Ιούλιος</option>
               <option value="08">Αύγουστος</option>
               <option value="09">Σεπτέμβριος</option>
               <option value="10">Οκτώβριος</option>
               <option value="11">Νοέμβριος</option>
               <option value="12">Δεκέμβριος</option>
          </select>
          <label> Εώς:</label> 
          <select name="ToMonth" id="ToMonth" title = "Επέλεξε τον ίδιο μήνα αν ψάχνεις για ένα συγκεκριμένο μήνα πχ. Από: Απρίλιος Εώς: Απρίλιος" required>
               <option disabled selected value> -- select an option -- </option>
               <option value="1">Ιανουάριος</option>
               <option value="2">Φεβρουάριος</option>
               <option value="3">Μάρτιος</option>
               <option value="4">Απρίλιος</option>
               <option value="5">ΜάΪος</option>
               <option value="6">Ιούνιος</option>
               <option value="7">Ιούλιος</option>
               <option value="8">Αύγουστος</option>
               <option value="9">Σεπτέμβριος</option>
               <option value="10">Οκτώβριος</option>
               <option value="11">Νοέμβριος</option>
               <option value="12">Δεκέμβριος</option>
          </select> <br>
          <br> <br>

          <label> Επέλεξε ημέρα/ες της εβδομάδας:</label> <br> <br>
          <select name="Days[]" id="Days" multiple  required>
               <option value="Monday">Δευτέρα</option>
               <option value="Tuesday">Τρίτη</option>
               <option value="Wednesday">Τετάρτη</option>
               <option value="Thursday">Πέμπτη</option>
               <option value="Friday">Παρασκευή</option>
               <option value="Saturday">Σάββατο</option>
               <option value="Sunday">Κυριακή</option> 
          </select> <br>
          <br> <br>

          <label> Επέλεξε Ώρα:</label> <br> <br>
          <label> Από:</label>
          <input  name ="FromTime" id ="FromTime" type="time">
          <label> Εώς:</label> 
          <input  name ="ToTime" id ="ToTime" type="time" title = "Επέλεξε την ίδια ώρα αν ψάχνεις για συγκεκριμένη ώρα πχ. Από: 12:10 Εώς: 12:10" required> <br>
          <br> <br>

          <label> Επέλεξε δραστηριότητα: </label> <br> <br>
          <select name="Activities[]" id="mySelect" multiple required>
          </select> <br>
          <label>* Πάτα Ctrl key (σε Windows και linux) and Command key (σε Mac) για πολλαπλή επιλογή.</label> <br>
          <button class="button" type="submit" class="btn" name="SelectCriteria_btn" id="btnID">Υποβολή κριτηρίων απεικόνισης στοιχείων</button>
     </form>
</div>

<script>

     var dataA;
     function dataA(){
     var ajax = new XMLHttpRequest();
     ajax.open("POST", "chartData/ajaxDataForCharta.php",true);
     ajax.send();
     
     ajax.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200)
     {
     dataA = JSON.parse(this.responseText);
     console.log(dataA);
     }};
     }

     dataA();
     
     function addOptions() {
          var x = document.getElementById("mySelect");
          for(i = 0; i < dataA.length; i++){
               var option = document.createElement("option");
               option.text = dataA[i][0];
               x.add(option);
          }
     }
     

</script>
</body>
</html>