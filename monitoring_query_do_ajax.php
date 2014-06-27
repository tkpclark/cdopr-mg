<?php
include("check.php");

$parameter = isset($_GET['parameter'])?$_GET['parameter']:'';
$limit = (isset($_GET['num']) && trim($_GET['num']!='无限制'))?$_GET['num']:'';
if(empty($limit)){
	echo 1;exit;
}
$arr = explode('-',$parameter); 
list($cmdid,$area,$limit_type,$day_mon)=$arr;

if(!empty($cmdid) && !empty($area) && !empty($limit_type) && !empty($limit) &&!empty($day_mon)){
	
	$sql = "select * from wraith_visit_limit where cmdID='$cmdid' and province='$area' and limit_type='$limit_type'";
	$result=exsql($sql);
	if(mysqli_num_rows($result) != 0){
		if($day_mon==1){
			$sql = "update wraith_visit_limit set daily_limit='$limit' where cmdID='$cmdid' and province = '$area' and limit_type='$limit_type' ";
		}
		if($day_mon==2){
			$sql = "update wraith_visit_limit set monthly_limit='$limit' where cmdID='$cmdid' and province = '$area' and limit_type='$limit_type' ";
		}
		$result=exsql($sql);
		if($result){
			echo 1;
		}else{
			echo 2;
		}
	}else{
		if($day_mon==1){
			$sql = "insert into wraith_visit_limit (cmdID , province , limit_type , daily_limit) values ('$cmdid', '$area', '$limit_type',$limit)";
		}
		if($day_mon==2){
			$sql = "insert into wraith_visit_limit (cmdID , province , limit_type , monthly_limit) values ('$cmdid', '$area', '$limit_type',$limit)";
		}
		$result=exsql($sql);
		if($result){
			echo 1;
		}else{
			echo 2;
		}
	
	}
}




?>



