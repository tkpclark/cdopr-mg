<?php
	include("check.php"); 
	include("style.php");
	
$spID = isset($_REQUEST['spID'])?$_REQUEST['spID']:"";
$spname = isset($_REQUEST['spname'])?$_REQUEST['spname']:"";
$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
$sp_id = isset($_REQUEST['sp_id'])?$_REQUEST['sp_id']:"";

if($spID=="")
	$sql = "insert into mtrs_sp (spname,status,sp_id) values('$spname','$status','$sp_id')";
else
	$sql="update mtrs_sp set spname='$spname',status='$status',sp_id='$sp_id' where ID=$spID";
echo $sql;


exsql($sql);

Header("Location:sp_list.php");
