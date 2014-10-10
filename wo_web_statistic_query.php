<?php
	require_once 'mysql.php';
	$role = @$_COOKIE["role"];
	$tbl="wraith_wo_web_statistic";
	

	/***********condition***********/
	$sql_condition='where 1=1 ';

	if(isset($_REQUEST["query_type"]))
	{
		$query_type=$_REQUEST["query_type"];
	}
	if(isset($_REQUEST["date1"]) && !empty($_REQUEST["date1"]) )
	{
		$sql_condition.=" and stat_time>='".$_REQUEST["date1"].":00' ";
	}
	if(isset($_REQUEST["date2"]) && $_REQUEST["date2"]!=date('Y-m-d',time()))
	{
		$sql_condition.=" and stat_time<='".$_REQUEST["date2"].":23:59' ";
	}


	if(isset($_REQUEST["province"])&&!empty($_REQUEST["province"]))
	{
		$sql_condition.=" and province='".$_REQUEST["province"]."' ";
	}
	if(isset($_REQUEST["price"])&&!empty($_REQUEST["price"]))
	{
		$sql_condition.=" and price='".$_REQUEST["price"]."' ";
	}	
	if(isset($_REQUEST["ditchId"])&&!empty($_REQUEST["ditchId"]))
	{
		$sql_condition.=" and ditchId='".$_REQUEST["ditchId"]."' ";
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

	if(isset($_REQUEST['price_group']) && $_REQUEST['price_group']=="on")
	{
		$group_flag=1;
		$sql_field.="price, ";
		$sql_group.="price,";
	}
	else
	{
		$sql_field.="'All', ";
	}
	if(isset($_REQUEST['ditchId_group']) && $_REQUEST['ditchId_group']=="on")
	{
		$group_flag=1;
		$sql_field.="ditchId, ";
		$sql_group.="ditchId,";
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
	$sql_field.=" sum(msg_count_all),sum(msg_count_suc),sum(amount_suc),sum(msg_count_forward_mr),sum(amount_forward)";

	
	
	/**********result_info***************/
	if($query_type=='result_info')
	{	
			$sql="select $sql_field from $tbl  ";
			$sql.=$sql_condition;
			if($group_flag==1)
			{
				$sql.=" group by ".$sql_group;
				$sql=substr($sql,0,strlen($sql)-1);
			}
			$result=mysqli_query($mysqli,$sql);
			//$row['count']=mysqli_num_rows($result); 
		//echo json_encode($row);
		echo 1;
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
		echo "<table width=100% id='yourTableID2'>";
		echo "<thead><tr>";
				echo "<th>ID</th>";
				echo "<th>日期</th>";
				echo "<th>价格</th>";
				echo "<th>渠道</th>";
				echo "<th>省份</th>";
				if($role!=18){
				echo "<th>消息总量</th>";
				echo "<th>成功消息总量</th>";
				echo "<th>成功计费总金额</th>";
				}
				echo "<th>成功消息量</th>";
				echo "<th>成功消息金额</th>";
				echo "</tr></thead>";


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
				$count_msg_count_all=0;
				$count_msg_count_suc=0;
				$count_amount_suc=0;
				$count_msg_count_forward_mr=0;
				$count_amount_forward=0;


				$i=1;
				foreach($rows as $row)
				{	
					//print_r($row);
					echo "<tr align='center'>";
					echo "<th>".$i++."</th>";
					echo "<th>".$row[0]."</th>";
					echo "<th>".$row[1]."</th>";
					echo "<th>".$row[2]."</th>";
					echo "<th>".$row[3]."</th>";
					if($role!=18){
						echo "<td>".$row[4]."</td>";
						echo "<td>".$row[5]."</td>";
						echo "<td>".number_format($row[6],2)."</td>";
					}
					echo "<td>".$row[7]."</td>";
					echo "<td>".number_format($row[8],2)."</td>";
					echo "</tr>";

					$count_msg_count_all+=$row[4];
					$count_msg_count_suc+=$row[5];
					$count_amount_suc+=$row[6];
					$count_msg_count_forward_mr+=$row[7];
					$count_amount_forward+=$row[8];
				}
				//合计
			   echo "<tr align='center'>";
			   echo "<th>合计</th><th>--</th><th>--</th><th>--</th><th>--</th>";
			   if($role!=18){
			   echo "<td>$count_msg_count_all</td>";
				echo "<td>$count_msg_count_suc</td>";
				echo "<td>".number_format($count_amount_suc,2)."</td>";
			   }
				echo "<td>$count_msg_count_forward_mr</td>";
				echo "<td>".number_format($count_amount_forward,2)."</td>";
			   echo "</tr>";
				//mysqli_free_result($result);
			}
		//}
		echo "</table>";
		
		
	}
