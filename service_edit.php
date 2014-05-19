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
	if(isset($_GET['service_id']))
	{
		$service_id=$_GET['service_id'];
				
		$sql = "select spnumber,mocmd,msgtype,status,spID,fee,name from mtrs_service where id=$service_id";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$spnumber=$row[0];
		$mocmd=$row[1];
		$msgtype=$row[2];
		$status=$row[3];
		$spID=$row[4];
		$fee=$row[5];
		$service_name=$row[6];
		
		//get spname
		$sql="select spname from mtrs_sp where ID=$spID";
		$result=exsql($sql);
	 	$row=mysqli_fetch_row($result);
	 	$spname=$row[0];
		
	}
	else
	{
		$spnumber="";
		$mocmd="";
		$msgtype="1";
		$status="1";
		$spID="";
		$spname="";
		$fee="";
		$service_name="";
	}
?>
<font size=4><caption>新增通道>></caption></font>
<br><br><br>
<body>
<form name=service_edit_form method=post action=service_edit_do.php<?php if(isset($service_id)) echo "?serviceID=$service_id"; ?> onsubmit="return check()">

<table>
<?php
if(isset($service_id))
{
	echo "<tr><th>ID</th><th align='center'>$service_id</th></tr>";
}
?>


<tr>
	<th>目的号码</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="spnumber" value="<?php echo $spnumber ?>" size="30"/>
	</th>
</tr>

<tr>
	<th>MO指令</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="mocmd"  value="<?php echo $mocmd?>" size="30"/>
	</th>
</tr>

<tr>
	<th>单条计费</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="fee"  value="<?php echo $fee?>" size="25"/>&nbsp;&nbsp;&nbsp;&nbsp;分
	</th>
</tr>

<tr>
	<th>业务名称</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="service_name"  value="<?php echo $service_name?>" size="30"/>
	</th>
</tr>

<tr>
	<th>所属SP名称&nbsp;&nbsp;</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name=spID style="width:170">
		<?php
			echo "<option value='$spID'>$spname</option>";
			$sql="select id, spname from mtrs_sp where status=1";
			$result=exsql($sql);
	  	while($row=mysqli_fetch_row($result))
	  	{
	  		echo "<option value=$row[0]>$row[1]</option>";
	  	}
		?>
		</select>
	</th>
</tr>

<tr>	
	<th> 消息类型 </th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		短信<input type=radio name=msgtype value=1 <?php if($msgtype==1) echo "checked=\"checked\""?>/> 
		彩信<input type=radio name=msgtype value=2 <?php if($msgtype==2) echo "checked=\"checked\""?>/> 
	</th>
</tr>

<tr>	
	<th> 状态 </th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		正常<input type=radio name=status value=1 <?php if($status==1) echo "checked=\"checked\""?>/> 
		关闭<input type=radio name=status value=2 <?php if($status==2) echo "checked=\"checked\""?>/> 
	</th>
</tr>
	
</table>
 <br>

 <input type=submit name="submit" value="确定">
</form>
</form>