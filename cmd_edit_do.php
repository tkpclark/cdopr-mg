<?php
	include("check.php"); 
	include("style.php");

$cmd_id = isset($_REQUEST['cmd_id'])?$_REQUEST['cmd_id']:"";
$cpID = isset($_REQUEST['cpid'])?$_REQUEST['cpid']:"";
$serviceID = isset($_REQUEST['serviceid'])?$_REQUEST['serviceid']:"";
$spnumber = isset($_REQUEST['cmd_spnumber'])?$_REQUEST['cmd_spnumber']:"";
$mocmd = isset($_REQUEST['cmd_mocmd'])?$_REQUEST['cmd_mocmd']:"";
$deduction = isset($_REQUEST['deduction'])?round($_REQUEST['deduction']/100,2):"";
$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
$url = isset($_REQUEST['url'])?$_REQUEST['url']:"";
//$fee = isset($_REQUEST['fee'])?$_REQUEST['fee']:0;


if($cmd_id=="")
{
		$sql = "insert into mtrs_cmd (spnumber,mocmd,cpID,serviceID,status,url) 
						values('$spnumber','$mocmd','$cpID','$serviceID','$status', '$url')";
		//echo $sql;
		exsql($sql);
		
		//default deduction
		$sql = "insert into mtrs_deduction(cmdID,zone,deduction) values('".mysqli_insert_id($mysqli)."','0','$deduction')";
		//echo $sql;
		exsql($sql);
}
else
{
		$sql = "update mtrs_cmd set cpID='$cpID',serviceID='$serviceID', spnumber='$spnumber', mocmd='$mocmd',status='$status',url='$url'
						where ID=$cmd_id";
		//echo $sql;
		exsql($sql);
		
		$sql = "update mtrs_deduction set deduction=$deduction where cmdID=$cmd_id and zone='0'";
		//echo $sql;
		exsql($sql);
}



Header("Location:cmd_list.php");
