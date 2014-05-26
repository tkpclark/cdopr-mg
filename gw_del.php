<?php
	include("check.php"); 
	include("style.php");
	
	if(!isset($_GET['id']))
	{
		exit;
	}
	$id=$_GET['id'];
	
	$sql="delete from wraith_gw where id=$id";
	echo $sql;
	exsql($sql);
	
	Header("Location:gw_list.php");
	
?>