<?php
	require_once 'mysql.php';
	$tbl="wraith_statistic";

	/***********condition***********/
	$sql_condition="where 1 ";
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
	$sql_field.=" sum(amount_deduction),sum(msg_count_deduction_suc)";

	



			//渠道
			$sql_cpID="select ID,cpname from mtrs_cp";
			$result_cpID=exsql($sql_cpID);
			while($row_cpID=mysqli_fetch_row($result_cpID))
			{
				$row_cpIDs[]=$row_cpID;
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
			//echo $sql;exit;

			mysqli_query($mysqli,"set names utf8");
			if($result=mysqli_query($mysqli,$sql))
			{	$rows=array();
				while($row=mysqli_fetch_row($result))
				{
					$rows[]=$row;
				}
				//导出
				$name=("渠道省份合计.xls");
				iconv("UTF-8", "GBK", $name);
				header("Content-Type: application/vnd.ms-excel;charset=GBK"); 
				header("Content-Disposition:attachment;filename=$name"); 
				foreach($row_cpIDs as $c)
				{	
					//渠道名
					echo iconv("UTF-8", "GBK","$c[1]\t\n");
					//表头
					 echo iconv("UTF-8", "GBK","省份\t");echo iconv("UTF-8", "GBK","条数\t");echo iconv("UTF-8", "GBK","金额\t\n");
					foreach($rows as $row)
					{
						if($c[0]==$row[3]){
							 echo iconv("UTF-8", "GBK",$row[8]."\t".$row[11]."\t".$row[10]."\t\n");
						}
						
					}
					echo iconv("UTF-8", "GBK","\t\n\t\n\t\n");
				}
			}
		
