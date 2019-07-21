<?php


/*
 * Author: Luigi Grillo
 * File:  dbcontroller.php
 * Last update: 10/07/2019
 * Todo:
 *     1. logs actions end errors
 *     2. acquire USER information to log actions
 *     3. Verify  mysqli_free_result($result); and mysqli_close($link);
 * DESCRIPTION: 
 *        
 * 
 */ 


class DBController {
	private $conn = "";
	private $host = "89.46.111.49";
	private $user = "Sql1127014";
	private $password = "827r224040";
	private $database = "Sql1127014_5";

	function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->conn = $conn;			
		}
	}

	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		if (mysqli_connect_errno()) {
			$this->log("dbcontroller.php->connectDB","Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		return $conn;
	}

	function runSelectQuery($query) {
		$this->log("dbcontroller.php->runSelectQuery","runSelectQuery ".$query);
		$result = mysqli_query($this->conn,$query);
		$resultset = array();       // In order to return an array even in case of no data
		if ($result) {
			while($row=mysqli_fetch_assoc($result)) {
				$resultset[] = $row;
			}
		}
		
		$this->log("dbcontroller.php->runSelectQuery"," \n runSelectQuery result $resultset\n");
		return $resultset;		
		
	}
	
	function executeInsert($query) {
		$this->log("dbcontroller.php","executeInsert ".$query);

			$result = mysqli_query($this->conn,$query);
		
        $insert_id = mysqli_insert_id($this->conn);
        $this->log("dbcontroller.php","executeInsert DONE - insertID: ".$insert_id); 

		return $insert_id;
		
    }
	function executeUpdate($query) {
        $result = mysqli_query($this->conn,$query);
        return $result;
		
    }
	
	function executeQuery($sql) {
		$this->log("dbcontroller.php","executeQuery ".$query);
		$result = mysqli_query($this->conn,$sql);
		return $result;
		
    }

	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;
	}
	
	function stringEscape($s) {
		return mysqli_real_escape_string($this->conn,$s);
	}
	
	function insertPOI($lat,$lng,$description){
		$this->log("insertPOI","$lat,$lng,stringEscape($description)");
		
		$sql = 'INSERT INTO  poi (id ,lat,lng,description,dataRegistration,userID)
				 VALUES (NULL ,  '.$lat.',  '.$lng.',"'.$this->stringEscape($description).'", CURRENT_TIMESTAMP , NULL);';	   
		return $this->executeInsert($sql);
	}
	
	function insertPOST($idPOI,$idWidget,$data){
		$sql = 'INSERT INTO posts (id, id_poi, id_widget, data, dataRegistration, user) 
		        VALUES (NULL, '.$idPOI.', '.$idWidget.', "'.$this->stringEscape($data).'", CURRENT_TIMESTAMP, NULL)';
		$this->log("insertPOST","$idPOI,$idWidget,stringEscape($data)");
		return $this->executeInsert($sql);
	}
	
	function insertWIDGET(){
		
	}
	
	function log($p,$l) {
		
		// TODO implement a class log with functionalities: remote logs, logrotate, log analysis
		// TODO application home director parametrization
		
	  $fd = fopen($_SERVER['DOCUMENT_ROOT']."/maps/logs/log.txt","a");
	  fwrite($fd,date('Y-m-d H:i:s')." - FROM: $p - $l \n");
	  fclose($fd);
	  // TO DO check for log file open error
	}
	
}
?>
