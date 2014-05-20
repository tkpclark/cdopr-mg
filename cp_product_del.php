<?php
	include("check.php"); 
	include("style.php");
	
	if(!isset($_GET['id']))
	{
		exit;
	}
	$id=$_GET['id'];
	
	$sql="delete from wraith_cp_product where id=$id";
	echo $sql;
	exsql($sql);
	
	Header("Location:cp_product_list.php");
	
?>