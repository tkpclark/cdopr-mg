<?php
	include("check.php"); 
	include("style.php");
	
	if(!isset($_GET['cmdid']))
	{
		exit;
	}
	$cmdid=$_GET['cmdid'];
	
	$sql="delete from mtrs_cmd where ID=$cmdid";
	echo $sql;
	exsql($sql);
	
	$sql="delete from wraith_visit_limit where cmdID=$cmdid";
	echo $sql;
	exsql($sql);

	$sql="delete from mtrs_cmd_mt where cmdID=$cmdid";
	echo $sql;
	exsql($sql);
	
	
	Header("Location:cmd_list.php");
	
?>