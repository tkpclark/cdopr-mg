<?php 
	include("check.php"); 
	include("style.php");

	$sql="set names utf8";
	mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	$sql="select * from wraith_role";
	$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	while($row=mysqli_fetch_assoc($result))
	{
		$rows[] = $row;
	}

	//渠道
	$sql="select * from mtrs_cp";
	$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	while($rowcp=mysqli_fetch_assoc($result))
	{
		$rowscp[] = $rowcp;
	}
	//用户信息
	if(isset($_GET['id'])&&!empty($_GET['id'])){
		$id=$_GET['id'];
		$sql="select * from wraith_users where ID=$id";
		$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
		$row_user=mysqli_fetch_assoc($result);
		$username=$row_user['username'];
		$membername=$row_user['membername'];
		$role=$row_user['role'];
		$cpID=$row_user['cpID'];

	}else{
		$id='';
		$username='';
		$membername='';
		$role='';
		$cpID='';
	}
	
	mysqli_free_result($result);
?>
<script language="Javascript">
function checkpwd()
{
	if(document.form1.name.value=="")
	{
		alert("请输入用户名！");
		document.form1.name.focus();
		return false;
	}

	if(document.form1.pwd1.value!=document.form1.pwd2.value)
	{
		alert("两次输入的密码不同!");
		return false;
	}
	if(document.form1.position.value)
	{
		alert("请选择帐号类型！");
		document.form1.position.focus();
		return false;
	}
	if(document.form1.member_name.value=="")
	{
		alert("请选择员工姓名");
		return false;
	}
	
}

</script>
<font size=4 color=red>添加用户：</font>
<br><br>
<center>

<table border="1" cellspacing="0" cellpadding="1" width="410" >
<form action=account_edit_do.php name=form1 method=post onsubmit="return checkpwd();">
<input type=hidden name=id value="<?php echo $id;?>">
<tr height="30"><td align=center><font size=2 color=red>用户名：&nbsp;&nbsp;<input type=text name=name value="<?php echo $username;?>"></td></tr>
<?php
if(empty($id)){
?>
<tr height="30"><td align=center><font size=2 color=red>密码：&nbsp;&nbsp;&nbsp;&nbsp;<input type=password name=pwd1></td></tr>
<tr height="30"><td align=center><font size=2 color=red>重复输入：<input type=password name=pwd2 ></td></tr>
<?php
}
?>
<tr height="30"><td align=center><font size=2 color=red>请选择帐号的类型：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
<?php
foreach($rows as $v){
	if($v['id']==$role){
		echo "<tr height='30'><td align=center><input type=radio name=role value=$v[id] checked><font size=2 color=red>$v[name]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
	}else{
		echo "<tr height='30'><td align=center><input type=radio name=role value=$v[id]><font size=2 color=red>$v[name]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
	}

}
?>
<tr height="30"><td align=center><font size=2 color=red>渠道：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="cpID"><option value="0">默认</option>
<?php
foreach($rowscp as $c){
	if($c['ID']==$cpID){
		echo "<option value=$c[ID] selected>$c[cpname]</option>";
	}ELSE{
		echo "<option value=$c[ID]>$c[cpname]</option>";
	}

}
?>
</select></td></tr>
<tr height="30"><td align=center><font size=2 color=red>员工姓名：<input type=text name=member_name VALUE="<?php echo $membername;?>"></td></tr>
<tr><td align=center><input type=submit value=确定></td></tr>
</table>

</center>
