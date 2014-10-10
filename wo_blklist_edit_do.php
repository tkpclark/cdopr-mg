<?php
	include("check.php"); 
	include("style.php");
	$mysqli = new mysqli('42.62.67.82', 'wo', 'x_pp23xxp#r', 'unciom_wo');
	if($mysqli->connect_error)
	{
		die('Connect Error (' . $mysqli->connect_errno . ') '
				. $mysqli->connect_error);
	}
	
	$phone_number = isset($_POST['phone_number'])?$_POST['phone_number']:"";
	$arr = explode(' ',$phone_number);
	
	$i=0;
	foreach($arr as $v)
	{
		$sql = "insert into black_list (payment_user,add_black_time) values('$v',now())";
		exsql($sql);
		++$i;
	}
	
	echo "导入".$i."个号码";
	sleep(10);

	Header("Location:wo_blklist.php");
