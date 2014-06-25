<?php
	require_once 'mysql.php';
	$type=$_GET["type"];
	$id=$_GET["id"];
	$rows='<option value="">全部</option>';
	if($type=='sp')
	{	
		$sql="set names utf8";
		mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
		if($id != null){
		$sql="select ID,name,sp_number,mo_cmd from mtrs_service where spID=$id  ";
		}else{
			$sql="select ID,name,sp_number,mo_cmd from mtrs_service  ";
		}
		//echo $sql;
		$result=mysqli_query($mysqli,$sql);
		while($row=mysqli_fetch_assoc($result))
		{
			$rows.="<option value=".$row['ID'].">(".$row['ID'].")".$row['name']."-".$row['sp_number']."+".$row['mo_cmd']."</option>";
		}
		echo $rows;
		exit;
		
	}
	if($type=='cp'){
		$sql="set names utf8";
		mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
		if($id != null){
		$sql="select id,name from mtrs_cp_product where cpID=$id  ";
		}else{
			$sql="select id,name from mtrs_cp_product ";
		}
		//echo $sql;
		$result=mysqli_query($mysqli,$sql);
		while($row=mysqli_fetch_assoc($result))
		{
			$rows.="<option value=".$row['id'].">(".$row['id'].")".$row['name']."</option>";
		}
		echo $rows;
		exit;		
	}



?>