<style>
.impor{
width:50% !important;
float:left;
}
</style>
<?php
header("Content-type: text/html; charset=utf-8");
include("check.php");
include("style.php");
include("area_code.php");

//redis缓存
$redis = new redis();  
$redis->connect('42.62.78.247', 6379);  

$cmd_ids = $_GET['cmd_ids'];
//$cmd_ids= '54,67,';
$cpProdID = $serviceID = $cpID = $spID = '';
if(!empty($cmd_ids)){
	
	$cmd_ids = substr($cmd_ids,0,strrpos($cmd_ids,','));
	$sql = "select ID,sp_number,mo_cmd,cpProdID,serviceID,open_province from mtrs_cmd where status=1 and ID in ($cmd_ids)";
	$result=exsql($sql);
	while($row=mysqli_fetch_row($result)){
		$rows[]=$row;
		$cpProdID .= $row[3].',';
		$serviceID .= $row[4].',';
		
	}

	/*
	//渠道mtrs_cp_product|mtrs_cp
	*/
	$cpProdID = substr($cpProdID,0,strrpos($cpProdID,','));
	$sql = "select c1.id,c1.name,c2.ID,c2.cpname from mtrs_cp_product c1 LEFT JOIN mtrs_cp c2 on c1.cpID=c2.ID where c1.id in ($cpProdID)";
	$result=exsql($sql);
	while($cp_row=mysqli_fetch_row($result)){
		$cp_rows[]=$cp_row;
	}
	//print_r($cp_rows);exit;	



	/*
	//通道mtrs_service|mtrs_sp
	*/
	$serviceID = substr($serviceID,0,strrpos($serviceID,','));
	$sql = "select s1.ID,s1.name,s1.sp_number,s1.mo_cmd,s2.ID,s2.spname from mtrs_service s1 LEFT JOIN mtrs_sp s2 on s1.spID=s2.ID where s1.ID in ($serviceID)";
	$result=exsql($sql);
	while($sp_row=mysqli_fetch_row($result)){
		$sp_rows[]=$sp_row;
	}
	//print_r($sp_rows);exit;




	/*
	//日限月限wraith_visit_limit
	*/
	$sql = "select id,cmdID,province,daily_limit,monthly_limit from wraith_visit_limit where limit_type=2 and cmdID in ($cmd_ids)";
	$result=exsql($sql);
	while($visit_row=mysqli_fetch_row($result)){
		$visit_rows[]=$visit_row;
	}
	//print_r($visit_rows);exit;




	/*
	//总日限月限wraith_visit_limit
	*/
	$sql = "select cmdID,sum(daily_limit),sum(monthly_limit) from wraith_visit_limit where limit_type=2 and cmdID in ($cmd_ids) group by cmdID";
	$result=exsql($sql);
	while($visit_row_2=mysqli_fetch_row($result)){
		$visit_rows_2[]=$visit_row_2;
	}




	foreach($rows as $v){
		echo "<table class='impor'>";
		echo "<tr><td>";
		foreach($sp_rows as $s){
			if($v[4]==$s[0]){
				echo "通道:(".$s[4].")".$s[5]."-(".$s[0].")".$s[1]."-".$s[2]."+".$s[3];
			}
		}
		echo "</td></tr>";
		echo "<tr><td>";
		foreach($cp_rows as $c){
			if($v[3]==$c[0]){
				echo "渠道:(".$c[2].")".$c[3]."-(".$c[0].")".$c[1];
			}
		}
		echo "</td></tr>";
		echo "<tr><td>";
		echo "指令:".$v[1]."+".$v[2];
		echo "</td></tr>";

		echo "<tr><td>";
		echo "<table>";
		echo "<tr><td>省份</td><td>总数日量</td><td>总数日限</td><td>百分比</td><td>总数月量</td><td>总数月限</td><td>百分比</td><td>状态</td></tr>";
		$sum_daily_limit='--';
		$sum_monthly_limit='--';
		//总数日、月限
		if(!empty($visit_rows_2)){
		foreach($visit_rows_2 as $visit_2){
			if($visit_2[0]==$v[0]){
				$sum_daily_limit=$visit_2[1];
				$sum_monthly_limit=$visit_2[2];
			}
		
		}
		}
		//总数日、月量
		//echo $redis->get('a1_cmdID_date'); exit;
		$a1="a1_".$v[0]."_".date("Ymd",time());
		$a2="a2_".$v[0]."_".date("Ym",time());
		echo "<tr><td>全部</td><td>".$redis->get($a1)."</td><td>$sum_daily_limit</td><td>百分比</td><td>".$redis->get($a2)."</td><td>$sum_monthly_limit</td><td>百分比</td><td>--</td></tr>";
		foreach($area_code as $area){
			echo "<tr>";
			//省份
			echo "<td>$area</td>";
			//总数日量p2_54_山东_20140609
			$p2_day = "p2_".$v[0]."_".$area."_".date('Ymd',time());
			echo "<td>".$redis->get($p2_day)."</td>";
			//总数日限
			$visit_day=$visit_mon='';
			if(!empty($visit_rows)){
			foreach($visit_rows as $visit){
				if($visit[1]==$v[0] && $area==$visit[2]){
					$visit_day=$visit[3];
					$visit_mon=$visit[4];
				}
			}
			}
			echo "<td>$visit_day</td>";
			//百分比
			echo "<td>$area</td>";
			//总数月量
			//总数日量p2_54_山东_201406
			$p2_mon = "p2_".$v[0]."_".$area."_".date('Ym',time());
			echo "<td>"./*$redis->get($a1)*/$p2_mon."</td>";
			//总数月限
			echo "<td>$visit_mon</td>";
			//百分比
			echo "<td>$area</td>";
			//状态
			echo "<td>";
			if(strpos($v[5],$area)!==false){echo "已开通";}else{echo "未开通";}
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</td></tr>";

		echo "</table>";

	}


}else{
	echo "请选择监控的指令......";
}
?>



