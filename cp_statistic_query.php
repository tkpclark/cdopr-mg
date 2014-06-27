<?php
	require_once 'mysql.php';
	
	$tbl="wraith_statistic";
	

	/***********condition***********/
	if(isset($_COOKIE['cpID'])&&$_COOKIE['cpID']!=0)
		$sql_condition="where cpID=".$_COOKIE['cpID']." ";
	else
		$sql_condition='where 1=1 ';


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


	if(isset($_REQUEST["province"])&&!empty($_REQUEST["province"]))
	{
		$sql_condition.="and province='".$_REQUEST["province"]."' ";
	}

	if(isset($_REQUEST["cpProdID"])&&!empty($_REQUEST["cpProdID"]))
	{
		$sql_condition.="and cpProdID='".$_REQUEST["cpProdID"]."' ";
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
	$sql_field.=" sum(msg_count_forward_mo),sum(msg_count_forward_mr),sum(amount_deduction),sum(msg_count_deduction_suc)";

	
	
	/**********result_info***************/
	if($query_type=='result_info')
	{	
		//生成实时统计数据到statistic表
		//$cmd='python /home/tkp/cdopr/src/stat/stat.py 1';
		//exec($cmd, $output, $result_py);
		//setcookie("result_py",$result_py);
		//if($result_py != 0)
		//{
		//	$row['count']=''; 
		//}
		//else
		//{
			$sql="select $sql_field from $tbl  ";
			$sql.=$sql_condition;
			if($group_flag==1)
			{
				$sql.=" group by ".$sql_group;
				$sql=substr($sql,0,strlen($sql)-1);
			}
			$result=mysqli_query($mysqli,$sql);
			$row['count']=mysqli_num_rows($result); 
		//}
		echo json_encode($row);
		exit;
		
	}
	if($query_type=='result_page')
	{
		echo "<table width=100%>";
		echo "<tr>
				<th>ID</th>
				<th>日期</th>
				<th>渠道业务</th>
				<th>省份</th>
				<th>消息总量</th>
				<th>Mo转发量</th>
				<th>Mr转发量</th>
				<th>总金额(元)</th>
				</tr>";
		//if(isset($_COOKIE['result_py'])&&$_COOKIE['result_py'] != 0)
		//{
		//	echo "<tr><td colspan=7>加载失败！</td></tr>"; 
			//print_r($output.'---output');
		//}
		//else
		//{
			//渠道业务
			$sql_cpProdID="select id,name from mtrs_cp_product";
			$result_cpProdID=exsql($sql_cpProdID);
			while($row_cpProdID=mysqli_fetch_row($result_cpProdID))
			{
				$row_cpProdIDs[]=$row_cpProdID;
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
			mysqli_query($mysqli,"set names utf8");
			if($result=mysqli_query($mysqli,$sql))
			{	$rows=array();
				while($row=mysqli_fetch_row($result))
				{
					$rows[]=$row;
				}
				$count_mo=0;//MO转发量
				$count_mt=0;//Mt转发量
				$amount_forward=0;//转发金额
				$msg_count_deduction=0;//扣量后消息总量

				$i=1;
				foreach($rows as $row)
				{
					echo "<tr align='center'>";
					echo "<th>".$i++."</th>";
					echo "<th>".$row[0]."</th>";

					//渠道业务$row_cpProdIDs
					$cpProdIDs=array(0=>'',1=>'');
					if($row[1]!='All'){
						foreach($row_cpProdIDs as $v){
							if($v[0]==$row[1]){
								$cpProdIDs=$v;
							}
						}
						echo "<th>".'('.$cpProdIDs[0].')'.$cpProdIDs[1]."</th>";
					}else{
						echo "<th>".$row[1]."</th>";
					}

					echo "<th>".$row[2]."</th>";
					echo "<td>".$row[6]."</td>";
					echo "<td>".$row[3]."</td>";
					echo "<td>".$row[4]."</td>";
					echo "<td>".number_format($row[5]/100,2)."</td>";
					echo "</tr>";

					$count_mo+=$row[3];//MO转发量
					$count_mt+=$row[4];//Mt转发量
					$amount_forward+=$row[5];//扣量后总金额
					$msg_count_deduction+=$row[6];//扣量后消息总量
				}
				//合计
			   echo "<tr align='center'>";
			   echo "<th>合计</th><th>--</th><th>--</th><th>--</th>";
			   echo "<td>$msg_count_deduction</td>";
				echo "<td>$count_mo</td>";
				echo "<td>$count_mt</td>";
				echo "<td>".number_format($amount_forward/100,2)."</td>";
			   echo "</tr>";
				//mysqli_free_result($result);
			}
		//}
		echo "</table>";
		
		
	}
