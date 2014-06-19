<?php
	require_once 'mysql.php';
	
	$tb="wraith_message_complaint";
	
	
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
	if(isset($_REQUEST["date1"]) && $_REQUEST["date1"]!='1970-01-01')
	{
		$sql_condition.="and motime>='".$_REQUEST["date1"]."' ";
	}
	if(isset($_REQUEST["date2"]) && $_REQUEST["date2"]!=date('Y-m-d',time()))
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
	if(isset($_REQUEST["cmdID"])&&!empty($_REQUEST["cmdID"]))
	{
		$sql_condition.="and cmdID='".$_REQUEST["cmdID"]."' ";
	}

	
	
	/**********result_info***************/
	if($query_type=='result_info')
	{
		$sql="select count(id) as count from $tb  ";
		$sql.=$sql_condition;
		$result=mysqli_query($mysqli,$sql);
		$row1=mysqli_fetch_assoc($result);
		
		/*
		$sql="select count(id) as count from $tb2  ";
		$sql.=$sql_condition;
		$result1=mysqli_query($mysqli,$sql);
		$row2=mysqli_fetch_assoc($result1);
		

		$rows['count'] = $row1['count']+$row2['count'];
		*/
		echo json_encode($row1);
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
				<th>指令</th>
				<th>投诉内容</th>
				<th>需给用户回复的内容</th>
				<th>处理结果</th>
				<th>退费方式</th>
				<th>退费时间</th>
				<th>退费结果</th>
				<th>退费联系电话</th>
				<th>联通工号</th>
				<th>客服工号</th>
				<th>操作</th>
				</tr>";
		
		$sql="select id,motime,phone_number,mo_message,sp_number,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,report,province,area,spID,spname,serviceID,service_name,cpID,cpname,cp_productID,cp_product_name,cmdID,
		complaint_content,reply_content,complaint_result,refund_form,refund_time,refund_result,refund_phone,unicom_number,customer_service_number
		from $tb ";
		$sql.=$sql_condition;
		/*
		$sql.=" union all ";
		$sql.="select id,motime,phone_number,mo_message,sp_number,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,report,province,area,spID,spname,serviceID,service_name,cpID,cpname,cp_productID,cp_product_name,cmdID from $tb2 ";
		$sql.=$sql_condition;
		*/
		$sql.=" order by id desc";
		$sql.=" limit ".$_REQUEST['pageSize']*($_REQUEST['pageNumber']-1).",".$_REQUEST['pageSize'];
		//echo $sql;exit;
		mysqli_query($mysqli,"set names utf8");
		if($result=mysqli_query($mysqli,$sql))
		{	
			//指令表
			$sql_cmdID="select ID,sp_number,mo_cmd from mtrs_cmd";
			$result_cmdID=exsql($sql_cmdID);
			while($row_cmdID=mysqli_fetch_row($result_cmdID))
			{
				$row_cmdIDs[]=$row_cmdID;
			}
			$count=0;
			while($row=mysqli_fetch_assoc($result))
			{
				echo "<tr align='center'>";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['motime']."</td>";
				echo "<td>".$row['phone_number']."</td>";
				echo "<td>".$row['mo_message']."</td>";
				echo "<td>".$row['sp_number']."</td>";

				//网关
				$sql_gw="select comment from wraith_gw where id=".$row['gwid'];
				$result_gw=exsql($sql_gw);
				$row_gw=mysqli_fetch_row($result_gw);
				echo "<td>".$row_gw['0']."</td>";
				//mo状态
				$v=$row['mo_status']?$row['mo_status']:'待处理';
				echo "<td>".$v."</td>";
				
				//资费
				$v = $row['fee']==-1?'':$row['fee'];
				echo "<td>".$v."</td>";
				
				//包月、点播
				if($row['feetype']==1) $v='按条点播';
				elseif ($row['feetype']==2) $v='包月';
				else $v='';
				echo "<td>".$v."</td>";
				
				//下行
				echo "<td>".$row['mt_message']."</td>";
				
				//计费代码
				echo "<td>".$row['service_id']."</td>";
				
				//msgtype
				if($row['msgtype']==1) $v='sms';
				elseif ($row['msgtype']==2) $v='mms';
				else $v='';
				echo "<td>".$v."</td>";
				
				//是否代计费
				if($row['is_agent']==1) $v='否';
				elseif ($row['is_agent']==2) $v='是';
				else $v='';
				echo "<td>".$v."</td>";
				
				//状态报告
				if($row['report']==1) $v='成功';
				elseif ($row['report']==2) $v='失败';
				else $v='';
				echo "<td>".$v."</td>";
				
				//归属省份
				echo "<td>".$row['province']."</td>";
				
				//归属地
				echo "<td>".$row['area']."</td>";

				//通道
				if($row['spID'])
					$v='('.$row['spID'].')'.$row['spname'];
				else
					$v='';	
				echo "<td>".$v."</td>";
				
				//通道业务
				if($row['serviceID'])
					$v='('.$row['serviceID'].')'.$row['service_name'];
				else
					$v='';
				echo "<td>".$v."</td>";
				
				//渠道
				if($row['cpID'])
					$v='('.$row['cpID'].')'.$row['cpname'];
				else
					$v='';
				echo "<td>".$v."</td>";
				
				//渠道业务
				if($row['cp_productID'])
					$v='('.$row['cp_productID'].')'.$row['cp_product_name'];
				else
					$v='';
				echo "<td>".$v."</td>";
				

				//指令
				$cmdIDs=array(0=>'',1=>'',2=>'');
				foreach($row_cmdIDs as $v){
					if($v[0]==$row['cmdID']){
						$cmdIDs=$v;
					}
				}
				echo "<td>".'('.$cmdIDs[0].')'.$cmdIDs[1].'+'.$cmdIDs[2]."</td>";
				
				echo "<td>$row[complaint_content]</td>";
				echo "<td>$row[reply_content]</td>";
				echo "<td>".(($row['complaint_result'])==1?"已受理":"已处理")."</td>";
				echo "<td>$row[refund_form]</td>";
				echo "<td>$row[refund_time]</td>";
				echo "<td>$row[refund_result]</td>";
				echo "<td>$row[refund_phone]</td>";
				echo "<td>$row[unicom_number]</td>";
				echo "<td>$row[customer_service_number]</td>";
				echo "<td><a href='message_complaint_edit.php?id=$row[id]'>编辑</td>";
				echo "</tr>";
				$count+=$row['fee'];
			}
			echo "<tr><td colspan=29></td><td>总计</td><td>$count</td></tr>";
			mysqli_free_result($result);
		}
		echo "</table>";
		
		
	}
