
<?php
	require_once 'mysql.php';
	
	$tb="wraith_message_complaint";
		
	
	/***********condition***********/
	$sql_condition="where 1 ";
	if(isset($_REQUEST["query_type"]))
	{
		$query_type=$_REQUEST["query_type"];
	}
	if(isset($_REQUEST["date1"]) && !empty($_REQUEST["date1"]))
	{
		$sql_condition.="and complaint_time>='".$_REQUEST["date1"]."' ";
	}
	if(isset($_REQUEST["date2"]) && $_REQUEST["date2"]!=date('Y-m-d',time()))
	{
		$sql_condition.="and complaint_time<='".$_REQUEST["date2"].":23:59' ";
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
				<th>渠道</th>
				<th>用户数</th>
				</tr></thead><tbody>";
		
		$sql="SELECT COUNT(DISTINCT(phone)) as count,cpname FROM $tb ";
		$sql.=$sql_condition;
		/*
		$sql.=" union all ";
		$sql.="select id,motime,phone_number,mo_message,sp_number,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,report,province,area,spID,spname,serviceID,service_name,cpID,cpname,cp_productID,cp_product_name,cmdID from $tb2 ";
		$sql.=$sql_condition;
		*/
		//$sql.=" order by id desc";
		//$sql.=" limit ".$_REQUEST['pageSize']*($_REQUEST['pageNumber']-1).",".$_REQUEST['pageSize'];
		$sql.="  GROUP BY cpname";
		//echo $sql;exit;
		mysqli_query($mysqli,"set names utf8");
		if($result=mysqli_query($mysqli,$sql))
		{	

			while($row=mysqli_fetch_assoc($result))
			{
				echo "<tr align='center'>";
				echo "<td>".$row['cpname']."</td>";
				echo "<td>".$row['count']."</td>";	
				echo "</tr>";
			}
			mysqli_free_result($result);
		}
		echo "</tbody></table>";
		
		
	}
