<?php
	include("check.php"); 
	include("style.php");
$id= isset($_POST['id'])?$_POST['id']:"";
$complaint_content = isset($_POST['complaint_content'])?$_POST['complaint_content']:"";
$reply_content = isset($_POST['reply_content'])?$_POST['reply_content']:"";
$complaint_result = isset($_POST['complaint_result'])?$_POST['complaint_result']:"";
$refund_form = isset($_POST['refund_form'])?$_POST['refund_form']:"";


$sql="update wraith_message_complaint set complaint_content='$complaint_content',reply_content='$reply_content',complaint_result='$complaint_result' where id=$id";



exsql($sql);

Header("Location:message_complaint.php");

