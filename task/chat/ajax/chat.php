<?php
require_once('../config.php');
$frnd_id=$_POST["Fid"];
$sql="SELECT * FROM user where id={$frnd_id} ";
$result=$conn->query($sql);
$row = $result->fetch_assoc();

$_SESSION['fname']=$row["username"];
$data=array();
$data["user_id"]=$row["id"];
$data["user_name"]=$row["username"];
die(json_encode($data));
	
?>