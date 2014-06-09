<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
<script type="text/javascript" src="easyui/jquery.min.js"></script>
<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
 <script>
	$(document).ready(function(){
	$('#p').panel(); 
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
	
	})
	var int=self.setInterval("$('#p').panel('refresh')", 10000)

	});
</script>
<?php 
	include("check.php"); 
	include("style.php");
	$sql="select ID,sp_number,mo_cmd from mtrs_cmd";
	$result=exsql($sql);
	while($row=mysqli_fetch_row($result)){
		$rows[]=$row;
	}
?>
 </head>

 <body>
	<table width='100%'><tr><td>指令选择</td><td>
	  <?php
		foreach($rows as $row){
			echo "(".$row[0].")".$row[1]."+".$row[2]."<input type='checkbox' id='spID_group' name='cmd_ids' value='$row[0]'>&nbsp;&nbsp;&nbsp;";
		}
	  ?>
	  </td><td><button id=query type=button>查询</button></td></tr></table>

	<div id="p" style="padding:10px;">    
		<p>请选择监控的指令......</p>    
	</div>    
   

 </body>
</html>
