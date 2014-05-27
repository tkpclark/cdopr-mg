<?php
	require_once("check.php"); 
	//include("style.php");
	

	if(!isset($_GET['cmd_id'])||!isset($_GET['province'])||!isset($_GET['monthly_limit'])||!isset($_GET['daily_limit']))
		exit;
	$cmd_id=$_GET['cmd_id'];
	$province=$_GET['province'];
	$monthly_limit=$_GET['monthly_limit'];
	$daily_limit=$_GET['daily_limit'];
	echo $cmd_id.$province.$daily_limit.$monthly_limit;
	$deduction_value=number_format($deduction_value/100,2);
	$sql = "insert into wraith_visit_limit (cmdID, province, daily_limit ,monthly_limit) values ('$cmd_id', '$province', '$daily_limit', '$monthly_limit')";
	exsql($sql);
?>

number_format(100*$row[11]/$row[10],2)