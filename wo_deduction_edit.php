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
	include("area_code.php");
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
				
		$sql = "select * from wraith_wo_deduction where id=$id";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$name=$row[1];
		$province=$row[2];
		$up_deduction=$row[3];
		$down_deduction=$row[4];
	}
	else
	{	
		$name='';
		$province='';
		$up_deduction='';
		$down_deduction='';
	}
?>

<font size=4><caption>wo扣量编辑>></caption></font>
<br><br><br>

<body>
<form name=sp_edit_form method=post action=wo_deduction_edit_do.php<?php if(isset($id)) echo "?did=$id"; ?> onsubmit='return check()'>

<table border='1' cellspacing='0' cellpadding='1' width='25%' class='tabs'>
<?php
if(isset($id))
{
	echo "<tr><th>ID</th><td align='center'>$id</td></tr>";
}
?>
<tr>
	<th>渠道名称&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='name' value='<?php echo $name?>' size='30'/>
	</td>
</tr>

<tr>
	<th>省份&nbsp;&nbsp;</th>
	<td align='center'>
		<select id='province' name='province'>
		<option value='默认'>默认</option>
		<?php
		while($key = key($area_code))
		{
			echo "<option value='$area_code[$key]'>$area_code[$key]</option>";
			next($area_code);
		}
		?>
		</select>
	</td>
</tr>

<tr>
	<th>上行扣量&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='up_deduction' value='<?php echo $up_deduction?>' size='30'/>
	</td>
</tr>

<tr>
	<th>下行扣量&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='down_deduction' value='<?php echo $down_deduction?>' size='30'/>
	</td>
</tr>
	
</table>
 <br>

 <input type=submit name='submit' value='确定'>
</form>
