<script Language="JavaScript">
function check()
{

	
	if(document.cmd_edit_form.cmd_spnumber.value=="")
  {
     	   alert("请填写指令目的号码!");
     	   document.cmd_edit_form.cmd_spnumber.focus();
     	   return false;
	}
	
	if(document.cmd_edit_form.cmd_mocmd.value=="")
  {
     	   alert("请填写指令上行内容!");
     	   document.cmd_edit_form.cmd_mocmd.focus();
     	   return false;
	}
	
	
	if(document.cmd_edit_form.cmd_status.value=="")
  {
     	   alert("请选择状态!");
     	   document.cmd_edit_form.cmd_status.focus();
     	   return false;
	}
	
}
</script>
<?php 
	include("check.php"); 
	include("style.php");

	
	if(isset($_GET['cmd_id']))
	{
		$cmd_id=$_GET['cmd_id'];
		$sql = "SELECT * from mtrs_cmd where id=$cmd_id";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_assoc($result);
		$cpProdID=$row['cpProdID'];
		$cmd_spnumber=$row['sp_number'];
		$cmd_mocmd=$row['mo_cmd'];
		$serviceID=$row['serviceID'];
		$status=$row['status'];
		$app_module=$row['app_module'];
		$checkblk=$row['checkblk'];
	}
	else
	{
		$cpProdID=0;
		$cmd_spnumber="";
		$cmd_mocmd="";
		$serviceID=0;
		$status=1;
		$app_module="";
		$checkblk='1';
	}
?>
<font size=4><caption>指令分配>></caption></font>
<br><br><br>
<body>
<form name=cmd_edit_form method=post action=cmd_edit_do.php<?php if(isset($cmd_id)) echo "?cmd_id=$cmd_id"; ?> onsubmit="return check()">

<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">
<?php
if(isset($cmd_id))
{
	echo "<tr><th>ID</th><td align='center'>$cmd_id</td></tr>";
}
?>


<tr>
	<th>通道业务</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
	<th>渠道业务</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name="cpProdID" style="width:300">
		<?php
			$sql="select t1.ID as cpProdID,t1.`name` as cpProdName,t2.ID as cpID,t2.cpname from mtrs_cp_product t1,mtrs_cp t2 where t1.cpID=t2.ID and t1.status=1";
			$result=exsql($sql);
		  	while($row=mysqli_fetch_row($result))
		  	{
		  		if($row[0]==$cpProdID)
		  			echo "<option value=$row[0]>($row[2])$row[3]($row[0])$row[1]</option>";
		  	}
		  	$result=exsql($sql);
		  	while($row=mysqli_fetch_row($result))
		  	{
		  		if($row[0]!=$cpProdID)
		  			echo "<option value=$row[0]>($row[2])$row[3]($row[0])$row[1]</option>";
		  	}
	  	
		?>
		</select>
	</td>
</tr>

<tr>
	<th>分配指令</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="cmd_spnumber" value="<?php echo $cmd_spnumber ?>" size="20"/>(长号码)&nbsp;&nbsp;+&nbsp;&nbsp;&nbsp;
		<input type="text" name="cmd_mocmd"  value="<?php echo $cmd_mocmd?>" size="20"/>(mo指令)
	</td>
</tr>
<!-- 
<tr>
	<th>收费</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="fee" value="<?php echo $fee ?>" size="5"/>&nbsp;&nbsp;&nbsp;
	</th>
</tr>


<tr>
	<th>应用模块</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name=appid  style="width:200">
		<?php
			echo "<option value=$app_module>$app_module</option>";
			$sql="select id, app_name, app_module from wraith_app where status=1";
			$result=exsql($sql);
		  	while($row=mysqli_fetch_row($result))
		  	{
		  		echo "<option value=$row[0]>$row[1]</option>";
		  	}
			?>
			</select>
	</th>
</tr>
 -->
<th>允许访问的省份&nbsp;</th>
<td><input type=text name=open_province value='<?php echo $row[8];?>' size=170></td>
</tr>
<tr>
<th>禁止的地区&nbsp;</th>
<td><input type=text name=forbidden_area value='<?php echo $row[9];?>' size=170></td>
<tr>
				

<tr>	
	<th> 状态 </th>
	<td align="left">
		<?php $cmd_status=1 ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		正常<input type="radio" name="status" value="1" <?php if($status==1) echo "checked=\"checked\""?>/> 
		关闭<input type="radio" name="status" value="2" <?php if($status==2) echo "checked=\"checked\""?>/> 
	</td>
</tr>

<tr>	
	<th> 黑名单检测 </th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		是<input type=radio name=checkblk value=1 <?php if($checkblk==1) echo "checked=\"checked\""?>/> 
		否<input type=radio name=checkblk value=2 <?php if($checkblk==2) echo "checked=\"checked\""?>/>
	</td>
</tr>
	
</table>
 <br>

 <input type="submit" name="submit" value="确定">
</form>
</body>