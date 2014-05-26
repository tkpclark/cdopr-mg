<?php
	require_once 'mysql.php';
	
	$tbl="wraith_message_history";
	$tb2="wraith_message";
	
	
	/***********condition***********/
	$sql_condition="where 1 ";
	if(isset($_REQUEST["query_type"]))
	{
		$query_type=$_REQUEST["query_type"];
	}
	if(isset($_REQUEST["phone_number"])&&!empty($_REQUEST["phone_number"]))
	{
		$sql_condition.="and phone_number='".$_REQUEST["phone_number"]."' ";
	}
	if(isset($_REQUEST["date1"]))
	{
		$sql_condition.="and motime>='".$_REQUEST["date1"]."' ";
	}
	if(isset($_REQUEST["date2"]))
	{
		$sql_condition.="and motime<='".$_REQUEST["date2"]."' ";
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
	if(isset($_REQUEST["cpID"])&&!empty($_REQUEST["cpID"]))
	{
		$sql_condition.="and cpID='".$_REQUEST["cpID"]."' ";
	}
	if(isset($_REQUEST["cp_productID"])&&!empty($_REQUEST["cp_productID"]))
	{
		$sql_condition.="and cp_productID='".$_REQUEST["cp_productID"]."' ";
	}

	
	
	/**********result_info***************/
	if($query_type=='result_info')
	{
		$sql="select count(id) as count from $tbl  ";
		$sql.=$sql_condition;
		$result=mysqli_query($mysqli,$sql);
		$row1=mysqli_fetch_assoc($result);
		
		$sql="select count(id) as count from $tb2  ";
		$sql.=$sql_condition;
		$result1=mysqli_query($mysqli,$sql);
		$row2=mysqli_fetch_assoc($result1);

		$rows['count'] = $row1['count']+$row2['count'];

		echo json_encode($rows);
		exit;
		
	}
	if($query_type=='result_page')
	{
		echo "<table width=100%>";
		echo "<tr>
				<th>ID</th>
				<th>上行时间</th>
				<th>电话号码</th>
				<th>上行内容</th>
				<th>长号码</th>
				<th>来源网关</th>
				<th>mo状态</th>
				<th>资费(分)</th>
				<th>计费类型</th>
				<th>下行内容</th>
				<th>计费代码</th>
				<th>业务类型</th>
				<th>代计费</th>
				<th>状态报告</th>
				<th>归属省</th>
				<th>归属地</th>
				<th>通道</th>
				<th>通道业务</th>
				<th>渠道</th>
				<th>渠道业务</th>
				</tr>";
		
		$sql="select id,motime,phone_number,mo_message,sp_number,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,report,province,area,spID,spname,serviceID,service_name,cpID,cpname,cp_productID,cp_product_name from $tbl ";
		$sql.=$sql_condition;
		$sql.=" union all ";
		$sql.="select id,motime,phone_number,mo_message,sp_number,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,report,province,area,spID,spname,serviceID,service_name,cpID,cpname,cp_productID,cp_product_name from $tb2 ";
		$sql.=$sql_condition;
		$sql.=" order by id desc";
		$sql.=" limit ".$_REQUEST['pageSize']*($_REQUEST['pageNumber']-1).",".$_REQUEST['pageSize'];
		//echo $sql;exit;
		mysqli_query($mysqli,"set names utf8");
		if($result=mysqli_query($mysqli,$sql))
		{
			while($row=mysqli_fetch_assoc($result))
			{
				echo "<tr align='center'>";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['motime']."</td>";
				echo "<td>".$row['phone_number']."</td>";
				echo "<td>".$row['mo_message']."</td>";
				echo "<td>".$row['sp_number']."</td>";

				$sql_gw="select comment from wraith_gw where id=".$row['gwid'];
				$result_gw=exsql($sql_gw);
				$row_gw=mysqli_fetch_row($result_gw);
				echo "<td>".$row_gw['0']."</td>";

				echo "<td>".$row['mo_status']."</td>";
				echo "<td>".$row['fee']."</td>";
				echo "<td>".(($row['feetype']==1)?'按条点播':'包月')."</td>";
				echo "<td>".$row['mt_message']."</td>";
				echo "<td>".$row['service_id']."</td>";
				echo "<td>".(($row['msgtype']==1)?'自有普通业务':(($row['msgtype']==2)?'自有代码代计费业务 ':'外接代码代计费业务'))."</td>";
				echo "<td>".(($row['is_agent']==1)?'是':'否')."</td>";
				echo "<td>".(($row['report']==1)?'成功':'失败')."</td>";
				echo "<td>".$row['province']."</td>";
				echo "<td>".$row['area']."</td>";
				echo "<td>".$row['spID'].'-'.$row['spname']."</td>";
				echo "<td>".$row['serviceID'].'-'.$row['service_name']."</td>";
				echo "<td>".$row['cpID'].'-'.$row['cpname']."</td>";
				echo "<td>".$row['cp_productID'].'-'.$row['cp_product_name']."</td>";
				echo "</tr>";
			}
			mysqli_free_result($result);
		}
		echo "</table>";
		
		
	}
