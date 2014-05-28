<?php
	require_once("check.php"); 
	//include("style.php");
	

	if(!isset($_GET['cmd_id'])||!isset($_GET['content']))
		exit;
	$cmd_id=$_GET['cmd_id'];
	$content=$_GET['content'];
	echo $cmd_id.$content;
	$sql = "insert into mtrs_cmd_mt (cmdID, content) values ('$cmd_id', '$content')";
	exsql($sql);
?>
