<script Language="JavaScript">
function check()
{
	if(document.cp_service_edit_form.deduction.value=="")
  {
     	   alert("请填写扣量比例!");
     	   document.service_edit_form.deduction.focus();
     	   return false;
	}
	
	if(document.service_edit_form.deduction.value > 100 || document.service_edit_form.deduction.value < 0)
	{
     	   alert("请填写1-100之间的数字!");
     	   document.service_edit_form.deduction.focus();
     	   return false;
	}
}
</script>
<?php 
	include("check.php"); 
	include("style.php");
	if(isset($_GET['serviceID']))
	{
		$serviceID=$_GET['serviceID'];
				
		$sql = "select sp_number,mo_cmd,msgtype,status,spID,fee,name,gwID,service_id from mtrs_service where id=$serviceID";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$spnumber=$row[0];
		$mocmd=$row[1];
		$msgtype=$row[2];
		$status=$row[3];
		$spID=$row[4];
		$gwID=$row[7];
		$fee=$row[5];
		$service_name=$row[6];
		$service_id=$row[8];
		
		//get spname
		if($spID)
		{
			$sql="select spname from mtrs_sp where ID=$spID";
			$result=exsql($sql);
		 	$row_spname=mysqli_fetch_row($result);
		 	$spname=$row_spname[0];
		}
	 	else
	 	{
	 		$spname="";
	 	}
	 	//get gwname
		if($gwID)
		{
		 	$sql="select comment from wraith_gw where ID=$gwID";
			$result=exsql($sql);
		 	$row_gwname=mysqli_fetch_row($result);
		 	$gwname=$row_gwname[0];
		}
		else
		{
			$gwname="";
		}
		
	}
	else
	{
		$spnumber="";
		$mocmd="";
		$msgtype="1";
		$status="1";
		$spID="";
		$gwID="";
		$spname="";
		$fee="";
		$service_name="";
		$service_id="";
	}
?>
<font size=4><caption>新增通道>></caption></font>
<br><br><br>
<body>
<form name=service_edit_form method=post action=service_edit_do.php<?php if(isset($serviceID)) echo "?serviceID=$serviceID"; ?> onsubmit="return check()">

<table>
<?php
if(isset($serviceID))
{
	echo "<tr><th>ID</th><td align='center'>$serviceID</td></tr>";
}
?>

<tr>
	<th>业务名称</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="service_name"  value="<?php echo $service_name?>" size="30"/>
	</td>
</tr>

<tr>
	<th>目的号码</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="spnumber" value="<?php echo $spnumber ?>" size="30"/>
	</td>
</tr>

<tr>
	<th>MO指令</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="mocmd"  value="<?php echo $mocmd?>" size="30"/>
	</td>
</tr>

<tr>
	<th>资费</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="fee"  value="<?php echo $fee?>" size="25"/>&nbsp;&nbsp;&nbsp;&nbsp;分
	</td>
</tr>

<tr>
	<th>计费代码</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="service_id"  value="<?php echo $service_id?>" size="25"/>&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
</tr>

<tr>
	<th>所属SP名称&nbsp;&nbsp;</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name=spID style="width:170">
		<?php
			echo "<option value='$spID'>($spID)$spname</option>";
			$sql="select id, spname from mtrs_sp where status=1";
			$result=exsql($sql);
	  	while($row=mysqli_fetch_row($result))
	  	{
	  		echo "<option value=$row[0]>($row[0])$row[1]</option>";
	  	}
		?>
		</select>
	</td>
</tr>

<tr>
	<th>网关&nbsp;&nbsp;</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name=gwID style="width:170">
		<?php
			echo "<option value='$gwID'>($gwID)$gwname</option>";
			$sql="select id, comment from wraith_gw where status=1";
			$result=exsql($sql);
	  	while($row=mysqli_fetch_row($result))
	  	{
	  		echo "<option value=$row[0]>($row[0])$row[1]</option>";
	  	}
		?>
		</select>
	</td>
</tr>

<tr>	
	<th> 消息类型 </th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		短信<input type=radio name=msgtype value=1 <?php if($msgtype==1) echo "checked=\"checked\""?>/> 
		彩信<input type=radio name=msgtype value=2 <?php if($msgtype==2) echo "checked=\"checked\""?>/> 
	</td>
</tr>

<tr>	
	<th> 状态 </th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		正常<input type=radio name=status value=1 <?php if($status==1) echo "checked=\"checked\""?>/> 
		关闭<input type=radio name=status value=2 <?php if($status==2) echo "checked=\"checked\""?>/> 
	</td>
</tr>
	
</table>
 <br>

 <input type=submit name="submit" value="确定">
</form>
</form>