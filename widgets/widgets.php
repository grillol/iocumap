<?php
/*
 * Author: Luigi Grillo
 * File:  widget.php
 * Last update: 10/07/2019
 * Todo:
 *     1. Check for authorization
 *     2. Check for new widgets
 *     3. Inizialize the Session to optimize the process of retrieving the widgets list
 *     4. Optimize the flow: why to retrieve the widgets from the FS all the time we have onMapClick?
 *     5. To verify deleted widgets
 * 
 * DESCRIPTION FLOW:
 *    1. Syncronizes the widgets on the FS with the widgets reference on the database
 *    2. For each widget load the description
 *       Example:
 *        JSON widget description
 *               { "name": "widget name",
 *                 "html": "widget definition to be loaded from form.json"
 *               } 
 *    3. Perform the action
 *       a) list
 *       b) view
 * 
 */ 
   require_once("../database/dbcontroller.php");
   $db_handle = new DBController();

   $db_handle->log("widgets.php","Entato dentro widgets.php\n");


	 if ($_GET["action"]) {
		  $action = $_GET["action"];
		  
	 }
	   
  // 
     
     
  // Retrieves the list of widget available from the FS
	 $widgetList =  glob('*' , GLOB_ONLYDIR); 
	 
	 // Retrieves the list of widget available from the Database	 
	 $sql = 'select name from widgets';
	 $dbWidgets = $db_handle->runSelectQuery($sql) ;
	 // Extract colum 'name'
	 for ($i= 0; $i < count($dbWidgets) ; $i++) {
		 $dbWidgets[$i] = $dbWidgets[$i]["name"];
	 }
	// DEBUG  echo "<br>Widget nel DB"; print_r($dbWidgets);print "<br><br><br>";
	 
	 // Check FS & DB syncronization
	 $newWidgets = array_diff($widgetList,$dbWidgets);
	 $deletedWidgets = array_diff($dbWidgets,$widgetList);  
	
	/* 		 
	 if (count($dbWidgets)==0) {   // there are no widgets in the db yet. Load the list retrieved from the FS on the DB
		 echo "<br>DB VUOTO<br>";
		   $db_handle->log("widgets.php","there are no widgets in the db yet");
		   for ($i = 0; $i < count($widgetList); $i++) {
				 $sql = 'INSERT INTO widgets (id, name, registrationDate, user) VALUES (NULL, "'.$widgetList[$i].'", CURRENT_TIMESTAMP, "")';
				 $db_handle->executeInsert($sql);
			 }
	 } */
	 
	 
	 if (count($newWidgets)>0) {   // New widgets have to be loaded in to the DB
		// DEBUG  echo "<br>NEW WIDGETS:<br> ";print_r($newWidgets); print "<br><br><br>";
		  for ($i = 0; $i < count($newWidgets); $i++) {
				 $sql = 'INSERT INTO widgets (id, name, registrationDate, user) VALUES (NULL, "'.$newWidgets[$i].'", CURRENT_TIMESTAMP, "")';
				 $db_handle->executeInsert($sql);
		  }
	 }
	 
	 if (count($deletedWidgets)>0) {   // Widgets on the FS have been deleted
	// DEBUG 	 echo "<br>CANCELLATI WIDGETS<br>"; print_r($deletedWidgets);print("<br><br><br>");
           $sql = 'DROP from widgets where name in ('.implode(",",$deletedWidgets).')';
		$db_handle->executeQuery($sql);
     } 
     
	 // For each widget loads the form.json description from the FS (note. I refere to the widget list loaded from FS)
	 for ($i = 0; $i < count($widgetList); $i++) {	
		 // TODO. Check the correcteness of the widget
		 $widgetList[$i] =  json_decode(file_get_contents($widgetList[$i]."/form.json"));	
	 }       
  
  
  switch ($action) {
    case 'list':       
         echo json_encode($widgetList);
         break;
    case 'view':  // Load all the 
          
         break;
     default:
        
  }
  
  
