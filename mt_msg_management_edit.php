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
				
		$sql = "select * from wraith_mt_msg_management where id=$id";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$message=$row[1];
		$serviceID=$row[2];
		$msgtype=$row[3];
	}
	else
	{
		$message='';
		$serviceID='';
		$msgtype='';
	}
?>

<font size=4><caption>下发语编辑>></caption></font>
<br><br><br>

<body>
<form name=sp_edit_form method=post action=mt_msg_management_edit_do.php<?php if(isset($id)) echo "?id=$id"; ?> onsubmit='return check()'>

<table border='1' cellspacing='0' cellpadding='1' width='25%' class='tabs'>
<?php
if(isset($id))
{
	echo "<tr><th>ID</th><td align='center'>$id</td></tr>";
}
?>
<tr>
	<th>下发语&nbsp;&nbsp;</th>
	<td align='center'>
		<textarea name=message cols=33 rows=5><?php echo $message?></textarea>
	</td>
</tr>

<tr>
	<th>通道业务&nbsp;&nbsp;</th>
	<td align='center'>
		<select name=serviceID  style="width:300">
		<?php
			$sql="select t1.id, t1.sp_number, t1.mo_cmd,t1.name,t2.id,t2.spname from mtrs_service t1, mtrs_sp t2 where t1.status=1 and t1.spID=t2.id";
			
			$result=exsql($sql);
		  	while($row=mysqli_fetch_row($result))
		  	{
		  		if($row[0]==$serviceID)
		  			echo "<option value=$row[0]>($row[4])$row[5] ($row[0])$row[3] $row[1]+$row[2] </option>";
		  	}
		  	$result=exsql($sql);
		  	while($row=mysqli_fetch_row($result))
		  	{
		  		if($row[0]!=$serviceID)
		  			echo "<option value=$row[0]>($row[4])$row[5] ($row[0])$row[3] $row[1]+$row[2] </option>";
		  	}
		?>
		</select>
	</td>
</tr>

<tr>	
	<th> 类型 </th>
	<td align='center'>
		sp下发语<input type=radio name=msgtype value=1 <?php if($msgtype==1) echo "checked=\"checked\""?>/> 
		运营商下发语<input type=radio name=msgtype value=2 <?php if($msgtype==2) echo "checked=\"checked\""?>/> 
	</td>
</tr>
	
</table>
 <br>

 <input type=submit name='submit' value='确定'>
</form>
