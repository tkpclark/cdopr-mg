<script Language="JavaScript">
function ask(id)
{
	var str=
		answer=confirm("确定要删除id="+id+"的记录吗？");
	if(answer=="1")
		return true;
	else 
		return false;
}
</script>
<?php
include("check.php"); 
include("style.php");

$sql="set names utf8";
mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
$sql="select * from wraith_role where id != 1";
$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
while($row=mysqli_fetch_assoc($result))
{
	$rows[] = $row;
}

$sql="select * from wraith_menu order by id asc";
$result_menu=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
while($menu=mysqli_fetch_assoc($result_menu))
{
	$menus[$menu['id']] = $menu;
}
?>
<body>
<font size=4><caption>角色列表>></caption></font>
<br><br>
<font size=3><a href='role_edit.php'>添加</a></font><br>

<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr><th><font>序号</th><th><font>名称</th><th><font>菜单列表</th><th><font>编辑</th><th><font>删除</th></tr>
<?php


  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  if(!empty($rows)){
  foreach($rows as $row)
  {
    echo"<tr>";
		
	echo "<td align=center><font size=2>$row[id]</td>";

	echo "<td align=center><font size=2>$row[name]</td>";
	
	echo "<td style='text-align:left'>";
	foreach($menus as $m){
		if(in_array($m['id'],explode(',',$row['menus']))){
			if($m['parent']==0){
				echo '<br><font size=2 style="font-weight:bold;">'.$m['name'].'</font>=>';
			}else{
				echo $m['name'].'&nbsp';
			}
		}
	}
	echo "</td>"; 
		echo "<td align=center><font size=2><a href=\"role_edit.php?id=$row[id]\" ><img src='images/b_edit.png' alt='编辑'></a>&nbsp;</td>";
		//delete
		echo "<td align=center onclick=\"return ask($row[id]);\"><font size=2><a href=\"del_role.php?id=$row[id]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
    echo"</tr>";
  }}
?>
</table>

</font>
</body>