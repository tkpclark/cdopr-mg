<?php
	include("check.php"); 
	include("style.php");
	
	if(!isset($_GET['did']))
	{
		exit;
	}
	$did=$_GET['did'];
	
	$sql="delete from wraith_wo_deduction where id=$did";
	echo $sql;
	exsql($sql);
	
	Header("Location:wo_deduction_list.php");
	
?>