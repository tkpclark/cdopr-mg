<?php
include("check.php");

$id = isset($_GET['id'])?$_GET['id']:'';
$type = isset($_GET['type'])?$_GET['type']:'';
$inputval = isset($_GET['inputval'])?$_GET['inputval']:'';
if($type=='up'){
	$set = " up_deduction='$inputval' ";
}else{
	$set = " down_deduction='$inputval' ";
}
$sql="update wraith_wo_deduction set $set where id=$id";
//echo $sql;exit;
$result = exsql($sql);
if($result){
echo 1;
}











?>



