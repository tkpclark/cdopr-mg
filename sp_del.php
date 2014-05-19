<?php
	include("check.php"); 
	include("style.php");
	
	if(!isset($_GET['spid']))
	{
		exit;
	}
	$spid=$_GET['spid'];
	
	$sql="delete from mtrs_sp where ID=$spid";
	echo $sql;
	exsql($sql);
	
	Header("Location:sp_list.php");
	
?>