<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
<script type="text/javascript" src="easyui/jquery.min.js"></script>
<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
<script src="jquery.blockUI.js" type="text/javascript"></script>
 <script>
	$(document).ready(function(){
	$('#p').panel({loadingMessage:null}); 
	$("#query").click(function(){
		var url='monitoring_query.php?cmd_ids=';
		var a ='';
		 $("input[type='checkbox']").each(function(e){
			if(this.checked){
				url+=this.value+','
			}
		 });

		$('#p').panel({ 
			href:url,
			
		}); 
		$('#tb').hide(); 
	
	})
	var int=self.setInterval("$('#p').panel('refresh')", 10000);

	});
</script>
<style>
#p{
 width:auto !important;
}
</style>
<?php 
	include("check.php"); 
	include("style.php");
	//检索通道
	$where=" 1";
	if($_COOKIE['role']==16){
		$_POST['spID']=23;
	}
	if(isset($_POST['spID']) && !empty($_POST['spID'])){
		$sql="select id from mtrs_service where spID=".$_POST['spID'];
		$result=exsql($sql);
		while($row=mysqli_fetch_row($result))
		{
			$sp_pro[]=$row[0];
		}
		$where .= " and serviceID in (".implode(',',$sp_pro).")";
	}

	if(isset($_POST['cpID']) && !empty($_POST['cpID'])){
		$sql="select id from mtrs_cp_product where cpID=".$_POST['cpID'];
		$result=exsql($sql);
		while($row=mysqli_fetch_row($result))
		{
			$cp_pro[]=$row[0];
		}
		$where .= " and cpProdID in (".implode(',',$cp_pro).")";
	}

	$sql="select ID,sp_number,mo_cmd,cpProdID from mtrs_cmd where ".$where;
	//echo $sql;
	$result=exsql($sql);
	while($row=mysqli_fetch_row($result)){
		$rows[]=$row;
	}
	$sql = "select t1.id,t1.`name`,t2.ID,t2.cpname from mtrs_cp_product t1,mtrs_cp t2 where t1.cpID=t2.ID";
	$result = exsql($sql);
	while($row=mysqli_fetch_row($result)){
		$cp_rows[]=$row;
	}
?>
 </head>

 <body>
	<table width='100%' id='tb'><tr><td colspan=5>指令选择</td></tr>
	<form name=pn_inq action="monitoring.php" method=post>
	<tr>
	<td  colspan=5>通道<select name='spID'>
		<?php
			if($_COOKIE['role']!=16){echo "<option value=''>全部</option>";}
			$sql="select ID,spname from mtrs_sp";
			if($_COOKIE['role']==16){
				$sql="select ID,spname from mtrs_sp where id=23";
			}
			$result=exsql($sql);
			while($row=mysqli_fetch_row($result))
			{	
				if(isset($_POST['spID']) && !empty($_POST['spID']) && $_POST['spID']==$row[0]){
					echo "<option value=$row[0] selected>($row[0])$row[1]</option>";
				}else{
					echo "<option value=$row[0]>($row[0])$row[1]</option>";
				}
				
			}
		?>
		</select>
	
	渠道<select name='cpID'>
		<option value=''>全部</option>
		<?php
			$sql="select ID,cpname from mtrs_cp";
			$result=exsql($sql);
			while($row=mysqli_fetch_row($result))
			{	
				if(isset($_POST['cpID']) && !empty($_POST['cpID']) && $_POST['cpID']==$row[0]){
					echo "<option value=$row[0] selected>($row[0])$row[1]</option>";
				}else{
					echo "<option value=$row[0]>($row[0])$row[1]</option>";
				}
				
			}
		?>
		</select><input type=submit name=submit value=查询></td>

	</tr></form>
	  <?php
		$i=1;
		if(isset($rows) && !empty($rows)){
		foreach($rows as $row){
			if($i==1){echo "<tr>";}
			echo "<td>";
			foreach($cp_rows as $cp){
				if($cp[0]==$row[3]){
					echo "(".$cp[2].")".$cp[3]."--(".$cp[0].")".$cp[1];
				}
			}
			echo "<br>(".$row[0].")".$row[1]."+".$row[2]."<br><input type='checkbox' id='spID_group' name='cmd_ids' value='$row[0]'>";
			echo "</td>";
			if(($i%5)==0 && $i!=1){echo "</tr></tr>";}
			$i++;
		}}
	  ?>
	  <tr><td colspan=5><button id=query type=button>查询</button></td></tr></table>

	<div id="p">    
		<p>请选择监控的指令......</p>    
	</div>    
   

 </body>
</html>
