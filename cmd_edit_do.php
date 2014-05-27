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
$open_province = isset($_REQUEST['open_province'])?$_REQUEST['open_province']:"";
$forbidden_area = isset($_REQUEST['forbidden_area'])?$_REQUEST['forbidden_area']:"";
//$fee = isset($_REQUEST['fee'])?$_REQUEST['fee']:0;


if($cmd_id=="")
{
		$sql = "insert into mtrs_cmd (sp_number,mo_cmd,cpProdID,serviceID,status,open_province,forbidden_area) 
						values('$sp_number','$mo_cmd','$cpProdID','$serviceID','$status','$open_province','$forbidden_area')";
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
		$sql = "update mtrs_cmd set cpProdID='$cpProdID',serviceID='$serviceID', sp_number='$sp_number', mo_cmd='$mo_cmd',status='$status',open_province='$open_province',forbidden_area='$forbidden_area'
						where ID=$cmd_id";
		//echo $sql;
		exsql($sql);
		
		/*
		$sql = "update mtrs_deduction set deduction=$deduction where cmdID=$cmd_id and zone='0'";
		//echo $sql;
		exsql($sql);
		*/
}



Header("Location:cmd_list.php");
