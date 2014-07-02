<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
        <script type="text/javascript" src="easyui/jquery.min.js"></script>
        <script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" src="jquery.chromatable.js"></script>
        <script>
        
		
        $(document).ready(function(){
            pageSize=50;

            function compose_url(query_type,pageNumber,pageSize){
                var url="";
                url += "statistic_query.php?";
                url += "&query_type="+query_type;
                url += "&products="+$("#products").val();
                url += "&date1="+$('#date1').datebox('getValue');
                url += "&date2="+$('#date2').datebox('getValue');
                url += "&pageSize="+pageSize;
                url += "&pageNumber="+pageNumber;
				url += "&feetype="+$("#feetype").val();
				url += "&gwid="+$("#gwid").val();
				url += "&province="+$("#province").val();
				url += "&spID="+$("#spID").val();
				url += "&serviceID="+$("#serviceID").val();
				url += "&cpid="+$("#cpID").val();
				url += "&cpProdID="+$("#cpProdID").val();
				url += "&is_agent="+$("#is_agent").val();
				url += "&cmdID="+$("#cmdID").val();
				//分组
				if($("#date_group").is(':checked')==true)
					url += "&date_group="+$("#date_group").val();
					url += "&date_type="+$("#date_type").val();

				if($("#spID_group").is(':checked')==true)
					url += "&spID_group="+$("#spID_group").val();

				if($("#serviceID_group").is(':checked')==true)
					url += "&serviceID_group="+$("#serviceID_group").val();
				
				if($("#cpID_group").is(':checked')==true)
					url += "&cpID_group="+$("#cpID_group").val();

				if($("#cpProdID_group").is(':checked')==true)
					url += "&cpProdID_group="+$("#cpProdID_group").val();

				if($("#is_agent_group").is(':checked')==true)
					url += "&is_agent_group="+$("#is_agent_group").val();

				if($("#feetype_group").is(':checked')==true)
					url += "&feetype_group="+$("#feetype_group").val();

				if($("#gwid_group").is(':checked')==true)
					url += "&gwid_group="+$("#gwid_group").val();

				if($("#province_group").is(':checked')==true)
					url += "&province_group="+$("#province_group").val();

				if($("#cmdID_group").is(':checked')==true)
					url += "&cmdID_group="+$("#cmdID_group").val();

                return url;
                
            }


            
            $('#pagination').pagination({
                pageSize:pageSize,
            	onSelectPage:function(pageNumber, pageSize){
                	/*
            		$(this).pagination('loading');
            		alert('pageNumber:'+pageNumber+',pageSize:'+pageSize);
            		$(this).pagination('loaded');
            		*/
            		$('#result_records').panel('refresh',compose_url('result_page',pageNumber,pageSize));
            	}
            });
        		
            //$('#result_records').panel('refresh',compose_url('result_page',pageNumber,pageSize));
        	var date= new Date(1);
			var date1= new Date(1);
    		$('#date1').datebox('setValue', yesterday(date1));
    		$('#date2').datebox('setValue', yesterday(date));
    		
			$("#query").click(function(){
				$.getJSON(compose_url('result_info',0), function(result){
					//alert(result.count);
					$("#result_info").text('总条数：'+result.count);

					$('#pagination').pagination('refresh',{	// change options and refresh pager bar information
						total: result.count
					});
					//$('#tab-head').append("<th>ID</th><th>日期</th><th>通道</th><th>通道业务</th><th>渠道</th><th>渠道业务</th><th>是否代计费业务</th><th>计费类型</th><th>网关</th><th>省份</th><th>指令</th><th>消息总量</th><th>合法消息总量</th><th>成功消息总量</th><th>成功百分比</th><th>结算后消息总量</th><th>结算后成功消息总量</th><th>结算百分比</th><th>成功计费金额</th><th>结算后金额</th><th>Mo转发量</th><th>Mr转发量</th></tr>");
					$('#result_records').panel('refresh',compose_url('result_page',1,pageSize));
				});
        	})

			

			
	


        })
        
		function change(type){ 
			var val = $("#"+type+"ID").val();
			  $.get("statistic_json.php", { type: type, id: val },
				  function(data){
					if(type=='sp'){
						$("#serviceID").html(data);
					}else{
						$("#cpProdID").html(data);
					}
				  });
		}
        </script>
<style>
#result_records{
 width:auto !important;
}
</style>
</head>
<body>



<?php 
	include("check.php"); 
	include("style.php");
	include("area_code.php");
?>

	
	
	<table width='100%'>
	 <tr><td>通道&nbsp;&nbsp;
 	<select id=spID onchange="change('sp')">
		<option value="">全部</option>
<?php
 	$sql="select ID,spname from mtrs_sp";
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{
 		echo "<option value=$row[0]>($row[0])$row[1]</option>";
 	}
?>
 	</select></td>

	<td>通道业务&nbsp;&nbsp;
 	<select id=serviceID>
		<option value="">全部</option>
<?php
 	$sql="select ID,name,sp_number,mo_cmd from mtrs_service";
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{
 		echo "<option value=$row[0]>($row[0])$row[1]-$row[2]+$row[3]</option>";
 	}
?>
 	</select></td>


	<td>渠道&nbsp;&nbsp;
 	<select id=cpID onchange="change('cp')">
		<option value="">全部</option>
<?php
 	$sql="select ID,cpname from mtrs_cp";
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{
 		echo "<option value=$row[0]>($row[0])$row[1]</option>";
 	}
?>
 	</select></td>

	<td>渠道业务&nbsp;&nbsp;
 	<select id=cpProdID>
		<option value="">全部</option>
<?php
 	$sql="select id,name from mtrs_cp_product";
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{
 		echo "<option value=$row[0]>($row[0])$row[1]</option>";
 	}
?>
 	</select></td>
	</tr>


	 <tr>
	 
	 <td>代计费业务&nbsp;&nbsp;
 	<select id=is_agent>
		<option value="">全部</option>
		<option value="2">是</option>
		<option value="1">否</option>
 	</select></td>
	 
	 <td>计费类型&nbsp;&nbsp;
 	<select id=feetype>
		<option value="">全部</option>
		<option value="1">点播 </option>
		<option value="2">包月</option>
 	</select></td>


	<td>网关&nbsp;&nbsp;
 	<select id=gwid>
		<option value="">全部</option>
<?php
 	$sql="select id,comment from wraith_gw where status=1";
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{
 		echo "<option value=$row[0]>($row[0])$row[1]</option>";
 	}
?>
 	</select></td>


	<td>所属省&nbsp;&nbsp;
 	<select id=province>
	<option value=''>全部</option>
<?php
		while($key = key($area_code))
		{
			echo "<option value='$area_code[$key]'>$area_code[$key]</option>";
			next($area_code);
		}
?>
 	</select></td>
	</tr>
	<tr>
 	<td>开始时间&nbsp;<input id="date1" type="text" class="easyui-datebox" data-options="formatter:myformatter" required="required" value=""></input></td>
 	<td>结束时间&nbsp;<input id='date2' type="text" class="easyui-datebox" data-options="formatter:myformatter" required="required" value=""></input></td>
 	<script type="text/javascript">
		function myformatter(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
		}

		function yesterday(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate()-1;
			return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
		}
		
		
	</script>
 		<td>指令&nbsp;&nbsp;
			<select id=cmdID>
				<option value="">全部</option>
				<?php
					$sql="select ID,sp_number,mo_cmd from mtrs_cmd";
					$result=exsql($sql);
					while($row=mysqli_fetch_row($result))
					{
						echo "<option value=$row[0]>($row[0])$row[1]+$row[2]</option>";
					}
				?>
			</select>
		</td>
	<td><button id=query type=button>查询</button></td>
 	</tr>
	<tr>
		<td colspan=4>
			<input type='checkbox' id="date_group" name='date_group' value="on">
			<select name='date_type' id="date_type"><option value='day'>日期分组</option><option value='hour'>小时分组</option></select>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="spID_group" name='spID_group' value="on" checked>通道分组&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="serviceID_group" name='serviceID_group' value="on" checked>通道业务分组&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="cpID_group" name='cpID_group' value="on" checked>渠道分组&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="cpProdID_group" name='cpProdID_group' value="on" checked>渠道业务分组&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="is_agent_group" name='is_agent_group' value="on" checked>代计费业务分组&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="feetype_group" name='feetype_group' value="on" checked>计费类型分组&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="gwid_group" name='gwid_group' value="on" checked>网关分组&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="province_group" name='province_group' value="on">省分组&nbsp;&nbsp;&nbsp;
			<input type='checkbox' id="cmdID_group" name='cmdID_group' value="on" checked>指令分组&nbsp;&nbsp;&nbsp;
		</td>
	</tr>

	</table>
	
 	
	
	<table width='100%'>
	<tr>
	 <td width=70%><div id="pagination" class="easyui-pagination" data-options="" style="border:1px solid #ddd;"></div></td>
	 <td id='result_info'></td>  
	</tr>
	</table>
	<div id='result_records' class='easyui-panel' style='width:auto !important'></div>'
	
</body>
</html>




