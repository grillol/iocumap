<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

if(!empty($_POST["lng"])) {
	
	$sql = "INSERT INTO poi (lat,lng,description) VALUES ('" .$_POST["lat"] . "','" . $_POST["lng"] ."','" . $_POST["description"] . "')";
    $poi = $db_handle->executeInsert($sql);
    
    echo $poi;
	
}
