/*
 * Author:
 * File: 
 * Last update:
 * Todo:
 *   1. parametrizzare tutti i PATH assoluti
 * 
 */


// Map parameters
var lat=37.588;
var lon=14.161;
var zoom=9;
var mymap = L.map('mapid').setView([lat, lon], zoom);

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	maxZoom: 18,
	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	id: 'mapbox.streets'
}).addTo(mymap);

	
$(document).ready(function() {
	loadPOI();
});


// Retrieve all the POI from the sever
function loadPOI(lat,lng) {
	$.ajax({
			url: "database/load.php",
			type: "POST",
			data:'ref=',
			success: function(data){
			  //   Mark all the geo point on the map
			      $(jQuery.parseJSON(data)).each(function() {  
						L.marker([ this.lat, this.lng ]).addTo(mymap).bindPopup(this.description).openPopup();
					});		  
			}
		});
	
}

// Add a POI and save it on the server
function savePOI(lat,lng,widget) {
	
	$.ajax({
			url: "database/add.php",
			type: "POST",
			data:'lat='+lat+'&lng='+lng+'&description='+widget,
			success: function(data){
			  // 
			  L.marker([lat, lng]).addTo(mymap).bindPopup(widget).openPopup();
			}
		});
}


// Capture the event Click on the map

function showWidget(v) {
	 var input = document.createElement("input");
	input.type = "text";
	input.name = "test";
	input.value = v;
	formFields.appendChild(input);
				
}

function markPOI (widgets,e) {
	   var html = '<br><br>\
					Select your widget \
					<form name="selectWidget"> \
					    <select name="widget" onChange="showWidget(selectWidget.widget.value)">';
		var i;							  
		for (i = 0; i < widgets.length; i++) { 
			
		    html += '<option value="'+widgets[i]+'">'+widgets[i]+'</option>';
		};	
					
		html +=	'	</select> \
		  <br><br> \
		  <div id="formFields" ></div>	 <br> \
		  <input Type=Button Value="Save" onClick="savePOI(' + e.latlng.lat + ', ' + e.latlng.lng +  ', test.value );">\
		</form>';
		popup
			.setLatLng(e.latlng)
			.setContent("<div id=popup> You are visiting:  lat,Lon : " + e.latlng.lat + ", " + e.latlng.lng + "<br> Great! Isn't it??" + html+"</div>")
			.openOn(mymap);	
			
}




function getWidgetList(w) {
	    var widgetList = [];
		$.each(w, function(key, value) {
            widgetList.push(key);
        });
        
        return widgetList;
}


var popup = L.popup();
function onMapClick(e) {		   

  /* TODO 
     
     * 1. Retrieve the list of widget available 
     * 2. Retrieve the HTML code of the selected widget
     * 
      */
     
     $.ajax({
			url: "widgets/widget.php",
			type: "GET",
			data:'action=list',
			success: function(data){
				  alert(data);
			      markPOI(getWidgetList(JSON.parse(data)),e);
			     	
			}
		});
             
		        	
}
mymap.on('click', onMapClick); 


// Plugin to implement searching functionality on the map
// TO DO search image
var osmGeocoder = new L.Control.OSMGeocoder({placeholder: 'Search location...'});
mymap.addControl(osmGeocoder);
	



