<script>
	$(document).ready(function(){	
		$('#btnClose').click(function() {
			//关闭弹出层
			$.unblockUI();
		});

		$('.update_num').click(function() {
			var parameter = $(this).attr('_num');
			var obj = $(this);
			if(obj.has('input').length){
				return;
			}
			var org = obj.html();
			var wid = obj.css('width');
			obj.html('');
			if(org=='无限制'){ var org_obj=0;}else{ var org_obj=org;}
			obj.append("<input type='text' style='width:50px;height:10px' value='"+org_obj+"'/>"); 
			var input = obj.find('input');
			input.focus();

			input.blur(function(){
			  var inputval = input.val();
			  if(parseInt(inputval)==0 || isNaN(parseInt(inputval))){ var inputval_obj='无限制';}else{ var inputval_obj=inputval;}
			  if((parseInt(inputval)==0 || isNaN(parseInt(inputval))) && org=='无限制'){inputval='无限制'}
			  obj.empty();
			  obj.html(inputval_obj);
			  $.ajax({
				   type: "GET",
				   url: "monitoring_query_do_ajax.php?parameter="+parameter+"&num="+inputval,
				   cache:false,
				   success: function(msg){
					if(msg!=1 && msg!=3){alert("失败")}
					// alert(msg)
				   }
				});
			});
				
		
		});

		$('.update_deduction').click(function() {
			var parameter = $(this).attr('_num');
			var obj = $(this);
			if(obj.has('input').length){
				return;
			}
			var org = obj.html();
			var wid = obj.css('width');
			obj.html('');
			if(org=='无限制'){ var org_obj=0;}else{ var org_obj=org;}
			obj.append("<input type='text' style='width:50px;height:10px' value='"+org_obj+"'/>"); 
			var input = obj.find('input');
			input.focus();

			input.blur(function(){
			  var inputval = input.val();
			  if(parseInt(inputval)==0 || isNaN(parseInt(inputval))){ var inputval_obj='无限制';}else{ var inputval_obj=inputval;}
			  if((parseInt(inputval)==0 || isNaN(parseInt(inputval))) && org=='无限制'){inputval='无限制'}
			  obj.empty();
			  obj.html(inputval_obj);
			  $.ajax({
				   type: "GET",
				   url: "monitoring_query_do_ajax.php?parameter="+parameter+"&num="+inputval,
				   cache:false,
				   success: function(msg){
					if(msg!=1 && msg!=3){alert("失败")}
					// alert(msg)
				   }
				});
			});
				
		
		});
		//省份开关
		$('.onoff').click(function() {
			var parameter = $(this).attr('_num');
			var txt = parameter.substr(-1);
			var self = $(this);
			$.ajax({
			   type: "GET",
			   url: "monitoring_query_do_provinces.php?parameter="+parameter,
			   cache:false,
			   success: function(msg){
					if(msg==1){
						if(txt==1){
							self.html('关闭');
						}else{
							self.html('开启');
						}
					}else{
						alert('失败');
					}
			   }
			});
		});	
		//查看禁止市区
		$('.see').click(function() {
			var parameter = $(this).attr('_num');
			$.ajax({
			   type: "GET",
			   url: "monitoring_query_do_provinces.php?parameter="+parameter,
			   cache:false,
			   success: function(msg){
					//alert(msg);
					$('.see_area').replaceWith(msg);
			   }
			});
		});	
			  
		
	});
 </script>
 <style>
 table {  
            border: 1px solid #B1CDE3;  
            padding:0;   
            margin:0 auto;  
            border-collapse: collapse;  
            width: 100%;
 
        }  
          
        td,th {  
            border: 1px solid #B1CDE3;  
            background: #F4F6FD;  
            font-size:10px !important;     
            color: #4f6b72;  
            text-align:center;
			padding:0.8px; 
        }
 </style>
<?php
header("Content-type: text/html; charset=utf-8");
include("check.php");
include("area_code.php");

$cmdid = $_GET['cmdid'];

$cpProdID = $serviceID = $cpID = $spID = '';
if(!empty($cmdid)){
	
	$sql = "select ID,sp_number,mo_cmd,cpProdID,serviceID,open_province from mtrs_cmd where status=1 and ID = $cmdid";
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
	$sql = "select c1.id,c1.name,c2.ID,c2.cpname from mtrs_cp_product c1 LEFT JOIN mtrs_cp c2 on c1.cpID=c2.ID where c1.id = $cpProdID";
	$result=exsql($sql);
	$cp_row=mysqli_fetch_row($result);
	//print_r($cp_row);exit;
	
	/*
	//扣量mtrs_deduction
	*/
	$sql = "select * from mtrs_deduction where cpProdID=$cpProdID";
	$result=exsql($sql);
	while($deduction_row=mysqli_fetch_row($result)){
		$deduction_rows[]=$deduction_row;
	}


	/*
	//通道mtrs_service|mtrs_sp
	*/
	$serviceID = substr($serviceID,0,strrpos($serviceID,','));
	$sql = "select s1.ID,s1.name,s1.sp_number,s1.mo_cmd,s2.ID,s2.spname from mtrs_service s1 LEFT JOIN mtrs_sp s2 on s1.spID=s2.ID where s1.ID = $serviceID";
	$result=exsql($sql);
	$sp_row=mysqli_fetch_row($result);
	//print_r($sp_row);exit;


	/*
	//日限月限wraith_visit_limit
	*/
	$sql = "select id,cmdID,province,daily_limit,monthly_limit,limit_type from wraith_visit_limit where cmdID = $cmdid";
	$result=exsql($sql);
	while($visit_row=mysqli_fetch_row($result)){
		$visit_rows[]=$visit_row;
	}
	//print_r($visit_rows);exit;


	foreach($rows as $v){
		echo "<table style='width=100%'>";
		echo "<tr><td>";
		if($v[4]==$sp_row[0]){
			echo "通道:(".$sp_row[4].")".$sp_row[5]."-(".$sp_row[0].")".$sp_row[1]."-".$sp_row[2]."+".$sp_row[3];
		}
		echo "&nbsp;&nbsp;";
		if($v[3]==$cp_row[0]){
			echo "渠道:(".$cp_row[2].")".$cp_row[3]."-(".$cp_row[0].")".$cp_row[1];
		}
		echo "&nbsp;&nbsp;";
		echo "指令:".$v[1]."+".$v[2];


		echo "<span style='float:right;padding-right:5px' id='btnClose'>关闭</span></td></tr>";

		echo "<tr><td>";
		echo "<table>";
		echo "<tr><td>省份</td><td>状态</td><td>总数下发日限</td><td>单用户下发日限</td><td>总同步日限</td><td>总数下发月限</td><td>单用户下发月限</td><td>总同步月限</td><td>扣量(%)</td></tr>";
		//全部,默认--总数下发日月限、单用户下发日月限、转发日月限
		$default_visit_day=$default_visit_mon=$default_visit_day_one=$default_visit_mon_one=$default_visit_day_forward=$default_visit_mon_forward='';
		$daily_limit_all=$monthly_limit_all=$default_deduction='无限制';
		if(!empty($visit_rows)){
		foreach($visit_rows as $visit_all){
			if($visit_all[2]=='全部' && $visit_all[1]==$v[0]){
				$daily_limit_all=$visit_all[3];
				$monthly_limit_all=$visit_all[4];
				if($monthly_limit_all==0)$monthly_limit_all='无限制';
				if($daily_limit_all==0)$daily_limit_all='无限制';
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
					$default_deduction=$default_deduction;
				}
			}
		}
		echo "<tr><td>全部</td><td>--</td><td class='update_num' _num='$v[0]-全部-2-1'>$daily_limit_all</td><td>--</td><td>--</td><td class='update_num' _num='$v[0]-全部-2-2'>$monthly_limit_all</td><td>--</td><td>--</td><td>--</td></tr>";
		//默认
		echo "<tr><td>默认</td><td>--</td><td class='update_num' _num='$v[0]-默认-2-1'>".($default_visit_day!=null&&$default_visit_day!='0'?$default_visit_day:'无限制')."</td><td class='update_num' _num='$v[0]-默认-1-1'>".($default_visit_day_one!=null&&$default_visit_day_one!='0'?$default_visit_day_one:'无限制')."</td><td class='update_num' _num='$v[0]-默认-3-1'>".($default_visit_day_forward!=null&&$default_visit_day_forward!='0'?$default_visit_day_forward:'无限制')."</td><td class='update_num' _num='$v[0]-默认-2-2'>".($default_visit_mon!=null&&$default_visit_mon!='0'?$default_visit_day:'无限制')."</td><td class='update_num' _num='$v[0]-默认-1-2'>".($default_visit_mon_one!=null&&$default_visit_mon_one!='0'?$default_visit_mon_one:'无限制')."</td><td class='update_num' _num='$v[0]-默认-3-2'>".($default_visit_mon_forward!=null&&$default_visit_mon_forward!='0'?$default_visit_mon_forward:'无限制')."</td><td class='update_deduction' _num='$v[3]-默认'>".($default_deduction!=null&&$default_deduction!='0'?$default_deduction:'无限制')."</td></tr>";
		
		$i=0;
		foreach($area_code as $area){
			if($i%2==0){ 
				echo '<tr class="diff">'; 
			}else{ 
				echo '<tr>'; 
			}
			$i++;
			//省份
			echo "<td>$area</td>";
			//状态
			echo "<td>";
			if(strpos($v[5],$area)!==false){echo '<a class="onoff" href="javascript:void(0)"  _num="'.$v[0].'-'.$area.'-2">关闭</a>';}else{echo '<a class="onoff" href="javascript:void(0)"  _num="'.$v[0].'-'.$area.'-1">开通</a>';}
			echo '&nbsp;<a class="see" href="javascript:void(0)"  _num="'.$v[0].'-'.$area.'">查看</a>';
			echo "</td>";
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
			//总数下发日限
			echo "<td class='update_num' _num='$v[0]-$area-2-1'>".(($visit_day!=null&&$visit_day!=0)?$visit_day_true=$visit_day:($default_visit_day!=null&&$default_visit_day!='0'?$visit_day_true=$default_visit_day:$visit_day_true='无限制'))."</td>";
			//单用户下发日限
			echo "<td class='update_num' _num='$v[0]-$area-1-1'>".(($visit_day_one!=null&&$visit_day_one!=0)?$visit_day_one:($default_visit_day_one!=null&&$default_visit_day_one!='0'?$default_visit_day_one:'无限制'))."</td>";
			//总转发日限
			echo "<td class='update_num' _num='$v[0]-$area-3-1'>".(($visit_day_forward!=null&&$visit_day_forward!=0)?$visit_day_forward:($default_visit_day_forward!=null&&$default_visit_day_forward!='0'?$default_visit_day_forward:'无限制'))."</td>";
			//总数下发月限
			echo "<td class='update_num' _num='$v[0]-$area-2-2'>".(($visit_mon!=null&&$visit_mon!=0)?$visit_mon_true=$visit_mon:($default_visit_mon!=null&&$default_visit_mon!='0'?$visit_mon_true=$default_visit_mon:$visit_mon_true='无限制'))."</td>";
			//单用户下发月限
			echo "<td class='update_num' _num='$v[0]-$area-1-2'>".(($visit_mon_one!=null&&$visit_mon_one!=0)?$visit_mon_one:($default_visit_mon_one!=null&&$default_visit_mon_one!='0'?$default_visit_mon_one:'无限制'))."</td>";
			//总转发月限
			echo "<td class='update_num' _num='$v[0]-$area-3-2'>".(($visit_mon_forward!=null&&$visit_mon_forward!=0)?$visit_mon_forward:($default_visit_mon_forward!=null&&$default_visit_mon_forward!='0'?$default_visit_mon_forward:'无限制'))."</td>";
			//扣量
			$deduction='无限制';
			if(!empty($deduction_rows)){
			foreach($deduction_rows as $ded){
				if($v[3]==$ded[1] && $area==$ded[2]){
					$deduction=$ded[3]*100;
					$deduction=$deduction;
				}
			}
			}
			echo "<td class='update_deduction' _num='$v[3]-$area'>".(($deduction!=null&&$deduction!=0)?$deduction:($default_deduction!=null&&$default_deduction!='0'?$default_deduction:'无限制'))."</td>";
			
			echo "</tr>";
		}
		echo "</table>";
		echo "</td></tr>";

		echo "</table>";

	}
	echo "<div class='see_area'></div>";	

}else{
	echo "请选择监控的指令......";
}
?>



