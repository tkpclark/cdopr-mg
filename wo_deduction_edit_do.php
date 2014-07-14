<?php
	include("check.php"); 
	include("style.php");
	
$did     = isset($_REQUEST['id'])?$_REQUEST['did']:"";
$name   = isset($_REQUEST['name'])?$_REQUEST['name']:"";
$province = isset($_REQUEST['province'])?$_REQUEST['province']:"";
$up_deduction  = isset($_REQUEST['up_deduction'])?$_REQUEST['up_deduction']:"";
$down_deduction  = isset($_REQUEST['down_deduction'])?$_REQUEST['down_deduction']:"";

if($did=="")
	$sql = "insert into wraith_wo_deduction (name,province,up_deduction,down_deduction) values('$name','$province','$up_deduction','$down_deduction')";
else
	$sql="update wraith_wo_deduction set name='$name',province='$province',up_deduction='$up_deduction',down_deduction='$down_deduction' where id=$did";
echo $sql;


exsql($sql);

Header("Location:wo_deduction_list.php");