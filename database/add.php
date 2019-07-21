<?php

/*    
 * Author: Luigi Grillo
 * File:  add.php
 * Last update: 10/07/2019
 * Todo:
 *     1. Check for authorization and paramenters
 * 
 * DESCRIPTION: 
 *        Add new post to a marker. If the marker does not exists a new one will be saved on the database
 *               { "name": "widget name",
 *                 "html": "widget definition to be loaded from form.json"
 *               }
 * 
 */ 
 
require_once("dbcontroller.php");
$db_handle = new DBController();

   // TODO check authorization - check parameters

   /*
		 * If the POI (lat,lng) does not exist it creates a new one.
		 * Return the POI's id
		 * TODO: to implement a function around() to accept a delta difference of the coordinates
		 
		function getPOIid($lat,$lng) {

			
			
			return $result;
		}
   */

   $lat = $_GET["lat"];
   $lng = $_GET["lng"];
   $data = $_GET["data"];
   $description = $_GET["description"];
   $widget = $_GET["widget"];
   
   $db_handle->log("add.php","PARAMETERS GET = lat: $lat lng:$lng data:$data widget:$widget  decription:$description\n");
   
   // check the marker, or create a new one if it does not exists
   $sql = "select id from poi where lat=".$lat." and lng=".$lng;	
   $idPOI = $db_handle->runSelectQuery($sql); 
	if (!$idPOI) {    // The POI does not exists
		$idPOI = $db_handle->insertPOI($lat,$lng,$description);
	} else {
	
	      // TODO The POI exists already
   }
   
   $sql = 'select id from widgets where name="'.$widget.'"';
   $idWidget = $db_handle->runSelectQuery($sql);    // TODO CHECK result
   
   $db_handle->insertPOST($idPOI,$idWidget[0],$data);
   
   // TODO check query result 

    
    echo $poi;
	
 
