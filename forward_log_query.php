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
		echo "<table width=100%>";
		echo "<tr>
				<th>ID</th>
				<th>上行时间</th>
				<th>电话号码</th>
				<th>渠道</th>
				<th>渠道业务</th>
				<th>mo状态</th>
				<th>代计费</th>
				<th>状态报告</th>
				<th>原始状态报告</th>
				<th>原始状态时间</th>
				<th>转发过程</th>
				<th>mo转发时间</th>
				<th>mo转发状态</th>
				<th>mo转发应答</th>
				<th>mo转发的实际url</th>
				<th>mr转发时间</th>
				<th>mr转发状态</th>
				<th>mr转发应答</th>
				<th>mr转发的实际url</th>
				</tr>";

		
		$sql="select id,motime,phone_number,mo_status,is_agent,report,report_orig,report_time,cpID,cpname,cp_productID,cp_product_name,forward_status,forward_mo_time,forward_mo_result,forward_mo_resp,forward_mo_url,forward_mr_time,forward_mr_result,forward_mr_resp,forward_mr_url from $tb ";
		$sql.=$sql_condition;
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
				echo "<td>".$row['phone_number']."</td>";
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

				//mo状态
				$v=$row['mo_status']?$row['mo_status']:'待处理';
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

				echo "<td>".$row['report_orig']."</td>";
				echo "<td>".$row['report_time']."</td>";

				//转发过程0：没转过 1：转过上行 2：转过下行 3：转过整条 4：上行被扣量  5： 报告被扣量 6：转发mo失败 7：转发mr失败
				switch ($row['forward_status'])
				{
				case 0: echo "<td>没转过</td>";
				  break;  
				case 1: echo "<td>转过上行</td>";
				  break;
				case 2: echo "<td>转过下行</td>";
				  break;
				case 3: echo "<td>转过整条</td>";
				  break;
				case 4: echo "<td>上行被扣量</td>";
				  break;
				case 5: echo "<td>报告被扣量</td>";
				  break;
				case 6: echo "<td>转发mo失败</td>";
				  break;
				case 7: echo "<td>转发mr失败</td>";
				  break;
				default: echo "<td></td>";
				}

				echo "<td>".$row['forward_mo_time']."</td>";

				//mo转发状态1:成功 2：失败 3：超时
				if($row['forward_mo_result']==1) $v='成功';
				elseif ($row['forward_mo_result']==2) $v='失败';
				elseif ($row['forward_mo_result']==3) $v='超时';
				else $v='';
				echo "<td>".$v."</td>";

				echo "<td>".$row['forward_mo_resp']."</td>";
				echo "<td>".$row['forward_mo_url']."</td>";
				echo "<td>".$row['forward_mr_time']."</td>";

				//mr转发状态1:成功 2：失败 3：超时
				if($row['forward_mr_result']==1) $v='成功';
				elseif ($row['forward_mr_result']==2) $v='失败';
				elseif ($row['forward_mr_result']==3) $v='超时';
				else $v='';
				echo "<td>".$v."</td>";

				echo "<td>".$row['forward_mr_resp']."</td>";
				echo "<td>".$row['forward_mr_url']."</td>";




					
				echo "</tr>";
			}
			mysqli_free_result($result);
		}
		echo "</table>";
		
		
	}
