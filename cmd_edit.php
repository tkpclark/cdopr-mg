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
	
	if(document.cmd_edit_form.cmd_deduction.value=="")
  {
     	   alert("请填写扣量比例!");
     	   document.cmd_edit_form.cmd_deduction.focus();
     	   return false;
	}
	
	if(document.cmd_edit_form.cmd_deduction.value > 100 || document.cmd_edit_form.cmd_deduction.value < 0)
	{
     	   alert("请填写1-100之间的数字!");
     	   document.cmd_edit_form.cmd_deduction.focus();
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
	
	/*
	$cpid=isset($_REQUEST['cpid'])?$_REQUEST['cpid']:"";
	$serviceid=isset($_REQUEST['channelid'])?$_REQUEST['channelid']:"";
	$cmd_spnumber=isset($_REQUEST['cmd_spnumber'])?$_REQUEST['cmd_spnumber']:"";
	$cmd_mocmd=isset($_REQUEST['cmd_mocmd'])?$_REQUEST['cmd_mocmd']:"";
	$cmd_status=isset($_REQUEST['cmd_status'])?$_REQUEST['cmd_status']:"";
	$deduction=isset($_REQUEST['deduction'])?$_REQUEST['deduction']:"";
	*/
	
	if(isset($_GET['cmd_id']))
	{
		$cmd_id=$_GET['cmd_id'];
				 //         0        1          2            3          4    5           6            7        8
		$sql = "SELECT t2.ID as cpID, t2.cpname as cpname, t1.spnumber, t1.mocmd, t3.ID as serviceID, t3.spnumber, t3.mocmd, t3.`name`, t1.`status` ,t1.url, t3.fee,t1.appID 
				FROM mtrs_cmd t1, mtrs_cp t2, mtrs_service t3 
				where t1.ID=$cmd_id and t1.cpID=t2.ID and t1.serviceID=t3.ID";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$cpid=$row[0];
		$cpname=$row[1];
		$cmd_spnumber=$row[2];
		$cmd_mocmd=$row[3];
		$serviceid=$row[4];
		$service_cnt=$row[7]." ".$row[5]."+".$row[6];
		$status=$row[8];
		$url=$row[9];
		$fee=$row[10];
		$appid=$row[11];
		
	}
	else
	{
		$cpid="";
		$cpname="请选择";
		$cmd_spnumber="";
		$cmd_mocmd="";
		$serviceid="";
		$service_cnt="请选择";
		$status="1";
		$url="http://";
		$fee=0;
		$appid="";
		$appname="请选择";
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
	echo "<tr><th>ID</th><th align='center'>$cmd_id</th></tr>";
}
?>


<tr>
	<th>所属业务</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name=channelid  style="width:200">
		<?php
			echo "<option value=$serviceid>$service_cnt</option>";
			$sql="select id, spnumber, mocmd,name from mtrs_service where status=1";
			$result=exsql($sql);
	  	while($row=mysqli_fetch_row($result))
	  	{
	  		echo "<option value=$row[0]>$row[3] $row[1]+$row[2]</option>";
	  	}
		?>
		</select>
	</th>
</tr>

<tr>
	<th>使用渠道</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name="cpid" style="width:200">
		<?php
			echo "<option value=$cpid>$cpname</option>";
			$sql="select id, cpname from mtrs_cp where status=1";
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
	<th>分配指令</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="cmd_spnumber" value="<?php echo $cmd_spnumber ?>" size="20"/>(长号码)&nbsp;&nbsp;+&nbsp;&nbsp;&nbsp;
		<input type="text" name="cmd_mocmd"  value="<?php echo $cmd_mocmd?>" size="20"/>(mo指令)
	</th>
</tr>
<!-- 
<tr>
	<th>收费</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="fee" value="<?php echo $fee ?>" size="5"/>&nbsp;&nbsp;&nbsp;
	</th>
</tr>
 -->

<tr>
	<th>应用模块</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name=appid  style="width:200">
		<?php
			echo "<option value=$appid>$appname</option>";
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
<tr>
	<th>扣量比例(默认)</th>
	<th align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php
		//get $deduction
		if(isset($cmd_id))
		{
			$sql="select deduction from mtrs_deduction where cmdID=$cmd_id and zone='0' limit 1";
			$result=exsql($sql);
		  $row=mysqli_fetch_row($result);
		  $deduction=100*$row[0];
		}
		else
		{
			$deduction="";
		}
		
		?>
		<input type="text" name="deduction" value="<?php echo $deduction ?>" size="3"/>%&nbsp;&nbsp;&nbsp;请填写1-100之间的数字
	</th>
</tr>

<tr>
	<th> url </th>
	<th align="left">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="url" value="<?php echo $url ?>" size="150"/>
	</th>
</tr>



<tr>	
	<th> 状态 </th>
	<th align="left">
		<?php $cmd_status=1 ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		正常<input type="radio" name="status" value="1" <?php if($status==1) echo "checked=\"checked\""?>/> 
		关闭<input type="radio" name="status" value="2" <?php if($status==2) echo "checked=\"checked\""?>/> 
	</th>
</tr>
	
</table>
 <br>

 <input type="submit" name="submit" value="确定">
</form>
</body>