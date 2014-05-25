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
$service_name=isset($_REQUEST['service_name'])?$_REQUEST['service_name']:"";
$service_id=isset($_REQUEST['service_id'])?$_REQUEST['service_id']:"";
$gwID=isset($_REQUEST['gwID'])?$_REQUEST['gwID']:"";

if($serviceID=="")
	$sql = "insert into mtrs_service (name,sp_number,mo_cmd,msgtype,status,spID,fee,service_id,gwID) values('$service_name', '$spnumber','$mocmd','$msgtype','$status','$spID','$fee','$service_id','$gwID')";
else
	$sql="update mtrs_service set name='$service_name',sp_number='$spnumber',mo_cmd='$mocmd',msgtype='$msgtype',spID='$spID',status='$status',fee='$fee',service_id='$service_id',gwID='$gwID' where ID=$serviceID";
echo $sql;


exsql($sql);

Header("Location:service_list.php");
