<?php
	include("check.php"); 
	include("style.php");
	
	if(!isset($_GET['id']))
	{
		exit;
	}
	$id=$_GET['id'];
	
	$sql="update wraith_blklist set status='2',time=now() where id=$id";
	echo $sql;
	exsql($sql);
	
	Header("Location:blklist.php");
	
?>