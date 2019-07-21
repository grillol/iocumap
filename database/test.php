<?php





	
   $lat = $_GET["lat"];
   $lng = $_GET["lng"];
   $data = $_GET["data"];
   $description = $_GET["description"];
   $widget = $_GET["widget"];
   

     $conn = "";
	 $host = "89.46.111.49";
	 $user = "Sql1127014";
	 $dbname = "Sql1127014_5";
	 $password = "827r224040";
	 
	// Create connection
	$conn = new mysqli($host, $user, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	 $sql = 'INSERT INTO  poi (id ,lat,lng,description,dataRegistration,userID)
				 VALUES (NULL ,  '.$lat.',  '.$lng.',"'.mysqli_real_escape_string($conn,$description).'", CURRENT_TIMESTAMP , NULL);';	

	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
   
  
	
	
?>
