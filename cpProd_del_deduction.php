<?php
	require_once("check.php"); 
	//include("style.php");

	if(!isset($_GET['id']))
		exit;
	$id=$_GET['id'];
	
	$sql = "delete from  mtrs_deduction where ID='$id'";
	exsql($sql);
?>