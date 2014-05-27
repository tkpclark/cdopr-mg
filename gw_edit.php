<script Language="JavaScript">
function check()
{
	if(document.gw_edit_form.comment.value=="")
  {
     	   alert("请填写扣量比例!");
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
				
		$sql = "select comment,status,belongto from wraith_gw where id=$id";
		//echo $sql;
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$comment=$row[0];
		$status=$row[1];
		$belongto=$row[2];
		
	}
	else
	{
		$comment="";
		$status="1";
		$belongto='1';
	}
?>

<font size=4><caption>网关编辑>></caption></font>
<br><br><br>

<body>
<form name=gw_edit_form method=post action=gw_edit_do.php<?php if(isset($id)) echo "?id=$id"; ?> onsubmit='return check()'>

<table border='1' cellspacing='0' cellpadding='1' width='25%' class='tabs'>
<?php
if(isset($id))
{
	echo "<tr><th>ID</th><th align='center'>$id</th></tr>";
}
?>
<tr>
	<th>网关名称&nbsp;&nbsp;</th>
	<th align='center'>
		<input type='text' name='comment' value='<?php echo $comment?>' size='30'/>
	</th>
</tr>
<?php
	if(isset($_GET['id'])){
?>
<tr>	
	<th> 状态 </th>
	<th align='center'>
		有效 <input type=radio name=status value=1 <?php if($status==1) echo "checked=\"checked\""?>/> 
		无效<input type=radio name=status value=0 <?php if($status==0) echo "checked=\"checked\""?>/> 
	</th>
</tr>
<?php
	}
?>
<tr>	
	<th> 所属 </th>
	<th align='center'>
		自有 <input type=radio name=belongto value=1 <?php if($belongto==1) echo "checked=\"checked\""?>/> 
		合作方<input type=radio name=belongto value=2 <?php if($belongto==2) echo "checked=\"checked\""?>/> 
	</th>
</tr>
</table>
 <br>

 <input type=submit name='submit' value='确定'>
</form>
