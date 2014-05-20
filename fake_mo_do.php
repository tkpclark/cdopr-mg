<?php
include("check.php"); 

$phone_number = isset($_REQUEST['phone_number'])?$_REQUEST['phone_number']:"";
$mo_message = isset($_REQUEST['mo_message'])?$_REQUEST['mo_message']:"";
$spnumber = isset($_REQUEST['spnumber'])?$_REQUEST['spnumber']:"";
$linkid = isset($_REQUEST['linkid'])?$_REQUEST['linkid']:"";
$gwid = isset($_REQUEST['gwid'])?$_REQUEST['gwid']:"";

$sql="set names utf8";
exsql($sql);
if(!empty($phone_number) && !empty($mo_message) && !empty($spnumber) && !empty($linkid) && !empty($gwid)){
	$sql="insert into wraith_message(phone_number,mo_message,sp_number,linkid,gwid) values('$phone_number','$mo_message','$spnumber','$linkid','$gwid')";
	if($result = exsql($sql)){
		echo 1;
	}else{
		echo "添加失败，请从新提交";
	}
}else{
	echo "信息不完整，请补全信息";
}





?>