<?php
	include("check.php"); 
	include("style.php");
	$mysqli = new mysqli('42.62.67.82', 'wo', 'x_pp23xxp#r', 'unciom_wo');
	if($mysqli->connect_error)
	{
		die('Connect Error (' . $mysqli->connect_errno . ') '
				. $mysqli->connect_error);
	}
	
	if(!isset($_GET['id']))
	{
		exit;
	}
	$id=$_GET['id'];
	
	$sql="DELETE FROM black_list WHERE id=$id";
	echo $sql;
	exsql($sql);
	
	Header("Location:wo_blklist.php");
	
?>