<?php
	include("check.php"); 
date_default_timezone_set('Asia/Shanghai'); 
$id = isset($_GET['id'])?$_GET['id']:"";
$name = isset($_REQUEST['name'])?$_REQUEST['name']:"";
$cpID = isset($_REQUEST['cpID'])?$_REQUEST['cpID']:"";
$mourl = isset($_REQUEST['mourl'])?$_REQUEST['mourl']:"";
$mrurl = isset($_REQUEST['mrurl'])?$_REQUEST['mrurl']:"";
$checkblk= isset($_REQUEST['checkblk'])?$_REQUEST['checkblk']:"";
$forward_method = isset($_REQUEST['forward_method'])?$_REQUEST['forward_method']:"";
$remarks = isset($_REQUEST['remarks'])?$_REQUEST['remarks']:"";
$createtime = isset($_REQUEST['createtime'])?$_REQUEST['createtime']:date('Y-m-d H:i:s',time());

if($id=="")
	$sql = "insert into mtrs_cp_product(name,cpId,mourl,mrurl,checkblk,remarks,createtime,forward_method) values('$name','$cpID','$mourl','$mrurl',$checkblk,'$remarks','$createtime',$forward_method)";
else
	$sql="update mtrs_cp_product set name='$name',cpID='$cpID',mourl='$mourl',mrurl='$mrurl',checkblk='$checkblk',forward_method='$forward_method',remarks='$remarks',createtime='$createtime' where id=$id";
echo $sql;


exsql($sql);
Header("Location:cp_product_list.php");
