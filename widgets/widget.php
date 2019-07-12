
<?php
/*
 * Author: Luigi Grillo
 * File:  widget.php
 * Last update: 10/07/2019
 * Todo:
 * 
 * DESCRIPTION: 
 *        JSON widget description
 *               { "name": "widget name",
 *                 "html": "widget definition to be loaded from form.json"
 *               }
 * 
 */ 


  if ($_GET["action"]) {
	  $action = $_GET["action"];
	  
  }
  
  
  function widgetList($w) {
	  
  }
  
  
  switch ($action) {
    case 'list':
         // Retrieves the list of widget available
         $widgetList =  glob('*' , GLOB_ONLYDIR);
         
         // For each widget loads the form.json description
         // TODO. Check the correcteness of the widget 
         for ($i = 0; $i < count($widgetList); $i++) {		 
			 $widgetJson [ $widgetList[$i]] = file_get_contents($widgetList[$i]."/form.json");		 
			 $widgetList[$i] = $widgetJson;
		 }       
         echo json_encode($widgetList);
         break;
    case 'view':
        
         break;
     default:
        
  }
