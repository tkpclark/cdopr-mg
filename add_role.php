<?php 
	include("check.php"); 
	include("style.php");
	
	$sql="set names utf8";
	mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	$sql="select * from wraith_menu";
	$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	while($row=mysqli_fetch_assoc($result))
	{
		if($row['parent'] == 0)
		{
			$parent[] = $row;
		}
		else
		{
			$childs[] = $row;
		}
	}
	mysqli_free_result($result);
	$id = @$_GET['id'];
	if(!empty($id)){
		$sql="select name , menus from wraith_role where id=".$id;
		$result_role=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
		$role=mysqli_fetch_assoc($result_role);
		mysqli_free_result($result_role);
	}
?>
<script language="Javascript" src="calendar/js/JQUERY.JS"></script>
<script language="Javascript">
 
	function expands(el){
		if($(".parent"+el+":checkbox").attr("checked") == 'checked' ){
			$(".parent"+el+":checkbox").attr("checked", "checked");
			$(".child"+el+":checkbox").attr("checked", true); 
		}else{
			$(".parent"+el+":checkbox").attr("checked", false);
			$(".child"+el+":checkbox").attr("checked", false); 
		}
	}
</script>
<font size=4 color=red>添加角色：</font>
<br><br>
<center>

<table border="1" cellspacing="0" cellpadding="1" width="410" >
<form action=add_rolepro.php name=form1 method=post onsubmit="return checkpwd();">
	<input type=hidden name=id value="<?php echo !empty($id)?$id:'';?>">
	<tr height="30"><td align=center><font size=2 color=red>用户名：&nbsp;&nbsp;<input type=text name=name value="<?php echo isset($role) && !empty($role)?$role['name']:'' ?>"></td></tr>
	<tr height="30"><td align=center><font size=2 color=red>请选择控制菜单：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>

<?php	
	if(!empty($parent))
	{
		foreach($parent as $v)
		{		
				isset($role) && !empty($role) && in_array($v['id'],explode(',',$role['menus']))?$checked = "checked='checked'":$checked='';
				echo "<tr height='30'><td style='text-align:left;padding-left:450px;'><input class='parent".$v['id']."' onclick=expands(".$v['id'].") type=checkbox name=menus[] value='".$v['id']."'".$checked."><font size=2 color=red>".$v['name']."</td></tr>";
				if(!empty($childs))
				{
					foreach($childs as $c)
					{
						if($c['parent'] == $v['id'])
						{	
							isset($role) && !empty($role) && in_array($c['id'],explode(',',$role['menus']))?$checked = "checked='checked'":$checked='';
							echo "<tr height='30'><td style='text-align:left;padding-left:470px;'><input class='child".$v['id']."' onclick=expand(".$v['id'].") type=checkbox name=menus[] value='".$c['id']."'". $checked."><font size=2 color=red>".$c['name']."</td></tr>";
						}
					}
				}
		}
	}		
 ?>  

	<tr><td align=center><input type=submit value=确定></td></tr>
</form>
</table>

</center>
