<?php
set_time_limit(0);
include("check.php");

$sql="SELECT DISTINCT phone_number FROM wraith_message_history WHERE report=1 AND gwid=40 and motime>'2014-09-05 00:00:00' AND province='未知'";
$result=exsql($sql);
while($row=mysqli_fetch_row($result)){
	$phone = substr($row[0],0,7);
	$sql="SELECT province FROM wraith_code_segment WHERE code='$phone'";
	$result1=exsql($sql);
	$row1=mysqli_fetch_row($result1);

	$sql="UPDATE wraith_message_history SET province='$row1[0]' WHERE phone_number='$row[0]' AND report=1 AND gwid=40 and motime>'2014-09-05 00:00:00' AND province='未知'";
	exsql($sql);
}

?>