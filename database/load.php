<?php
/*
 * Author:
 * File: 
 * Last update:
 * Todo:
 * 
 * 
 */
 
require_once("dbcontroller.php");
$db_handle = new DBController();


$sql = "SELECT * from poi";
$poi = $db_handle->runSelectQuery($sql);

$fd = fopen("log.txt","w");
fwrite($fd,json_encode($poi));
fclose($fd);

 echo json_encode($poi);
 
// TODO Check for error

	
