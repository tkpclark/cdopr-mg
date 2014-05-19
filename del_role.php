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

$id = intval($_GET['id']);
if(!empty($id)){
	$sql="set names utf8";
	exsql($sql);
	$sql="delete from wraith_role where id=$id";
	if(!exsql($sql)){
		echo "<div style='width:100%;margin-top:200px;text-align:center'>删除失败！</div><div style='width:100%;text-align:center'><a href='role_list.php'>返回</a></div>";
	}else{
		echo "<div style='width:100%;margin-top:200px;text-align:center'>删除成功！<span id='time'>5</span>秒后，自动跳转</div><div style='width:100%;text-align:center'><a href='role_list.php'>返回</a></div><script type='text/javascript'> delayURL('role_list.php');</script> ";
	}
}else{
	echo "<div style='width:100%;margin-top:200px;text-align:center'>没有可删除角色！</div><div style='width:100%;text-align:center'><a href='role_list.php'>返回</a></div>";
}


?>

