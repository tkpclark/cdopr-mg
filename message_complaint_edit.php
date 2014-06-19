
<?php 
	include("check.php"); 
	include("style.php");
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
				
		$sql = "select id,phone_number,complaint_content,reply_content,complaint_result,refund_form,refund_time,refund_result,refund_phone,unicom_number,customer_service_number from wraith_message_complaint where id=$id";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
	}
?>

<font size=4><caption>投诉编辑>></caption></font>
<br><br><br>

<body>
<form name=sp_edit_form method=post action=message_complaint_edit_do.php onsubmit='return check()'>

<table border='1' cellspacing='0' cellpadding='1' width='25%' class='tabs'>


<tr><th>ID</th><td align='center'><?php echo $row[0]?></td></tr>
<input type='hidden' name='id' value='<?php echo $row[0]?>'/>

<tr>
	<th>投诉号码&nbsp;&nbsp;</th>
	<td align='center'><?php echo $row[1]?></td>
</tr>

<tr>
	<th>投诉内容&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='complaint_content' value='<?php echo $row[2]?>' size='30'/>
	</td>
</tr>

<tr>
	<th>需给用户回复的内容&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='reply_content' value='<?php echo $row[3]?>' size='30'/>
	</td>
</tr>

<tr>
	<th>处理结果&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='complaint_result' value='<?php echo $row[4]?>' size='30'/>
	</td>
</tr>

<tr>
	<th>退费方式&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='refund_form' value='<?php echo $row[5]?>' size='30'/>
	</td>
</tr>

<tr>
	<th>退费时间&nbsp;&nbsp;</th>
	<td align='center'>
		<input id="date1" name='refund_time' type="text" class="easyui-datebox" data-options="formatter:myformatter" required="required" value="<?php echo $row[6]?>"></input>
	</td>
</tr>

<tr>
	<th>退费结果&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='refund_result' value='<?php echo $row[7]?>' size='30'/>
	</td>
</tr>

<tr>
	<th>退费联系电话&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='refund_phone' value='<?php echo $row[8]?>' size='30'/>
	</td>
</tr>

<tr>
	<th>联通工号&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='unicom_number' value='<?php echo $row[9]?>' size='30'/>
	</td>
</tr>

<tr>
	<th>客服工号&nbsp;&nbsp;</th>
	<td align='center'>
		<input type='text' name='customer_service_number' value='<?php echo $row[10]?>' size='30'/>
	</td>
</tr>
	
</table>
 <br>

 <input type=submit name='submit' value='确定'>
</form>
