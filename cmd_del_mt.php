<?php
	require_once("check.php"); 
	//include("style.php");

	if(!isset($_GET['id']))
		exit;
	$id=$_GET['id'];
	
	$sql = "delete from  mtrs_cmd_mt where id='$id'";
	exsql($sql);
?>