<?php
	require_once 'mysql.php';
	
	if(!isset($_REQUEST['tb']))
	{
		echo "need tb argument!";
		exit;
	}
	if($_REQUEST['tb']=='1')
		$tb="wraith_message";
	elseif($_REQUEST['tb']=='2')
		$tb="wraith_message_history";
	else{
		echo "tb argument error!";
		exit;
	}
	
	
	
	/***********condition***********/
	$sql_condition="where 1 ";
	if(isset($_REQUEST["query_type"]))
	{
		$query_type=$_REQUEST["query_type"];
	}
	if(isset($_REQUEST["phone_number"])&&!empty($_REQUEST["phone_number"]))
	{	
		if($_COOKIE['role']==16){$_REQUEST["phone_number"]=md5($_REQUEST["phone_number"]."Linktech");}
		$sql_condition.="and phone_number='".$_REQUEST["phone_number"]."' ";
	}
	if(isset($_REQUEST["date1"]) && !empty($_REQUEST["date1"]))
	{
		$sql_condition.="and motime>='".$_REQUEST["date1"]."' ";
	}
	if(isset($_REQUEST["date2"]) && $_REQUEST["date2"]!=date('Y-m-d',time()))
	{
		$sql_condition.="and motime<='".$_REQUEST["date2"].":23:59' ";
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
	if(isset($_REQUEST["cp_productID"])&&!empty($_REQUEST["cp_productID"]))
	{
		$sql_condition.="and cp_productID='".$_REQUEST["cp_productID"]."' ";
	}
	if(isset($_REQUEST["cmdID"])&&!empty($_REQUEST["cmdID"]))
	{
		$sql_condition.="and cmdID='".$_REQUEST["cmdID"]."' ";
	}
	if(isset($_REQUEST["report"])&&!empty($_REQUEST["report"]))
	{	if($_REQUEST["report"]==3){
			$sql_condition.="and ISNULL(report) ";
		}else{
			$sql_condition.="and report='".$_REQUEST["report"]."' ";
		}	
	}

	
	
	/**********result_info***************/
	if($query_type=='result_info')
	{	
		$sql="set names utf8";
		exsql($sql);
		$sql="select count(*) as count from $tb  ";
		$sql.=$sql_condition;
		$result=mysqli_query($mysqli,$sql);
		$row=mysqli_fetch_assoc($result);
		echo json_encode($row);
		exit;
		
	}
	if($query_type=='result_page')
	{	
		echo '<script>$(document).ready(function(){
				$("#yourTableID2").chromatable({
						width: "100%",
						height: "400px",
						scrolling: "yes"
					})});</script>';

		echo "<table width=100%  id='yourTableID2'>";
		echo "<thead><tr>
				<th>ID</th>
				<th>上行时间</th>
				<th>电话号码</th>
				<th>上行内容</th>
				<th>长号码</th>
				<th>来源网关</th>
				<th>mo状态</th>
				<th>资费(元)</th>
				<th>计费类型</th>
				<th>下行内容</th>
				<th>计费代码</th>
				<th>业务类型</th>
				<th>状态报告</th>
				<th>归属省</th>
				<th>归属地</th>
				<th>通道</th>
				<th>通道业务</th>
				<th>渠道</th>
				<th>渠道业务</th>
				<th>代计费</th>
				<th>指令</th>
				</tr></thead><tbody>";
		
		$sql="select id,motime,phone_number,mo_message,sp_number,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,report,province,area,spID,spname,serviceID,service_name,cpID,cpname,cp_productID,cp_product_name,cmdID from $tb ";
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

			while($row=mysqli_fetch_assoc($result))
			{
				echo "<tr align='center'>";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['motime']."</td>";
				echo "<td>".substr($row['phone_number'],0,11)."</td>";
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
				echo "<td>".number_format($v/100,2)."</td>";
				
				//包月、点播
				if($row['feetype']==1) $v='按条点播';
				elseif ($row['feetype']==2) $v='包月';
				elseif ($row['feetype']==3) $v='包月话单';
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
				
				//是否代计费
				if($row['is_agent']==1) $v='否';
				elseif ($row['is_agent']==2) $v='是';
				else $v='';
				echo "<td>".$v."</td>";

				//指令
				$cmdIDs=array(0=>'',1=>'',2=>'');
				foreach($row_cmdIDs as $v){
					if($v[0]==$row['cmdID']){
						$cmdIDs=$v;
					}
				}
				echo "<th>".'('.$cmdIDs[0].')'.$cmdIDs[1].'+'.$cmdIDs[2]."</th>";
					
				echo "</tr>";
			}
			mysqli_free_result($result);
		}
		echo "</tbody></table>";
		
		
	}
