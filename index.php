<!DOCTYPE html>
<html>
	
<?php
/*
 * Author: Luigi Grillo
 * File:  index.php
 * Last update: 10/07/2019
 * Todo:
 * 
 * 
 */
 

   
?>
<head> 
	
	<title>iocuMap - luigigrillo.com</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />

	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
	
	<!--  Fontawesome -->
	<script src="https://kit.fontawesome.com/74c7a5d0b5.js"></script>
	
	<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
  
    <link rel="stylesheet" type="text/css" href="css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="stylesheet" href="http://www.luigigrillo.com/maps/libs/leaflet-control-osm-geocoder/Control.OSMGeocoder.css" />

    <script src="libs/leaflet-control-osm-geocoder/Control.OSMGeocoder.js"></script>


    <script>
		function openNav() {
		  document.getElementById("leftsidenav").style.width = "250px";
		  document.getElementById("openbtn").style.display="none";
		  document.getElementById("closebtn").style.display="block";
		}

		function closeNav() {
		  document.getElementById("leftsidenav").style.width = "0";
		  document.getElementById("closebtn").style.display="none";
		  document.getElementById("openbtn").style.display="block";
		}
	</script>

	
</head>


<body>
	<div id="header">
		<div id="openbtn"> <a href="javascript:void(0)"  onclick="openNav()"><i class="fa fa-bars fa-fw" aria-hidden="true"></i></a></div>
		<div  id="closebtn"> <a href="javascript:void(0)" onclick="closeNav()"><i class="fa fa-close fa-fw" aria-hidden="true"></i></a></div>
	</div>
	
	<div id="leftsidenav" class="sidenav">
			<button class="accordion">About</button>
				  <div class="panel"> about about</div>
			<button class="accordion">Settings</button>
				  <div class="panel">settings settings </div>
			<button class="accordion">Help</button>
				  <div class="panel"> help help </div>
			<button class="accordion">Contact</button>
				  <div class="panel">contact contact </div>
	</div>

	
		
	<div id="mapid"> </div>

	
	<div id="footer"> footer </div>


    <script src="js/map.js"></script>

	<script>
			var acc = document.getElementsByClassName("accordion");
			var i;

			for (i = 0; i < acc.length; i++) {
			  acc[i].addEventListener("click", function() {
				this.classList.toggle("active");
				var panel = this.nextElementSibling;
				if (panel.style.maxHeight){
				  panel.style.maxHeight = null;
				} else {
				  panel.style.maxHeight = panel.scrollHeight + "px";
				} 
			  });
			}
	</script>


</body>
</html>
