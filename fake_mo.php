<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> </title>
<script language="Javascript" src="calendar/js/JQUERY.JS"></script>
<script Language="JavaScript">
$(document).ready(function(){	
	$("input[name='button']").click(function(){
		var phone_number = $("input[name='phone_number']").val();
		var mo_message = $("input[name='mo_message']").val(); 
		var spnumber = $("input[name='spnumber']").val(); 
		var linkid = $("input[name='linkid']").val(); 
		var gwid = $("input[name='gwid']").val();
		if(phone_number!='' && mo_message !='' && spnumber !='' && linkid !='' && gwid !=''){
			$.get("fake_mo_do.php?phone_number="+phone_number+"&mo_message="+mo_message+"&spnumber="+spnumber+"&linkid="+linkid+"&gwid="+gwid,function(result){
				if(result==1){
					alert("添加成功");
				}else{
					alert(result);
				}
			});
		}else{
			alert("内容不完整，请补全信息");
		}		
	});	
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
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="phone_number" value="" size="30"/>
	</th>
</tr>

<tr>
	<th>上行内容</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="mo_message"  value="" size="30"/>
	</th>
</tr>

<tr>
	<th>长号码</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="spnumber"  value="" size="30"/>
	</th>
</tr>

<tr>
	<th>linkid</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="linkid"  value="" size="30"/>
	</th>
</tr>

<tr>	
	<th> gwid </th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="gwid"  value="" size="30"/>
	</th>
</tr>
	
</table>
 <br>

 <input type='button' name="button" value="确定">
</form>
 </body>
</html>