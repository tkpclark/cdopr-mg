<?php
	include("check.php"); 
	include("style.php");

$cmd_id = isset($_REQUEST['cmd_id'])?$_REQUEST['cmd_id']:"";
$cpProdID = isset($_REQUEST['cpProdID'])?$_REQUEST['cpProdID']:"";
$serviceID = isset($_REQUEST['serviceID'])?$_REQUEST['serviceID']:"";
$sp_number = isset($_REQUEST['cmd_spnumber'])?$_REQUEST['cmd_spnumber']:"";
$mo_cmd = isset($_REQUEST['cmd_mocmd'])?$_REQUEST['cmd_mocmd']:"";
$deduction = isset($_REQUEST['deduction'])?round($_REQUEST['deduction']/100,2):"";
$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
//$open_province = isset($_REQUEST['open_province'])?$_REQUEST['open_province']:"";
//$forbidden_area = isset($_REQUEST['forbidden_area'])?$_REQUEST['forbidden_area']:"";
//$fee = isset($_REQUEST['fee'])?$_REQUEST['fee']:0;
$checkblk = isset($_REQUEST['checkblk'])?$_REQUEST['checkblk']:"";
$is_agent = isset($_REQUEST['is_agent'])?$_REQUEST['is_agent']:"";

//获取通道
$sql="select spID from mtrs_service where ID=".$serviceID;
 $result=exsql($sql);
 $row=mysqli_fetch_row($result);

if($cmd_id=="")
{
		$sql = "insert into mtrs_cmd (sp_number,mo_cmd,cpProdID,serviceID,status,checkblk,is_agent) 
						values('$sp_number','$mo_cmd','$cpProdID','$serviceID','$status','$checkblk','$is_agent')";
		//echo $sql;
		exsql($sql);
		
		/*
		//default deduction
		$sql = "insert into mtrs_deduction(cmdID,zone,deduction) values('".mysqli_insert_id($mysqli)."','0','$deduction')";
		//echo $sql;
		exsql($sql);
		*/
}
else
{
		$sql = "update mtrs_cmd set cpProdID='$cpProdID',serviceID='$serviceID', sp_number='$sp_number', mo_cmd='$mo_cmd',status='$status',checkblk='$checkblk',is_agent='$is_agent'
						where ID=$cmd_id";
		//echo $sql;
		exsql($sql);
		
		/*
		$sql = "update mtrs_deduction set deduction=$deduction where cmdID=$cmd_id and zone='0'";
		//echo $sql;
		exsql($sql);
		*/
}


$cmd_id = !empty($cmd_id)?$cmd_id:mysql_insert_id();
Header("Location:cmd_list.php?spID=$row[0]&cmd_id=$cmd_id ");
