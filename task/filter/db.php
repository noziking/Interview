<?php $conn = new mysqli("localhost", "root","","searchpro" );
	
	 if ($conn->connect_error){
	 die("connection failed: " . $conn->connect_error);  
	 }
	// error_reporting(1);
	 ?>