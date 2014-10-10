<?php 
header("Content-type: text/html; charset=utf-8");

$ip="42.62.78.249";
$user="tkp";
$pwd="qepapap";
$db="cdopr";
if(!isset($_GET['d']))
{
	echo "请输入统计时长!";
	exit;
}

$d=$_GET['d'];
echo "统计时长：$d 分钟内<br>";
$mysqli = new mysqli($ip, $user, $pwd, $db);
if($mysqli->connect_error)
{
	die('Connect Error (' . $mysqli->connect_errno . ') '
			. $mysqli->connect_error);
}


$sql = "select id , comment from wraith_gw"; 
$result=exsql($sql);
while($row=mysqli_fetch_row($result)){
	$rows[]=$row;
	echo $row[0].":".$row[1]."<br>";
}

echo "<table border=1  bordercolor='#a0c6e5' style='border-collapse:collapse;' width='300'>";
echo "<tr><td>网关</td><td>上行</td><td>合法</td><td>未匹</td><td>等待</td><td>下发</td><td>成功</td><td>转发</td></tr>";
foreach($rows as $r){
	//总数量
	$sql = "select count(*) from wraith_message where gwid='$r[0]' and motime > NOW()-interval $d minute"; 
	//echo $sql."<br>";
	$result=exsql($sql);
	$row=mysqli_fetch_row($result);
	$num100 = $row[0];


	$sql = "select count(*) from wraith_message where mo_status='ok' and motime > NOW()-interval $d minute and gwid='$r[0]'";
	$result=exsql($sql);
	$row=mysqli_fetch_row($result);
	$num6 = $row[0];
	
	
	$sql = "select count(*) from wraith_message where gw_resp is not null and motime > NOW()-interval $d minute and gwid='$r[0]'";
	$result=exsql($sql);
	$row=mysqli_fetch_row($result);
	$num5 = $row[0];

	$sql = "select count(*) from wraith_message where report=1 and motime > NOW()-interval $d minute and gwid='$r[0]'";
	//echo $sql."<br>";
	$result=exsql($sql);
	$row=mysqli_fetch_row($result);
	$num1 = $row[0];
	

	$sql = "select count(*) from wraith_message where forward_status=2 and forward_mr_result=1 and motime > NOW()-interval $d minute and gwid='$r[0]'";  
	$result=exsql($sql);
	$row=mysqli_fetch_row($result);
	$num2 = $row[0];


	$sql="select count(*) from wraith_message where mo_status like  '%无匹配指令%' and motime > NOW()-interval $d minute  and gwid='$r[0]'";
	mysqli_query($mysqli,"set names utf8");
	$result=exsql($sql);
	$row=mysqli_fetch_row($result);
	$num3 = $row[0];

	$sql = "select count(*) from wraith_message where mo_status is NULL and motime > NOW()-interval $d minute  and gwid='$r[0]'";
	$result=exsql($sql);
	$row=mysqli_fetch_row($result);
	$num4 = $row[0];

	echo "<tr><td>$r[0]</td><td>$num100</td><td>$num6</td><td>$num3</td><td>$num4</td><td>$num5</td><td>$num1</td><td>$num2</td></tr>";
	
}

echo "</table>";





function exsql($sql)
{
	global $mysqli;
	mysqli_query($mysqli,"set names utf8");
	$result = mysqli_query($mysqli,$sql);
	if(!$result)
	 {
			echo "mysql error!\n";
		echo $sql;
		die('Connect Error (' . $mysqli->connect_errno . ') '
			. $mysqli->connect_error);
	 }
	 return $result;
}
   
?>