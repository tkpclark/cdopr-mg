<?php
	require_once 'mysql.php';
	
	$tbl="wraith_wo_sdk";
	

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
		$sql1 = "select * from wraith_wo_deduction where name='wo+sdk' and province='默认'";
		//echo $sql;
		$result=exsql($sql1);
		$deduction=mysqli_fetch_row($result);
		//print_r($deduction);
		(!empty($deduction['3']) && $deduction['3']!=0)?$up_deduction=number_format($deduction['3']/100,2):$up_deduction='';
		(!empty($deduction['4']) && $deduction['4']!=0)?$down_deduction=number_format($deduction['4']/100,2):$down_deduction='';

		echo "<table width=100%>";
		echo "<tr>
				<th>总数量</th>
				<th>成功数量</th>
			  </tr>";
		echo "<tr>";
		if(isset($_COOKIE['role'])){
			if($_COOKIE['role']==12||$_COOKIE['role']==1){
				$where = "";
			}else{
				
				$where = " and timeStamp>='20140703000000'";
			}
		}
		//总量
		$sql="select count(id) from $tbl ";
		$sql.=$sql_condition;
		$sql.=$where;
		//echo $sql;exit;
		if($result=mysqli_query($mysqli,$sql))
		{	
			$row=mysqli_fetch_row($result);
			if(isset($_COOKIE['role'])){
				if($_COOKIE['role']==12||$_COOKIE['role']==1){
					echo "<td>$row[0]</td>";
				}else{
					$success=intval($row[0]*$up_deduction);
					echo "<td>".$success."</td>";
				}
			}
			
			
		}
		//成功量
		$sql="select count(id) from $tbl ";
		$sql.=$sql_condition;
		$sql.= " and status=4";
		$sql.=$where;
		//echo $sql;exit;
		if($result=mysqli_query($mysqli,$sql))
		{	
			$row=mysqli_fetch_row($result);
			if(isset($_COOKIE['role'])){
				if($_COOKIE['role']==12||$_COOKIE['role']==1){
					echo "<td>$row[0]</td>";
				}else{
					echo "<td>".intval($success*$down_deduction)."</td>";
				}
			}
			
		}
		echo "</tr></table>";
	}
?>
