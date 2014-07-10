<?php
include("check.php");

$area = isset($_GET['area'])?$_GET['area']:'';
$cmdid = isset($_GET['cmdid'])?$_GET['cmdid']:'';
$forbidden_area = (isset($_GET['forbidden_area']) && (trim($_GET['forbidden_area'])!='没有禁止市区'))?$_GET['forbidden_area']:'11';
$forbidden_area=trim($forbidden_area);
//echo $area.'---'.$cmdid.'-----'.$forbidden_area;exit;
if($forbidden_area=='11'){
	echo 1;
	exit;
}
$sql='select forbidden_area from mtrs_cmd where ID='.$cmdid;
$result=exsql($sql);
$row=mysqli_fetch_row($result);
if(empty($row[0])){
	$sql="update mtrs_cmd set forbidden_area='$forbidden_area' where ID=$cmdid";
	exsql($sql);
	echo 2;
}else{
	$res='';
	$rows = explode(' ',$row[0]);
	//print_r($rows);exit;
	foreach($rows as $r){
		if(strstr($r,$area)===false){
			$res.=($r.' ');
		}
	}
	$sql="update mtrs_cmd set forbidden_area='".$res.$forbidden_area."' where ID='$cmdid'";
	exsql($sql);
	echo 3;
}









?>



