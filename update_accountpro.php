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

$id          = intval($_POST['id']);
$pwd1        = trim($_POST['pwd1']);
$member_name = trim($_POST['member_name']);
$j           = trim(@$_POST['j']);
$url = !empty($j)?'account_list.php':'update_account.php';
if(!empty($id)){
	if(!empty($member_name) || !empty($pwd1)){
		$sql="set names utf8";
		exsql($sql);
		if(!empty($member_name) && !empty($pwd1)){
			$pwd1 = md5($pwd1 );
			$sql="update wraith_users set membername='$member_name',password='$pwd1' where ID=$id";
		}elseif(!empty($member_name)){
			$sql="update wraith_users set membername='$member_name' where ID=$id";
		}else{
			$pwd1 = md5($pwd1 );
			$sql="update wraith_users set password='$pwd1' where ID=$id";
		}

		if(!exsql($sql)){
			echo "<div style='width:100%;margin-top:200px;text-align:center'>修改失败，请重更改！</div><div style='width:100%;text-align:center'><a href='".$url."'>返回</a></div>";
		}else{
			
			if(!empty($member_name) && empty($j))setcookie("membername",$member_name);

			if(!empty($pwd1) && empty($j))setcookie("password",$pwd1);

			if(!empty($j)){
				echo "<div style='width:100%;margin-top:200px;text-align:center'>修改成功！<span id='time'>5</span>秒后，自动跳转</div><div style='width:100%;text-align:center'><a href='account_list.php'>返回</a></div><script type='text/javascript'> delayURL('account_list.php');</script> ";
			}else{
				echo "<div style='width:100%;margin-top:200px;text-align:center'>修改成功！</div>";
			}
		}
	}else{
		echo "<div style='width:100%;margin-top:200px;text-align:center'>没有可更新信息！</div><div style='width:100%;text-align:center'><a href='".$url."'>返回</a></div>";
	}
}else{
	echo "<div style='width:100%;margin-top:200px;text-align:center'>没有可更新用户！</div><div style='width:100%;text-align:center'><a href='".$url."'>返回</a></div>";
}


?>