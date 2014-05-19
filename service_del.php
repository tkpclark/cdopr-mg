<?php
	include("check.php"); 
	include("style.php");
	
	if(!isset($_GET['channelid']))
	{
		exit;
	}
	$channelid=$_GET['channelid'];
	
	$sql="delete from mtrs_channel where ID=$channelid";
	echo $sql;
	exsql($sql);
	
	Header("Location:channel_list.php");
	
?>