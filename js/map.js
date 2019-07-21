/*
 * Author: Luigi Grillo
 * File: map.js
 * Last update:
 * Description: 
 *      Flow: 
 *           1. document.ready: load all the POI in the database
 *           2. onMapClick event on the map for new POI (point of interests)
 * Todo:
 *   1. parametrizzare tutti i PATH assoluti
 * 
 */


// Map parameters
var lat=37.588;
var lon=14.161;
var zoom=9;
var mymap = L.map('mapid').setView([lat, lon], zoom);

var widgets = new Object();  // the JSON description of all the widgets available retrieved from the server


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
				// alert("Loaded POI from  load.php " + data);
			  //   Mark all the geo point on the map
			      if (data) {
					    $(jQuery.parseJSON(data)).each(function() {  
							L.marker([ this.lat, this.lng ]).addTo(mymap).bindPopup(this.description).openPopup();
						});		  
				  } else ;
			}
		});
	
}

// Add a POI and save it on the server
function savePOI(lat,lng,form) {
	var s = JSON.stringify( $(form).serializeArray(), null, 4);
	// alert('TO SAVE: action="save"&lat='+lat+'&lng='+lng+'&widget='+form.elements["widget"].value+'&data='+s);
	$.ajax({
			url: "database/add.php",
			type: "GET",
			data:'action="save"&lat='+lat+'&lng='+lng+'&widget='+form.elements["widget"].value+'&data='+s,
			success: function(r){
			  // 
			  L.marker([lat, lng]).addTo(mymap).bindPopup(form.elements["widget"].value).openPopup();
			}
		});
}



function showWidget(w) {
	
	// Search widget w
	
	let widget = widgets.find(o => o.name === w);
	var i = 0;
	var trovato = false;
	while ( i < widgets.length && !trovato ) {
			if ( widgets[i].widget == w ) 
				trovato = true;
		    i = i + 1;
		} 
	i = i-1;
	// Parse the widget definition
	
	var j; 
	var def='<h4>Insert your data</h4>';
	def +='<table>';
	for (j=0; j < widgets[i].fields.length; j++) {
		def += "<tr>";
		if ( widgets[i].fields[j].type == "text" ) {
			def+= "<td>"+widgets[i].fields[j].name+':</td><td> <input type="'+widgets[i].fields[j].type+'" name="'+widgets[i].fields[j].name+'"></td>';
	    }
	    if ( widgets[i].fields[j].type == "separator" ) {
			def+= "<th>"+widgets[i].fields[j].name+"</th><th></th>";
		}
	    def += "</tr>";
	}
	$('#formFields').html(def);
				
}


/*
 * Given the object w of the all widgets it returns the list of widget names
 */
function getWidgetList() {
	    var widgetList = [];
		var i;
		for (i = 0; i <widgets.length;i++ ) {
			widgetList.push(widgets[i].widget);
		}     
        return widgetList;
}


/*
 * 
 */
 
function markPOI (e) {
	
	   var widgetsList = getWidgetList();
	   var html = '<br><br>\
					Select your widget \
					<form name="selectWidget"> \
					    <select name="widget" onChange="showWidget(selectWidget.widget.value)">\
					      <option value=""></option> ';
		var i;							  
		for (i = 0; i < widgetsList.length; i++) { 
			
		    html += '<option value="'+widgetsList[i]+'">'+widgetsList[i]+'</option>';
		};	
					
		html +=	'	</select> \
					  <br><br> \
					  <div id="formFields" style="width: 100%; height:150px; overflow-y: scroll;" ></div>	 <br> \
					  <input Type=Button Value="Save" onClick="savePOI(' + e.latlng.lat + ', ' + e.latlng.lng +  ', this.form );">\
					</form>';
		popup
			.setLatLng(e.latlng)
			.setContent("<div id=popup> You are visiting:  lat,Lon : " + e.latlng.lat + ", " + e.latlng.lng + "<br>" + html+"</div>")
			.openOn(mymap);	
			
}



/*
 * Perform actions when the click event is detected on the map
 */

var popup = L.popup();
function onMapClick(e) {		   
     $.ajax({
			url: "widgets/widgets.php",
			type: "GET",
			data:'action=list',
			success: function(data){
					     alert("Reply by widgets.php " + data);
					    try {
							 widgets = JSON.parse(data)
							 if (widgets && typeof widgets === "object") {
							    //  alert(JSON.stringify(widgets, null, 4));
								markPOI(e);
							 }
					   } catch (e) { alert("ERROR: " + e) }
			      
			     	
			}
		});	        	
}


// Capture the event Click on the map
mymap.on('click', onMapClick); 


// Plugin to implement searching functionality on the map
// TODO implement advanced search
var osmGeocoder = new L.Control.OSMGeocoder({placeholder: 'Search location...'});
mymap.addControl(osmGeocoder);
	
