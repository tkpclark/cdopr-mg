<?php
	require_once 'mysql.php';
	require_once './log4php/php/Logger.php';
	//打印日志
	$logging = Logger::getLogger('statistic_sql');
	Logger::configure('./statistic.xml');
	
	$tbl="wraith_statistic";


	/***********condition***********/
	$sql_condition="where 1 ";
	if(isset($_REQUEST["query_type"]))
	{
		$query_type=$_REQUEST["query_type"];
	}
	if(isset($_REQUEST["date1"]) && $_REQUEST["date1"]!='1970-01-01')
	{
		$sql_condition.="and stat_time>='".$_REQUEST["date1"]."' ";
	}
	if(isset($_REQUEST["date2"]) && $_REQUEST["date2"]!=date('Y-m-d',time()))
	{
		$sql_condition.="and stat_time<='".$_REQUEST["date2"].":23:59' ";
	}

	if(isset($_REQUEST["is_agent"])&&!empty($_REQUEST["is_agent"]))
	{
		$sql_condition.="and is_agent='".$_REQUEST["is_agent"]."' ";
	}
	if(isset($_REQUEST["feetype"])&&!empty($_REQUEST["feetype"]))
	{
		$sql_condition.="and feetype='".$_REQUEST["feetype"]."' ";
	}
	if(isset($_REQUEST["gwid"])&&!empty($_REQUEST["gwid"]))
	{
		$sql_condition.="and gwid='".$_REQUEST["gwid"]."' ";
	}
	if(isset($_REQUEST["province"])&&!empty($_REQUEST["province"]))
	{
		$sql_condition.="and province='".$_REQUEST["province"]."' ";
	}
	if(isset($_REQUEST["spID"])&&!empty($_REQUEST["spID"]))
	{
		$sql_condition.="and spID='".$_REQUEST["spID"]."' ";
	}
	if(isset($_REQUEST["serviceID"])&&!empty($_REQUEST["serviceID"]))
	{
		$sql_condition.="and serviceID='".$_REQUEST["serviceID"]."' ";
	}
	if(isset($_REQUEST["cpid"])&&!empty($_REQUEST["cpid"]))
	{
		$sql_condition.="and cpID='".$_REQUEST["cpid"]."' ";
	}
	if(isset($_REQUEST["cpProdID"])&&!empty($_REQUEST["cpProdID"]))
	{
		$sql_condition.="and cpProdID='".$_REQUEST["cpProdID"]."' ";
	}
	if(isset($_REQUEST["cmdID"])&&!empty($_REQUEST["cmdID"]))
	{
		$sql_condition.="and cmdID='".$_REQUEST["cmdID"]."' ";
	}


	//查询字段/group
	$group_flag=0;
	$sql_group='';
	$sql_field='';
	if(isset($_REQUEST['date_group']) && $_REQUEST['date_group']=="on")
	{
		$group_flag=1;
		if(isset($_REQUEST['date_type']) && $_REQUEST['date_type']=="day")
			$sql_field.="DATE_FORMAT(stat_time,'%Y-%m-%d') as ddd, ";
		else
			$sql_field.="DATE_FORMAT(stat_time,'%Y-%m-%d %H') as ddd, ";

		$sql_group.="ddd,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['spID_group']) && $_REQUEST['spID_group']=="on")
	{
		$group_flag=1;
		$sql_field.="spID, ";
		$sql_group.="spID,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['serviceID_group']) && $_REQUEST['serviceID_group']=="on")
	{
		$group_flag=1;
		$sql_field.="serviceID, ";
		$sql_group.="serviceID,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['cpID_group']) && $_REQUEST['cpID_group']=="on")
	{
		$group_flag=1;
		$sql_field.="cpID, ";
		$sql_group.="cpID,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['cpProdID_group']) && $_REQUEST['cpProdID_group']=="on")
	{
		$group_flag=1;
		$sql_field.="cpProdID, ";
		$sql_group.="cpProdID,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['is_agent_group']) && $_REQUEST['is_agent_group']=="on")
	{
		$group_flag=1;
		$sql_field.="is_agent, ";
		$sql_group.="is_agent,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['feetype_group']) && $_REQUEST['feetype_group']=="on")
	{
		$group_flag=1;
		$sql_field.="feetype, ";
		$sql_group.="feetype,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['gwid_group']) && $_REQUEST['gwid_group']=="on")
	{
		$group_flag=1;
		$sql_field.="gwid, ";
		$sql_group.="gwid,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['province_group']) && $_REQUEST['province_group']=="on")
	{
		$group_flag=1;
		$sql_field.="province, ";
		$sql_group.="province,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['cmdID_group']) && $_REQUEST['cmdID_group']=="on")
	{
		$group_flag=1;
		$sql_field.="cmdID, ";
		$sql_group.="cmdID,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	$sql_field.=" sum(msg_count_all),sum(msg_count_legal),sum(msg_count_suc),sum(msg_count_deduction),sum(amount_suc),sum(amount_deduction),sum(msg_count_forward_mo),sum(msg_count_forward_mt),sum(msg_count_deduction_suc)";//,sum(amount_forward)";

	
	
	/**********result_info***************/
	if($query_type=='result_info')
	{	
		//生成实时统计数据到statistic表
		$cmd='python /home/tkp/cdopr/src/stat/stat.py 1';
		exec($cmd, $output, $result_py);
		setcookie("result_py",$result_py);
		if($result_py != 0)
		{
			$row['count']=''; 
		}
		else
		{
			$sql="select $sql_field from $tbl  ";
			$sql.=$sql_condition;
			if($group_flag==1)
			{
				$sql.=" group by ".$sql_group;
				$sql=substr($sql,0,strlen($sql)-1);
			}
			$result=mysqli_query($mysqli,$sql);
			$row['count']=mysqli_num_rows($result); 
		}
		echo json_encode($row);
		exit;
		
	}
	if($query_type=='result_page')
	{
		echo "<table width=100%>";
		echo "<tr>
				<th>ID</th>
				<th>日期</th>
				<th>通道</th>
				<th>通道业务</th>
				<th>渠道</th>
				<th>渠道业务</th>
				<th>是否代计费业务</th>
				<th>计费类型</th>
				<th>网关</th>
				<th>省份</th>
				<th>指令</th>

				<th>消息总量</th>
				<th>合法消息总量</th>
				<th>成功消息总量</th>
				<th>成功百分比</th>
				<th>结算后消息总量</th>
				<th>结算后成功消息总量</th>
				<th>结算百分比</th>
				<th>成功计费金额</th>
				<th>结算后金额</th>
				<th>MO转成功发量</th>
				<th>MT转成功发量</th>
				</tr>";
		if(isset($_COOKIE['result_py'])&&$_COOKIE['result_py'] != 0)
		{
			echo "<tr><td colspan=22>加载失败！</td></tr>"; 
		}
		else
		{
			//通道
			$sql_spID="select ID,spname from mtrs_sp";
			$result_spID=exsql($sql_spID);
			while($row_spID=mysqli_fetch_row($result_spID))
			{
				$row_spIDs[]=$row_spID;
			}
			//通道业务
			$sql_serviceID="select ID,name from mtrs_service";
			$result_serviceID=exsql($sql_serviceID);
			while($row_serviceID=mysqli_fetch_row($result_serviceID))
			{
				$row_serviceIDs[]=$row_serviceID;
			}
			//渠道
			$sql_cpID="select ID,cpname from mtrs_cp";
			$result_cpID=exsql($sql_cpID);
			while($row_cpID=mysqli_fetch_row($result_cpID))
			{
				$row_cpIDs[]=$row_cpID;
			}
			//渠道业务
			$sql_cpProdID="select id,name from mtrs_cp_product";
			$result_cpProdID=exsql($sql_cpProdID);
			while($row_cpProdID=mysqli_fetch_row($result_cpProdID))
			{
				$row_cpProdIDs[]=$row_cpProdID;
			}
			//指令表
			$sql_cmdID="select ID,sp_number,mo_cmd from mtrs_cmd";
			$result_cmdID=exsql($sql_cmdID);
			while($row_cmdID=mysqli_fetch_row($result_cmdID))
			{
				$row_cmdIDs[]=$row_cmdID;
			}

			$sql="select ";
			$sql.=$sql_field;
			$sql.=" from $tbl ";
			$sql.=$sql_condition;
			if($group_flag==1)
			{
				$sql.=" group by ".$sql_group;
				$sql=substr($sql,0,strlen($sql)-1);
			}
			$sql.=" limit ".$_REQUEST['pageSize']*($_REQUEST['pageNumber']-1).",".$_REQUEST['pageSize'] ;
			//echo $sql;exit;
			$logging->info($sql);//打印日志
			mysqli_query($mysqli,"set names utf8");
			if($result=mysqli_query($mysqli,$sql))
			{	$rows=array();
				while($row=mysqli_fetch_row($result))
				{
					$rows[]=$row;
				}
				$count=0;//总条数
				$count_legal=0;//合法消息总量
				$count_suc=0;//成功消息总条数
				$count_deductio=0;//扣量后条数
				$count_deductio_suc=0;//扣量后成功条数
				$amount_suc=0;//总成功金额
				$amount_deduction=0;//总扣量后金额
				$count_mo=0;//MO转发量
				$count_mt=0;//Mt转发量
				//$amount_forward=0;//转发金额

				$i=1;
				foreach($rows as $row)
				{
					echo "<tr align='center'>";
					echo "<th>".$i++."</th>";
					echo "<th>".$row[0]."</th>";
					$spIDs=array(0=>'',1=>'');
					//通道$row_spIDs
					if($row[1]!='All'){
						foreach($row_spIDs as $v){
							if($v[0]==$row[1]){
								$spIDs=$v;
							}
						}
						echo "<th>".'('.$spIDs[0].')'.$spIDs[1]."</th>";
					}else{
						echo "<th>".$row[1]."</th>";
					}
					//通道业务$row_serviceIDs
					$serviceIDs=array(0=>'',1=>'');
					if($row[2]!='All'){
						foreach($row_serviceIDs as $v){
							if($v[0]==$row[2]){
								$serviceIDs=$v;
							}
						}
						echo "<th>".'('.$serviceIDs[0].')'.$serviceIDs[1]."</th>";
					}else{
						echo "<th>".$row[2]."</th>";
					}
					//渠道$row_cpIDs
					$cpIDs=array(0=>'',1=>'');
					if($row[3]!='All'){
						foreach($row_cpIDs as $v){
							if($v[0]==$row[3]){
								$cpIDs=$v;
							}
						}
						echo "<th>".'('.$cpIDs[0].')'.$cpIDs[1]."</th>";
					}else{
						echo "<th>".$row[3]."</th>";
					}
					//渠道业务$row_cpProdIDs
					$cpProdIDs=array(0=>'',1=>'');
					if($row[4]!='All'){
						foreach($row_cpProdIDs as $v){
							if($v[0]==$row[4]){
								$cpProdIDs=$v;
							}
						}
						echo "<th>".'('.$cpProdIDs[0].')'.$cpProdIDs[1]."</th>";
					}else{
						echo "<th>".$row[4]."</th>";
					}
					//是否代计费业务
					if($row[5]=='All'){
						echo "<th>".$row[5]."</th>";
					}elseif($row[5]=='2'){
						echo "<th>是</th>";
					}elseif($row[5]=='1'){
						echo "<th>否</th>";
					}else{
						echo "<th></th>";
					}
					//计费类型
					if($row[6]=='All'){
						echo "<th>".$row[6]."</th>";
					}elseif($row[6]=='1'){
						echo "<th>点播</th>";
					}elseif($row[6]=='2'){
						echo "<th>包月</th>";
					}else{
						echo "<th></th>";
					}
					//网关
					if($row[7]!='All'){
						$sql="select id,comment from wraith_gw where id=$row[7]";
						$result=exsql($sql);
						$row_gwid=mysqli_fetch_row($result);
						echo "<th>".'('.$row_gwid[0].')'.$row_gwid[1]."</th>";
					}else{
						echo "<th>".$row[7]."</th>";
					}

					echo "<th>".$row[8]."</th>";
					//指令
					if($row[9]!='All'){
						$cmdIDs=array(0=>'',1=>'',2=>'');
						foreach($row_cmdIDs as $v){
							if($v[0]==$row[9]){
								$cmdIDs=$v;
							}
						}
						echo "<th>".'('.$cmdIDs[0].')'.$cmdIDs[1].'+'.$cmdIDs[2]."</th>";
					}else{
						echo "<th>".$row[9]."</th>";
					}
					echo "<td>".$row[10]."</td>";
					echo "<td>".$row[11]."</td>";
					echo "<td>".$row[12]."</td>";
					//成功百分比
					$percent_12=$row[10]>0?number_format(100*$row[12]/$row[10],2)."%":"";
					echo "<td>".$percent_12."</td>";

					echo "<td>".$row[13]."</td>";
					echo "<td>".$row[18]."</td>";
					//扣量百分比
					$percent_13=$row[11]>0?number_format(100*($row[13])/$row[11],2)."%":"";
					echo "<td>".$percent_13."</td>";

					echo "<td>".number_format($row[14]/100,2)."</td>";
					echo "<td>".number_format($row[15]/100,2)."</td>";
					echo "<td>".$row[16]."</td>";
					echo "<td>".$row[17]."</td>";
					//echo "<td>".number_format($row[18]/100,2)."</td>";
					echo "</tr>";

				$count+=$row[10];//总条数
				$count_legal+=$row[11];//总合法条数
				$count_suc+=$row[12];//总成功条数
				$count_deductio+=$row[13];//扣量后条数
				$count_deductio_suc+=$row[18];//扣量后成功条数
				$amount_suc+=$row[14];//总成功金额
				$amount_deduction+=$row[15];//总扣量后金额
				$count_mo+=$row[16];//MO转发量
				$count_mt+=$row[17];//Mt转发量
				//$amount_forward+=$row[18];//转发金额
				}
				//合计
			   echo "<tr align='center'>";
			   echo "<th>合计</th><th>--</th><th>--</th><th>--</th><th>--</th><th>--</th><th>--</th><th>--</th><th>--</th><th>--</th><th>--</th>";
			   echo "<td>$count</td>";
			   echo "<td>$count_legal</td>";
			   echo "<td>$count_suc</td>";
			   $suc=$count_legal>0?number_format(100*$count_suc/$count,2)."%":"0.00%";
				echo "<td>".$suc."</td>";
				echo "<td>$count_deductio</td>";
				echo "<td>$count_deductio_suc</td>";
				$deductio=$count_legal>0?number_format(100*($count_deductio)/$count_legal,2)."%":"0.00%";
				echo "<td>".$deductio."</td>";

				echo "<td>".number_format($amount_suc/100,2)."</td>";
				echo "<td>".number_format($amount_deduction/100,2)."</td>";
				echo "<td>$count_mo</td>";
				echo "<td>$count_mt</td>";
				//echo "<td>".number_format($amount_forward/100,2)."</td>";
			   echo "</tr>";
				//mysqli_free_result($result);
			}
		}
		echo "</table>";
		
		
	}
