<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

?>
<head>
<script type="text/javascript" src="jquery.js"></script>
<script>
$(document).ready(function(){
		/*

		//$.setTable();
		 */
		$("see_deduction").click(function(){
			var cmd=$(this);
			var cmd_id=$(this).parent().parent("tr").children("td:eq(0)").text();
			//var cmd_id=$(this).text();
			//alert(cmd_id);
			$.get("cmd_display_visit_limit.php?cmd_id="+cmd_id+"&limit_type=1",function(result){
				$(cmd).prev().replaceWith(result);
				});
			});
		$("see_deductions").click(function(){
			var cmd=$(this);
			var cmd_id=$(this).parent().parent("tr").children("td:eq(0)").text();
			//var cmd_id=$(this).text();
			//alert(cmd_id);
			$.get("cmd_display_visit_limit.php?cmd_id="+cmd_id+"&limit_type=2",function(result){
				$(cmd).prev().replaceWith(result);
				});
			});
		
		//$("see_deduction").click();
		
		$("see_cmd_mt").click(function(){
			var cmd=$(this);
			var cmd_id=$(this).parent().parent("tr").children("td:eq(0)").text();
			//var cmd_id=$(this).text();
			//alert(cmd_id);
			$.get("cmd_display_mt.php?cmd_id="+cmd_id,function(result){
				$(cmd).prev().replaceWith(result);
				});
		});


});
</script>
</head>
<body>

<?php
$where=" 1";
if(isset($_REQUEST['spID']) && !empty($_REQUEST['spID'])){
	$sql="select id from mtrs_service where spID=".$_REQUEST['spID'];
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{
 		$cp_pro[]=$row[0];
 	}
	$where = " serviceID in (".implode(',',$cp_pro).")";
}
if(isset($_REQUEST['cmd_id']) && !empty($_REQUEST['cmd_id'])){
	$where = " ID=".$_REQUEST['cmd_id'];
}
echo "<body>";
echo "<font size=4><caption>指令列表>></caption></font>
<br><br>
<font size=3><a href='cmd_edit.php'>添加</a></font><br>";

echo '<form name=pn_inq action="cmd_list.php" method=post>';
 echo "<table><tr><td>通道<select name=spID onchange=>";

 	$sql="select ID,spname from mtrs_sp";
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{	
		if(isset($_REQUEST['spID']) && !empty($_REQUEST['spID']) && $_REQUEST['spID']==$row[0]){
			echo "<option value=$row[0] selected>($row[0])$row[1]</option>";
		}else{
			echo "<option value=$row[0]>($row[0])$row[1]</option>";
		}
 		
 	}

echo "</select><input type=submit name=submit value=查询></td></tr></table></from>";



echo "<table border='1' cellspacing='0' cellpadding='1' width='90%' class='tabs'>
<tr>
<th>序号</th>
<th>指令</th>
<th>黑名单检测</th>
<th>所属通道</th>
<th>所属通道业务</th>
<th>资费(元)</th>
<th>代计费</th>
<th>使用渠道</th>
<th>使用渠道业务</th>
<th>查看下行</th>
<th>开通省份</th>
<th>禁止地区</th>
<th>状态</th>
<th>编辑</th>
<th>删除</th>
</tr>";
$buf= "SELECT * FROM mtrs_cmd where ".$where;
//echo $buf;
$result=exsql($buf);

echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
while($row=mysqli_fetch_row($result))
{
	echo"<tr>";
	//seq
	echo "<td align=center>$row[0]</td>";

	//cmd(spnumber+mocmd)precise
	echo "<td align=center>$row[1]+$row[2]</td>";

	//checkblk
	  if($row[9]==1)
			echo "<td align=center>是</td>";
		else
			echo "<td align=center>否</td>";
		

	$s = "select t1.id,t1.sp_number,t1.mo_cmd,name,fee,gwid,t2.id,t2.spname from mtrs_service t1,mtrs_sp t2 where t1.id=$row[4] and t1.spID=t2.ID";
	$r = exsql($s);
	$ro = mysqli_fetch_row($r);
	
	if(mysqli_num_rows($r))
	{	//sp
	echo "<td align=center>($ro[6])$ro[7]</td>";
	//service
	echo "<td align=center>($ro[0])$ro[3]-$ro[1]+$ro[2]</td>";
	//fee
	echo "<td align=center>".number_format($ro[4]/100,2)."</td>";
	}
	else{
	echo "<td align=center></td>";
	echo "<td align=center></td>";
	echo "<td align=center></td>";
	}
		
		
	//is_agent
	  if($row[10]==2)
			echo "<td align=center>是</td>";
		else   if($row[10]==1)
			echo "<td align=center>不是</td>";
		else
			echo "<td align=center>异常</td>";


	
	//cp name
	$s = "select t1.id,t1.`name`,t2.ID,t2.cpname from mtrs_cp_product t1,mtrs_cp t2 where t1.cpID=t2.ID and t1.id=$row[3]";
	$r = exsql($s);
	$ro = mysqli_fetch_row($r);

	$r = exsql($s);
	$ro = mysqli_fetch_row($r);

	if(mysqli_num_rows($r))
	{	//cp
		echo "<td align=center>($ro[2])$ro[3]</td>";
		//cp_product
		echo "<td align=center>($ro[0])$ro[1]</td>";
	}	
	else{
		echo "<td align=center></td>";
		echo "<td align=center></td>";
	}
	
	
	
	
	
    /*
	//msgtype
	if($row[6]==1)
		echo "<td align=center>短信</td>";
	else if($row[6]==2)
		echo "<td align=center>彩信</td>";
	else
		echo "<td align=center>数据异常</td>";
	*/
	//deduction

	/*echo "<td align=center>";
	//display deduction
	echo "<display_deduction></display_deduction>";
	echo "<see_deductions style=''><a href='#'><img src='images/chakan.png' alt='总量限制' width=16 height=16></a></see_deductions>";
	//echo "&nbsp;";
	//echo "<add_deduction_commit value='$row[0]'><a href='#'>提交</a></add_deduction_commit>";
	echo "</td>";

	echo "<td align=center>";
	//display deduction
	echo "<display_deduction></display_deduction>";
	echo "<see_deduction style=''><a href='#'><img src='images/chakan.png' alt='单用户限制' width=16 height=16></a></see_deduction>";
	//echo "&nbsp;";
	//echo "<add_deduction_commit value='$row[0]'><a href='#'>提交</a></add_deduction_commit>";
	echo "</td>";*/

	echo "<td align=center>";
	//display cmd_mt
	echo "<display_cmd_mt></display_cmd_mt>";
	echo "<see_cmd_mt style=''><a href='#'><img src='images/chakan.png' alt='查看下行' width=16 height=16></a></see_cmd_mt>";
	echo "</td>";

	//开通省份
	$open_province = $row[7]?$row[7]:"默认全部开通";
	echo "<td align=center>$open_province</td>";
	//禁止地区
	echo "<td align=center>$row[8]</td>";
	
	//状态
	if($row[5]==1)
		echo "<td align=center>正常</td>";
	else if($row[5]==2)
		echo "<td align=center>关闭</td>";
	else
		echo "<td align=center>数据异常</td>";

	//modify
	//	echo "<td align=center>编辑</td>";


	echo "<td align=center><a href=\"cmd_edit.php?cmd_id=$row[0]\" ><img src='images/b_edit.png' alt='编辑'></a>&nbsp;</td>";
	//delete
	echo "<td align=center onclick=\"return ask($row[0]);\" ><a href=\"cmd_del.php?cmdid=$row[0]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
	echo"</tr>";
}
mysqli_free_result($result);
echo "</table>";
echo "</font>";

?>


</body>
