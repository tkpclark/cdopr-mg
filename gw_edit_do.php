<?php
	include("check.php"); 
	include("style.php");
	
$id = isset($_GET['id'])?$_GET['id']:"";
$comment = isset($_REQUEST['comment'])?$_REQUEST['comment']:"";
$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";

if($id=="")
	$sql = "insert into wraith_gw (comment) values('$comment')";
else
	$sql="update wraith_gw set comment='$comment',status='$status' where id=$id";
echo $sql;


exsql($sql);

Header("Location:gw_list.php");
