<?php
	require_once("check.php"); 
	//include("style.php");
	

	if(!isset($_GET['cpProdID'])||!isset($_GET['province'])||!isset($_GET['deduction_value']))
		exit;
	$cmd_id=$_GET['cpProdID'];
	$province=$_GET['province'];
	$deduction_value=$_GET['deduction_value'];
	echo $cmd_id.$province.$deduction_value;
	$deduction_value=number_format($deduction_value/100,2);
	$sql = "insert into mtrs_deduction (cpProdID, zone, deduction) values ('$cmd_id', '$province', '$deduction_value')";
	exsql($sql);
?>

number_format(100*$row[11]/$row[10],2)