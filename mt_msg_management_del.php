<?php
	include("check.php"); 
	
	if(!isset($_GET['id']))
	{
		exit;
	}
	$id=$_GET['id'];
	
	$sql="delete from wraith_mt_msg_management where id=$id";
	echo $sql;
	exsql($sql);
	
	Header("Location:mt_msg_management_list.php");
	
?>