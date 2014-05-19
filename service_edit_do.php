<?php
	include("check.php"); 
	include("style.php");

$serviceID = isset($_REQUEST['serviceID'])?$_REQUEST['serviceID']:"";
$spID = isset($_REQUEST['spID'])?$_REQUEST['spID']:"";
$spnumber = isset($_REQUEST['spnumber'])?$_REQUEST['spnumber']:"";
$mocmd = isset($_REQUEST['mocmd'])?$_REQUEST['mocmd']:"";
$msgtype = isset($_REQUEST['msgtype'])?$_REQUEST['msgtype']:"";
$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
$fee = isset($_REQUEST['fee'])?$_REQUEST['fee']:"";

if($serviceID=="")
	$sql = "insert into mtrs_service (spnumber,mocmd,msgtype,status,spID,fee) values('$spnumber','$mocmd','$msgtype','$status','$spID','$fee')";
else
	$sql="update mtrs_service set spnumber='$spnumber',mocmd='$mocmd',msgtype='$msgtype',spID='$spID',status='$status',fee='$fee' where ID=$serviceID";
echo $sql;


exsql($sql);

Header("Location:service_list.php");
