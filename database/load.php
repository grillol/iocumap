<?php
/*
 * Author:
 * File: 
 * Last update:
 * Todo:
 *  check authorizaation
 * 
 */
 
require_once("dbcontroller.php");
$db_handle = new DBController();


$sql = "SELECT * from poi";
$poi = $db_handle->runSelectQuery($sql);

if ($poi) {
  echo json_encode($poi);
}
 
// TODO Check for error

	
