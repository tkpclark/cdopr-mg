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
	$sql="select ID,sp_number,mo_cmd,cpProdID from mtrs_cmd";
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
	  <?php
		$i=1;
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
		}
	  ?>
	  <tr><td colspan=5><button id=query type=button>查询</button></td></tr></table>

	<div id="p">    
		<p>请选择监控的指令......</p>    
	</div>    
   

 </body>
</html>
