
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
        <script type="text/javascript" src="easyui/jquery.min.js"></script>
        <script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
        <script>
        
		
        $(document).ready(function(){
            pageSize=20;

            function compose_url(query_type,pageNumber,pageSize){
                var url="";
                url += "forward_log_query.php?tb=<?php echo $_REQUEST['tb'];?>";
                url += "&query_type="+query_type;
                url += "&phone_number="+$("#phone_number").val();
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
				url += "&cp_productID="+$("#cp_productID").val();
				url += "&cmdID="+$("#cmdID").val();
				url += "&report="+$("#report").val();

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
			<?php
				if($_REQUEST['tb']==2){
			?>
				var date= new Date();
        	<?php
			}
			?>
			
    		$('#date1').datebox('setValue', yesterday(date));
    		$('#date2').datebox('setValue', yesterday(date));
    		
			$("#query").click(function(){
				$.getJSON(compose_url('result_info',0), function(result){
					//alert(result.count);
					$("#result_info").text('总条数：'+result.count);

					$('#pagination').pagination('refresh',{	// change options and refresh pager bar information
						total: result.count
					});

					$('#result_records').panel('refresh',compose_url('result_page',1,pageSize));
				});
        	})

			 

        })
        
		function change(type){ 
			var val = $("#"+type+"ID").val();
			  $.get("forward_log_json.php", { type: type, id: val },
				  function(data){
					if(type=='sp'){
						$("#serviceID").html(data);
					}else{
						$("#cp_productID").html(data);
					}
				  });
		}
        </script>
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
 	$sql="select ID,name from mtrs_service";
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{
 		echo "<option value=$row[0]>($row[0])$row[1]</option>";
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
 	<select id=cp_productID>
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


	 <tr><td>计费类型&nbsp;&nbsp;
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
 		echo "<option value=$row[0]>$row[1]</option>";
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
	<?php
		if($_REQUEST['tb']==1){
	?>
		<script type="text/javascript">
			$('#date1').datebox({    
				disabled:true   
			}); 
			$('#date2').datebox({    
				disabled:true   
			}); 
		</script>
	<?php
		}
	?>
 	<td>手机号码<input id=phone_number name=phone_number type=text value='' /></td>
	<td>状态<select id=report ><option value="">全部</option><option value="1">成功</option><option value="2">失败</option><option value="3">等待mr</option></select></td>
 	</tr>
	<tr><td colspan=4><button id=query type=button>查询</button></td></tr>
	</table>
	
 	
	
	<table width='100%'>
	<tr>
	 <td width=70%><div id="pagination" class="easyui-pagination" data-options="" style="border:1px solid #ddd;"></div></td>
	 <td id='result_info'></td>  
	</tr>
	</table>
	<div id='result_records' class='easyui-panel' style='height:500px'></div>'
	
</body>
</html>




