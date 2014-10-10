<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> </title>
<script language="Javascript" src="calendar/js/JQUERY.JS"></script>
<script Language="JavaScript">
$(document).ready(function(){	
	$("input[name='button']").click(function(){
		var phone_number = $("input[name='phone_number']").val();
		var mo_message = window.escape($("input[name='mo_message']").val()); 
		var spnumber = $("input[name='spnumber']").val(); 
		var linkid = $("input[name='linkid']").val(); 
		var gwid = $("select[name='gwid']").find("option:selected").val();
		if(phone_number!='' && mo_message !='' && spnumber !='' && gwid !=''){
			$.ajax({
				type: "GET",	
				url:"fake_mo_do.php?phone_number="+phone_number+"&mo_message="+mo_message+"&spnumber="+spnumber+"&linkid="+linkid+"&gwid="+gwid,
				cache:false, 
				success:function(result){
				if(result==1){
					alert("添加成功");
				}else{
					alert(result);
				}
			}});
		}else{
			alert("内容不完整，请补全信息");
		}		
	});	
	//随机数
	var Num="";
	for(var i=0;i<10;i++)
	{
		Num+=Math.floor(Math.random()*10);
	}
	$("input[name='linkid']").val(Num);
});

</script>
 </head>
 <body>
 <?php 
	include("check.php"); 
	include("style.php");
?>
<font size=4><caption>新增上行>></caption></font>
<br><br><br>

<form name='form' method=post action=# onsubmit="return check()">

<table>


<tr>
	<th>手机号码</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="phone_number" value="" size="30"/>
	</td>
</tr>

<tr>
	<th>上行内容</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="mo_message"  value="" size="30"/>
	</td>
</tr>

<tr>
	<th>目的号码</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="spnumber"  value="" size="30"/>
	</td>
</tr>

<tr>
	<th>linkid</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="linkid"  value="" size="30"/>
	</td>
</tr>

<tr>	
	<th> 来源网关 </th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name='gwid' style="width:170">
		<?php
			$sql= "select id,comment from wraith_gw where status=1";
			$result=exsql($sql);
			while($row=mysqli_fetch_row($result))
			{
				echo "<option value=$row[0]>($row[0])$row[1]</option>";
			}
		?>
		</select>
	</td>
</tr>
	
</table>
 <br>

 <input type='button' name="button" value="添加">
</form>
 </body>
</html>