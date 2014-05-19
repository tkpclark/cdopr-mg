<?php
	include("check.php"); 
	include("style.php");
	
	if(!isset($_GET['serviceid']))
	{
		exit;
	}
	$serviceid=$_GET['serviceid'];
	
	$sql="delete from mtrs_service where ID=$serviceid";
	echo $sql;
	exsql($sql);
	
	Header("Location:service_list.php");
	
?>