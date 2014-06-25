<?php
	include("check.php"); 
	include("style.php");
	
$phone_number = isset($_REQUEST['phone_number'])?$_REQUEST['phone_number']:"";


	$sql = "insert into wraith_blklist (phone_number,time) values('$phone_number',now())";

	exsql($sql);

	Header("Location:blklist.php");
