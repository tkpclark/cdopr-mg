<script Language="JavaScript">
function check()
{
	if(document.cp_channel_edit_form.deduction.value=="")
  {
     	   alert("请填写扣量比例!");
     	   document.cp_channel_edit_form.deduction.focus();
     	   return false;
	}
	
	if(document.cp_channel_edit_form.deduction.value > 100 || document.cp_channel_edit_form.deduction.value < 0)
	{
     	   alert("请填写1-100之间的数字!");
     	   document.cp_channel_edit_form.deduction.focus();
     	   return false;
	}
}
</script>
<?php 
	include("check.php"); 
	include("style.php");
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
				
		$sql = "select spname,status,sp_id from mtrs_sp where id=$id";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$sp_name=$row[0];
		$sp_status=$row[1];
		$sp_id=$row[2];
	}
	else
	{
		$sp_name="";
		$sp_status="1";
		$sp_id="";
	}
?>

<font size=4><caption>SP信息编辑>></caption></font>
<br><br><br>

<body>
<form name=sp_edit_form method=post action=sp_edit_do.php<?php if(isset($id)) echo "?spID=$id"; ?> onsubmit='return check()'>

<table border='1' cellspacing='0' cellpadding='1' width='25%' class='tabs'>
<?php
if(isset($id))
{
	echo "<tr><th>ID</th><td align='center'>$sp_id</td></tr>";
}
?>
<tr>
	<th>SP名称&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='spname' value='<?php echo $sp_name?>' size='30'/>
	</td>
</tr>

<tr>
	<th>企业代码&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='sp_id' value='<?php echo $sp_id?>' size='30'/>
	</td>
</tr>

<tr>	
	<th> 状态 </th>
	<td align='center'>
		正常<input type=radio name=status value=1 <?php if($sp_status==1) echo "checked=\"checked\""?>/> 
		关闭<input type=radio name=status value=2 <?php if($sp_status==2) echo "checked=\"checked\""?>/> 
	</td>
</tr>
	
</table>
 <br>

 <input type=submit name='submit' value='确定'>
</form>
