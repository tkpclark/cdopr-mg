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

$name  = trim(@$_POST['name']);
$menus = @$_POST['menus'];
$id    = @$_POST['id'];
if(!empty($id)){
	$url = "role_edit.php?id=".$id;
}else{
	$url = "role_edit.php";
}
if(!empty($name) && !empty($menus)){
	$menus = implode(',',$menus);
	$sql="set names utf8";
	exsql($sql);
	if(empty($id)){
		$sql="select * from wraith_role where name='$name'";
		$result=mysqli_query($mysqli,$sql);
		if(($row=mysqli_fetch_row($result)) == null){
			$sql="insert into wraith_role(name,menus)
						values('$name','$menus')";
			//echo $sql;
			if(!exsql($sql)){
				echo "<div style='width:100%;margin-top:200px;text-align:center'>添加失败，请重新添加用户！</div><div style='width:100%;text-align:center'><a href='".$url."'>返回</a></div>";
			}else{
				echo "<div style='width:100%;margin-top:200px;text-align:center'>添加成功！<span id='time'>5</span>秒后，自动跳转</div><div style='width:100%;text-align:center'><a href='role_list.php'>返回</a></div><script type='text/javascript'> delayURL('role_list.php');</script> ";
			}
		}else{
			echo "<div style='width:100%;margin-top:200px;text-align:center'>角色名称已存在，请重新输入！</div><div style='width:100%;text-align:center'><a href='".$url."'>返回</a></div>";
		}
	}else{
		$sql="select * from wraith_role where name='$name' and id != $id";
		$result=mysqli_query($mysqli,$sql);
		if(($row=mysqli_fetch_row($result)) == null){
			$sql="update wraith_role set name='$name' , menus='$menus' where id=$id";
			//echo $sql;
			if(!exsql($sql)){
				echo "<div style='width:100%;margin-top:200px;text-align:center'>修改失败，请重新修改！</div><div style='width:100%;text-align:center'><a href='".$url."'>返回</a></div>";
			}else{
				echo "<div style='width:100%;margin-top:200px;text-align:center'>修改成功！<span id='time'>5</span>秒后，自动跳转</div><div style='width:100%;text-align:center'><a href='role_list.php'>返回</a></div><script type='text/javascript'> delayURL('role_list.php');</script>";
			}
		}else{
			echo "<div style='width:100%;margin-top:200px;text-align:center'>角色名称已存在，请重新输入！</div><div style='width:100%;text-align:center'><a href='".$url."'>返回</a></div>";
		}
	}
}else{
	echo "<div style='width:100%;margin-top:200px;text-align:center'>信息不完整，请重新添加用户！</div><div style='width:100%;text-align:center'><a href='".$url."'>返回</a></div>";
}



?>