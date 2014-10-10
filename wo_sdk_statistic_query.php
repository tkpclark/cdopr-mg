<?php
	require_once 'mysql.php';
	
	$tbl="wraith_wo_sdk";
	
	$totalFee='';
	/***********condition***********/
	$sql_condition='where 1=1 ';
	if(isset($_REQUEST["query_type"]))
	{
		$query_type=$_REQUEST["query_type"];
	}
	if(isset($_REQUEST["date1"]))
	{	
		$date1 = str_replace("-","",$_REQUEST["date1"]).'000000';
		$sql_condition.="and timeStamp>='".$date1."' ";
	}
	if(isset($_REQUEST["date2"]) && $_REQUEST["date2"]!=date('Y-m-d',time()))
	{
		$date2 = str_replace("-","",$_REQUEST["date2"]).'235959';
		$sql_condition.="and timeStamp<='".$date2."' ";
	}
	if(isset($_REQUEST["totalFee"])&&!empty($_REQUEST["totalFee"]))
	{
		$totalFee=$_REQUEST["totalFee"];
		$sql_condition.="and totalFee='".$totalFee."' ";
	}

	$sql_condition.= " and timeStamp>='20140822000000' ";
	
	/**********result_info***************/
	if($query_type=='result_info')
	{	
			$sql="select count(id) from $tbl  ";
			$sql.=$sql_condition;
			$result=mysqli_query($mysqli,$sql);
			$row['count']=mysqli_num_rows($result); 
		echo json_encode($row);
		exit;
		
	}
	if($query_type=='result_page')
	{
		echo "<table width=100%>";
		echo "<tr>";
		if(isset($_COOKIE['role'])){
			if($_COOKIE['role']==12 || $_COOKIE['role']==1 || $_COOKIE['role']==13 || $_COOKIE['role']==8){
				echo "<th>全部总数量</th>";
				echo "<th>全部成功数量</th>";
				echo "<th>全部金额</th>";
			}
		}
				
				echo "<th>总数量</th>";
				echo "<th>成功数量</th>";
				echo "<th>金额</th>";
		echo "</tr><tr>";
				
		//全部总数量
		$sql="select count(id) from $tbl ";
		$sql.=$sql_condition;
		//echo $sql;exit;
		$result=mysqli_query($mysqli,$sql);
		$rows_q=mysqli_fetch_row($result);
		//总数量
		$sql="select count(id) from $tbl ";
		$sql.=$sql_condition;
		$sql.=" and forward_status='0' ";
		//echo $sql;exit;
		$result=mysqli_query($mysqli,$sql);
		$rows=mysqli_fetch_row($result);

		//全部成功量
		$sql="select count(id),sum(totalFee) from $tbl ";
		$sql.=$sql_condition;
		$sql.= " and status=4";
		$result=mysqli_query($mysqli,$sql);
		$suc_q=mysqli_fetch_row($result);
		//成功量
		$sql="select count(id),sum(totalFee) from $tbl ";
		$sql.=$sql_condition;
		$sql.= " and status=4";
		$sql.=" and forward_status='0' ";
		$result=mysqli_query($mysqli,$sql);
		$suc=mysqli_fetch_row($result);
		//echo $sql;exit;
		if(isset($_COOKIE['role'])){
			if($_COOKIE['role']==12 || $_COOKIE['role']==1 || $_COOKIE['role']==13 || $_COOKIE['role']==8){
				echo "<td>".(!empty($rows_q[0])?$rows_q[0]:'0')."</td>";
				echo "<td>".(!empty($suc_q[0])?$suc_q[0]:'0')."</td>";
				echo "<td>".(!empty($suc_q[1])?$suc_q[1]:'0')."</td>";
			}
		}

		echo "<td>".(!empty($rows[0])?$rows[0]:'0')."</td>";
		echo "<td>".(!empty($suc[0])?$suc[0]:'0')."</td>";
		echo "<td>".(!empty($suc[1])?$suc[1]:'0')."</td>";
			//$row=mysqli_fetch_row($result);
			

			
		echo "</tr></table>";
	}
?>
