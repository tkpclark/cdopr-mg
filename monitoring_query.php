<script>
	$(document).ready(function(){	
		 $('.update').click(function() {
			 var cmdid = $(this).attr('_cmdid');
			$.ajax({
			   type: "GET",
			   url: "monitoring_query_do.php?cmdid="+cmdid,
			   cache:false,
			   success: function(msg){
				 $.blockUI({ message: msg ,
							 css: { 
								width: '800px',  
								left: ($(window).width() - 700) / 2 + 'px', 
								top: '0px', 
								border: 'none' 
								}  	 
				 });
			   }
			});

		 });

		$('#btnClose').click(function() {
			//关闭弹出层
			$.unblockUI();
		});
		
	})
 </script>
<?php
header("Content-type: text/html; charset=utf-8");
include("check.php");
include("style.php");
include("area_code.php");

ini_set('default_socket_timeout', -1); 

//redis缓存
$redis = new redis();  
$redis->connect('127.0.0.1', 6379);
//$redis->connect('42.62.78.248', 6379);

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
	if(!empty($rows)){
		/*
		//渠道mtrs_cp_product|mtrs_cp
		*/
		$cpProdID = substr($cpProdID,0,strrpos($cpProdID,','));
		if($cpProdID != null){
			$sql = "select c1.id,c1.name,c2.ID,c2.cpname from mtrs_cp_product c1 LEFT JOIN mtrs_cp c2 on c1.cpID=c2.ID where c1.id in ($cpProdID)";
			$result=exsql($sql);
			while($cp_row=mysqli_fetch_row($result)){
				$cp_rows[]=$cp_row;
			}

			/*
			//扣量mtrs_deduction
			*/
			$sql = "select * from mtrs_deduction where cpProdID in ($cpProdID)";
			$result=exsql($sql);
			while($deduction_row=mysqli_fetch_row($result)){
				$deduction_rows[]=$deduction_row;
			}
		}
		//print_r($cp_rows);exit;
		
		

		/*
		//通道mtrs_service|mtrs_sp
		*/
		$serviceID = substr($serviceID,0,strrpos($serviceID,','));
		if($serviceID != null){
			$sql = "select s1.ID,s1.name,s1.sp_number,s1.mo_cmd,s2.ID,s2.spname from mtrs_service s1 LEFT JOIN mtrs_sp s2 on s1.spID=s2.ID where s1.ID in ($serviceID)";
			$result=exsql($sql);
			while($sp_row=mysqli_fetch_row($result)){
				$sp_rows[]=$sp_row;
			}
		}
		//print_r($sp_rows);exit;


		/*
		//日限月限wraith_visit_limit
		*/
		$sql = "select id,cmdID,province,daily_limit,monthly_limit,limit_type from wraith_visit_limit where cmdID in ($cmd_ids)";
		$result=exsql($sql);
		while($visit_row=mysqli_fetch_row($result)){
			$visit_rows[]=$visit_row;
		}
		//print_r($visit_rows);exit;


		foreach($rows as $v){
			echo "<table>";
			echo "<tr><td>";
			foreach($sp_rows as $s){
				if($v[4]==$s[0]){
					echo "通道:(".$s[4].")".$s[5]."-(".$s[0].")".$s[1]."-".$s[2]."+".$s[3];
				}
			}
			echo "<span class='update' _cmdid=$v[0]><a href='#'  style='float:right;padding-right:5px'><img src='images/chakan.png' alt='添加/更改' width=16 height=16></a></span></td></tr>";
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
			echo "<tr><td>省份</td><td>状态</td><td>总数日量</td><td>总数下发日限</td><td>总同步日限</td><td>单用户下发日限</td><td>单用户下发月限</td><td>总数月量</td><td>总数下发月限</td><td>总同步月限</td><td>扣量</td></tr>";
			//echo "<tr><td>省份</td><td>状态</td><td>总数日量</td><td>总数下发日限</td><td>百分比</td><td>单用户下发日限</td><td>总同步日限</td><td>总数月量</td><td>总数下发月限</td><td>百分比</td><td>单用户下发月限</td><td>总同步月限</td><td>扣量</td></tr>";
			//全部,默认--总数下发日月限、单用户下发日月限、转发日月限
			$default_visit_day=$default_visit_mon=$default_visit_day_one=$default_visit_mon_one=$default_visit_day_forward=$default_visit_mon_forward='';
			$daily_limit_all=$monthly_limit_all=$default_deduction=$daily_limit_all_3=$monthly_limit_all_3='无限制';
			if(!empty($visit_rows)){
			foreach($visit_rows as $visit_all){
				//下发总量控制
				if($visit_all[2]=='全部' && $visit_all[1]==$v[0] && $visit_all[5]==2){
					$daily_limit_all=$visit_all[3];
					$monthly_limit_all=$visit_all[4];
					if($monthly_limit_all==0)$monthly_limit_all='无限制';
					if($daily_limit_all==0)$daily_limit_all='无限制';
				}
				//转发总量控制
				if($visit_all[2]=='全部' && $visit_all[1]==$v[0] && $visit_all[5]==3){
					$daily_limit_all_3=$visit_all[3];
					$monthly_limit_all_3=$visit_all[4];
					if($monthly_limit_all_3==0)$monthly_limit_all_3='无限制';
					if($daily_limit_all_3==0)$daily_limit_all_3='无限制';
				}
				if($visit_all[2]=='默认' && $visit_all[1]==$v[0] && $visit_all[5]=='2'){
						$default_visit_day=$visit_all[3];
						$default_visit_mon=$visit_all[4];
					}
				if($visit_all[2]=='默认' && $visit_all[1]==$v[0] && $visit_all[5]=='1'){
						$default_visit_day_one=$visit_all[3];
						$default_visit_mon_one=$visit_all[4];
					}
				if($visit_all[2]=='默认' && $visit_all[1]==$v[0] && $visit_all[5]=='3'){
						$default_visit_day_forward=$visit_all[3];
						$default_visit_mon_forward=$visit_all[4];
					}
			
			}
			}
			if(!empty($deduction_rows)){
				foreach($deduction_rows as $ded){
					if($v[3]==$ded[1] && $ded[2]=='默认'){
						$default_deduction=$ded[3]*100;
						$default_deduction=$default_deduction.'%';
					}
				}
			}
			//总数日、月量
			//echo $redis->get('a1_cmdID_date'); exit;
			$a1="a1_".$v[0]."_".date("Ymd",time());
			$a2="a2_".$v[0]."_".date("Ym",time());
			echo "<tr><td>全部</td><td>--</td><td>".($redis->get($a1)!=null?$redis_day_all=$redis->get($a1):$redis_day_all='0')."</td><td>$daily_limit_all</td><td>$daily_limit_all_3</td><td>--</td><td>--</td><td>".($redis->get($a2)!=null?$redis_mon_all=$redis->get($a2):$redis_mon_all='0')."</td><td>$monthly_limit_all</td><td>$monthly_limit_all_3</td><td>--</td></tr>";
			//echo "<tr><td>全部</td><td>--</td><td>".($redis->get($a1)!=null?$redis_day_all=$redis->get($a1):$redis_day_all='0')."</td><td>$daily_limit_all</td><td>".($daily_limit_all!=null&&$daily_limit_all!='无限制'?number_format(100*$redis_day_all/$daily_limit_all,2)."%":"0.00%")."</td><td>--</td><td>--</td><td>".($redis->get($a2)!=null?$redis_mon_all=$redis->get($a2):$redis_mon_all='0')."</td><td>$monthly_limit_all</td><td>".($monthly_limit_all!=null&&$monthly_limit_all!='无限制'?number_format(100*$redis_mon_all/$monthly_limit_all,2)."%":"0.00%")."</td><td>--</td><td>--</td><td>--</td></tr>";
			//默认
			echo "<tr><td>默认</td><td>--</td><td>--</td><td>".($default_visit_day!=null&&$default_visit_day!='0'?$default_visit_day:'无限制')."</td><td>".($default_visit_day_forward!=null&&$default_visit_day_forward!='0'?$default_visit_day_forward:'无限制')."</td><td>".($default_visit_day_one!=null&&$default_visit_day_one!='0'?$default_visit_day_one:'无限制')."</td><td>".($default_visit_mon_one!=null&&$default_visit_mon_one!='0'?$default_visit_mon_one:'无限制')."</td>
			<td>--</td><td>".($default_visit_mon!=null&&$default_visit_mon!='0'?$default_visit_mon:'无限制')."</td><td>".($default_visit_mon_forward!=null&&$default_visit_mon_forward!='0'?$default_visit_mon_forward:'无限制')."</td><td>".($default_deduction!=null&&$default_deduction!='0'?$default_deduction:'无限制')."</td></tr>";
			//echo "<tr><td>默认</td><td>--</td><td>--</td><td>".($default_visit_day!=null&&$default_visit_day!='0'?$default_visit_day:'无限制')."</td><td>--</td><td>".($default_visit_day_one!=null&&$default_visit_day_one!='0'?$default_visit_day_one:'无限制')."</td><td>".($default_visit_day_forward!=null&&$default_visit_day_forward!='0'?$default_visit_day_forward:'无限制')."</td><td>--</td><td>".($default_visit_mon!=null&&$default_visit_mon!='0'?$default_visit_day:'无限制')."</td><td>--</td><td>".($default_visit_mon_one!=null&&$default_visit_mon_one!='0'?$default_visit_mon_one:'无限制')."</td><td>".($default_visit_mon_forward!=null&&$default_visit_mon_forward!='0'?$default_visit_mon_forward:'无限制')."</td><td>".($default_deduction!=null&&$default_deduction!='0'?$default_deduction:'无限制')."</td></tr>";
			
			foreach($area_code as $area){
				echo "<tr>";
				//省份
				echo "<td>$area</td>";
				//状态
				echo "<td>";
				if(strpos($v[5],$area)!==false){echo "已开通";}else{echo "未开通";}
				echo "</td>";
				//总数日量p2_54_山东_20140609
				$p2_day = "p1_".$v[0]."_".$area."_".date('Ymd',time());
				echo "<td>".($redis->get($p2_day)!=null?$redis_day=$redis->get($p2_day):$redis_day='0')."</td>";

				//总数下发日月限、单用户下发日月限、转发日月限
				$visit_day=$visit_mon=$visit_day_one=$visit_mon_one=$visit_day_forward=$visit_mon_forward='';
				if(!empty($visit_rows)){
				foreach($visit_rows as $visit){
					if($visit[1]==$v[0] && $area==$visit[2] && $visit[5]=='2'){
						$visit_day=$visit[3];
						$visit_mon=$visit[4];

					}
					if($visit[1]==$v[0] && $area==$visit[2] && $visit[5]=='1'){
						$visit_day_one=$visit[3];
						$visit_mon_one=$visit[4];

					}
					if($visit[1]==$v[0] && $area==$visit[2] && $visit[5]=='3'){
						$visit_day_forward=$visit[3];
						$visit_mon_forward=$visit[4];

					}
					
				}
				}
				echo "<td>".(($visit_day!=null&&$visit_day!=0)?$visit_day_true=$visit_day:($default_visit_day!=null&&$default_visit_day!='0'?$visit_day_true=$default_visit_day:$visit_day_true='无限制'))."</td>";
				//百分比
				//echo "<td>".($visit_day_true!=null&&$visit_day_true!='无限制'&&$visit_day_true!='0'?number_format(100*$redis_day/$visit_day_true,2)."%":"0.00%")."</td>";
				//总转发日限
				echo "<td>".(($visit_day_forward!=null&&$visit_day_forward!=0)?$visit_day_forward:($default_visit_day_forward!=null&&$default_visit_day_forward!='0'?$default_visit_day_forward:'无限制'))."</td>";
				//单用户下发日限
				echo "<td>".(($visit_day_one!=null&&$visit_day_one!=0)?$visit_day_one:($default_visit_day_one!=null&&$default_visit_day_one!='0'?$default_visit_day_one:'无限制'))."</td>";
				//单用户下发月限
				echo "<td>".(($visit_mon_one!=null&&$visit_mon_one!=0)?$visit_mon_one:($default_visit_mon_one!=null&&$default_visit_mon_one!='0'?$default_visit_mon_one:'无限制'))."</td>";
				//总数月量p2_54_山东_201406
				$p2_mon = "p2_".$v[0]."_".$area."_".date('Ym',time());
				echo "<td>".($redis->get($p2_mon)!=null?$redis_mon=$redis->get($p2_mon):$redis_mon='0')."</td>";
				//总数下发月限
				echo "<td>".(($visit_mon!=null&&$visit_mon!=0)?$visit_mon_true=$visit_mon:($default_visit_mon!=null&&$default_visit_mon!='0'?$visit_mon_true=$default_visit_mon:$visit_mon_true='无限制'))."</td>";
				//百分比
				//echo "<td>".($visit_mon_true!=null&&$visit_mon_true!='无限制'&&$visit_mon_true!='0'?number_format(100*$redis_mon/$visit_mon_true,2)."%":"0.00%")."</td>";
				
				//总转发月限
				echo "<td>".(($visit_mon_forward!=null&&$visit_mon_forward!=0)?$visit_mon_forward:($default_visit_mon_forward!=null&&$default_visit_mon_forward!='0'?$default_visit_mon_forward:'无限制'))."</td>";
				//扣量
				$deduction='无限制';
				if(!empty($deduction_rows)){
				foreach($deduction_rows as $ded){
					if($v[3]==$ded[1] && $area==$ded[2]){
						$deduction=$ded[3]*100;
						$deduction=$deduction.'%';
					}
				}
				}
				echo "<td>".(($deduction!=null&&$deduction!=0)?$deduction:($default_deduction!=null&&$default_deduction!='0'?$default_deduction:'无限制'))."</td>";
				
				echo "</tr>";
			}
			echo "</table>";
			echo "</td></tr>";

			echo "</table>";

		}
	}else{
		echo "该指令不存在或已关闭......";
	}


}else{
	echo "请选择监控的指令......";
}
?>



