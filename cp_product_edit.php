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
				
		$sql = "select * from mtrs_cp_product where id=$id";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$name=$row[1];
		$cpID=$row[2];
		$mourl=$row[3];
		$mrurl=$row[4];
		$checkblk=$row[5];
		$forward_method=$row[8];
		$remarks=$row[6];
		$createtime=$row[7];
	}else{
		$name="";
		$cpID="";
		$mourl="";
		$mrurl="";
		$checkblk="";
		$forward_method="";
		$remarks="";
		$createtime="";
	}
?>

<font size=4><caption>渠道业务管理编辑>></caption></font>
<br><br><br>

<body>
<form name=cp_edit_form method=post action=cp_product_edit_do.php<?php if(isset($id)) echo "?id=$id"; ?> onsubmit='return check()'>

<table border='1' cellspacing='0' cellpadding='1' width='25%' class='tabs'>
<?php
if(isset($id))
{
	echo "<tr><th>ID</th><th align='center'>$id</th></tr>";
	echo "<input type='hidden' name='createtime' value='$createtime'/>";
}
?>
<tr>
	<th>产品名称&nbsp;&nbsp;</th>
	<th align='center'>
		<input type='text' name='name' value='<?php echo $name?>' size='30'/>
	</th>
</tr>

<tr>
	<th>cp名称&nbsp;&nbsp;</th>
	<th align='center'>
		<select name=cpID style="width:170">
		<?php
			$sql="select ID , cpname from mtrs_cp where status=1";
			$mtrs_cp_result=exsql($sql);
	  	while($mtrs_cp=mysqli_fetch_row($mtrs_cp_result))
	  	{	
			if(isset($id) && $cpID==$mtrs_cp[0])
	  			echo "<option value=$mtrs_cp[0] selected='selected'>$mtrs_cp[1]</option>";
			else
				echo "<option value=$mtrs_cp[0]>$mtrs_cp[1]</option>";
			
	  	}
		?>
		</select>
	</th>
</tr>

<tr>
	<th>mourl&nbsp;&nbsp;</th>
	<th align='center'>
		<input type='text' name='mourl' value='<?php echo $mourl?>' size='30'/>
	</th>
</tr>

<tr>
	<th>mrurl&nbsp;&nbsp;</th>
	<th align='center'>
		<input type='text' name='mrurl' value='<?php echo $mrurl?>' size='30'/>
	</th>
</tr>

<tr>	
	<th>黑名单检测</th>
	<th align='center'>
		是<input type=radio name=checkblk value=1 <?php if($checkblk==1) echo "checked=\"checked\""?>/> 
		否<input type=radio name=checkblk value=2 <?php if($checkblk==2) echo "checked=\"checked\""?>/> 
	</th>
</tr>

<tr>	
	<th>mo/mr同步方式</th>
	<th align='center'>
		<select name=forward_method>
		<?php if($forward_method==0){?>
		<option value='0'>mo/mr分开同步</option>
		<option value='1'>mo/mr一次同步</option>
		<?php }else{?>
		<option value='1'>mo/mr一次同步</option>
		<option value='0'>mo/mr分开同步</option>
		<?php }?>
		</select>
	</th>
</tr>


<tr>
	<th>备注&nbsp;&nbsp;</th>
	<th align='center'>
		<input type='text' name='remarks' value='<?php echo $remarks?>' size='40'/>
	</th>
</tr>
	
</table>
 <br>

 <input type=submit name='submit' value='确定'>
</form>
