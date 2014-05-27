<?php
	require_once("check.php"); 
	//include("style.php");

	if(!isset($_GET['id']))
		exit;
	$id=$_GET['id'];
	
	$sql = "delete from  wraith_visit_limit where id='$id'";
	exsql($sql);
?>