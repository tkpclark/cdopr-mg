<?php
	include("check.php"); 
date_default_timezone_set('Asia/Shanghai'); 
$id = isset($_GET['id'])?$_GET['id']:"";
$name = isset($_REQUEST['name'])?$_REQUEST['name']:"";
$cpID = isset($_REQUEST['cpID'])?$_REQUEST['cpID']:"";
$mourl = isset($_REQUEST['mourl'])?$_REQUEST['mourl']:"";
$mrurl = isset($_REQUEST['mrurl'])?$_REQUEST['mrurl']:"";
$checkblk = isset($_REQUEST['checkblk'])?$_REQUEST['checkblk']:"";
$synctype = isset($_REQUEST['synctype'])?$_REQUEST['synctype']:"";
$mt_method = isset($_REQUEST['mt_method'])?$_REQUEST['mt_method']:"";
$remarks = isset($_REQUEST['remarks'])?$_REQUEST['remarks']:"";
$createtime = isset($_REQUEST['createtime'])?$_REQUEST['createtime']:date('Y-m-d H:i:s',time());

if($id=="")
	$sql = "insert into wraith_cp_product values('','$name','$cpID','$mourl','$mrurl',$checkblk,$synctype,$mt_method,'$remarks','$createtime')";
else
	$sql="update wraith_cp_product set name='$name',cpID='$cpID',mourl='$mourl',mrurl='$mrurl',checkblk='$checkblk',synctype='$synctype',mt_method='$mt_method',remarks='$remarks',createtime='$createtime' where id=$id";
echo $sql;


exsql($sql);

Header("Location:cp_product_list.php");
