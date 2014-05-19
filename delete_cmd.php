<?php
include("check.php"); 
include("style.php");
if(!isset($_REQUEST['id']))
	die("no argument id");
$sql = "delete from mtrs_cmd where id=".$_REQUEST['id'];
echo $sql;
mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
Header("Location:cmd_list.php");