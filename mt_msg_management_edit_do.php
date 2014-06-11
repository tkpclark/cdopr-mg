<?php
include("check.php"); 
include("style.php");
	
$id = isset($_GET['id'])?$_GET['id']:"";
$message = isset($_POST['message'])?$_POST['message']:"";
$serviceID = isset($_POST['serviceID'])?$_POST['serviceID']:"";
$msgtype = isset($_POST['msgtype'])?$_POST['msgtype']:"";

if($id=="")
	$sql = "insert into wraith_mt_msg_management (message,serviceID,msgtype) values('$message','$serviceID','$msgtype')";
else
	$sql="update wraith_mt_msg_management set message='$message',serviceID='$serviceID',msgtype='$msgtype' where id=$id";
echo $sql;


exsql($sql);

Header("Location:mt_msg_management_list.php");
