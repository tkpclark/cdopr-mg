<script language="JavaScript" type="text/javascript">    
function delayURL(url) {  
	var delay = document.getElementById("time").innerHTML;
	if(delay > 0) {  
	   delay--;  
	   document.getElementById("time").innerHTML = delay;  
	} else {  
	   window.location.href = url;
		}  
		setTimeout("delayURL('" + url + "')", 1000);
	}  
</script>  
<?php
include("check.php"); 

$name = trim($_POST['name']);
$pwd1 = md5(trim($_POST['pwd1']));
$role = $_POST['role'];
$member_name = trim($_POST['member_name']);
if(!empty($name) && !empty($pwd1) && !empty($role) && !empty($member_name)){
	$sql="set names utf8";
	exsql($sql);
	$sql="select * from wraith_users where username='$name'";
	$result=mysqli_query($mysqli,$sql);
	if(($row=mysqli_fetch_row($result)) == null){
		$sql="insert into wraith_users(username,password,role,membername)
					values('$name','$pwd1',$role,'$member_name')";
		//echo $sql;
		if(!exsql($sql)){
			echo "<div style='width:100%;margin-top:200px;text-align:center'>添加失败，请重新添加用户！</div><div style='width:100%;text-align:center'><a href='create_account.php'>返回</a></div>";
		}else{
			echo "<div style='width:100%;margin-top:200px;text-align:center'>添加成功！<span id='time'>5</span>秒后，自动跳转<div style='width:100%;text-align:center'><a href='account_list.php'>返回</a></div></div><script type='text/javascript'> delayURL('account_list.php');</script>";
		}
	}else{
		echo "<div style='width:100%;margin-top:200px;text-align:center'>用户名已存在，请重新添加用户！</div><div style='width:100%;text-align:center'><a href='create_account.php'>返回</a></div>";
	}
}else{
	echo "<div style='width:100%;margin-top:200px;text-align:center'>信息不完整，请重新添加用户！</div><div style='width:100%;text-align:center'><a href='create_account.php'>返回</a></div>";
}



?>