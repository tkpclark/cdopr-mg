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
		   jQuery.extend({

setTable:function () {
	//alert("it's my func!");
	$.get("cmd_list.php",function(result){
	$("body").replaceWith(result);
	});
	}
	});
		//$.setTable();
		 */
		$("see_deduction").click(function(){
			var cmd=$(this);
			var cmd_id=$(this).parent().parent("tr").children("td:eq(0)").text();
			//var cmd_id=$(this).text();
			//alert(cmd_id);
			$.get("cmd_display_visit_limit.php?cmd_id="+cmd_id,function(result){
				$(cmd).prev().replaceWith(result);
				});
			});
		
		//$("see_deduction").click();



});
</script>
</head>
<body>

<?php
echo "<body>";
echo "<font size=4><caption>指令列表>></caption></font>
<br><br>
<font size=3><a href='cmd_edit.php'>添加</a></font><br>

<table border='1' cellspacing='0' cellpadding='1' width='90%' class='tabs'>

<tr>
<th>序号</th>
<th>指令</th>
<th>黑名单检测</th>
<th>所属通道</th>
<th>所属通道业务</th>
<th>资费</th>
<th>使用渠道</th>
<th>使用渠道业务</th>
<th>查看日/月限</th>
<th>开通省份</th>
<th>禁止地区</th>
<th>状态</th>
<th>编辑</th>
<th>删除</th>
</tr>";
$buf= "SELECT * FROM mtrs_cmd";
//echo $buf;
$result=exsql($buf);

echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
while($row=mysqli_fetch_row($result))
{
	echo"<tr>";
	//seq
	echo "<td align=center><font size=2>$row[0]</td>";

	//cmd(spnumber+mocmd)precise
	echo "<td align=center><font size=2>$row[1]+$row[2]</td>";

	//checkblk
	  if($row[10]==1)
			echo "<td align=center><font size=2>是</td>";
		else
			echo "<td align=center><font size=2>否</td>";
	
	$s = "select t1.id,t1.sp_number,t1.mo_cmd,name,fee,gwid,t2.id,t2.spname from mtrs_service t1,mtrs_sp t2 where t1.id=$row[4] and t1.spID=t2.ID";
	$r = exsql($s);
	$ro = mysqli_fetch_row($r);

	if(mysqli_num_rows($r))
	{	//sp
		echo "<td align=center><font size=2>($ro[6])$ro[7]</td>";
		//service
		echo "<td align=center><font size=2>($ro[0])$ro[3]-$ro[1]+$ro[2]</td>";
		//fee
		echo "<td align=center><font size=2>$ro[4]</td>";
	}	
	else{
		echo "<td align=center><font size=2></td>";
		echo "<td align=center><font size=2></td>";
		echo "<td align=center><font size=2></td>";
	}
	
	

	
	//cp name
	$s = "select t1.id,t1.`name`,t2.ID,t2.cpname from mtrs_cp_product t1,mtrs_cp t2 where t1.cpID=t2.ID and t1.id=$row[3]";
	$r = exsql($s);
	$ro = mysqli_fetch_row($r);

	$r = exsql($s);
	$ro = mysqli_fetch_row($r);

	if(mysqli_num_rows($r))
	{	//cp
		echo "<td align=center><font size=2>($ro[2])$ro[3]</td>";
		//cp_product
		echo "<td align=center><font size=2>($ro[0])$ro[1]</td>";
	}	
	else{
		echo "<td align=center><font size=2></td>";
		echo "<td align=center><font size=2></td>";
	}
	
	
	
	
	
    /*
	//msgtype
	if($row[6]==1)
		echo "<td align=center><font size=2>短信</td>";
	else if($row[6]==2)
		echo "<td align=center><font size=2>彩信</td>";
	else
		echo "<td align=center><font size=2>数据异常</td>";
	*/
	//deduction

	echo "<td align=center>";
	//display deduction
	echo "<display_deduction></display_deduction>";
	echo "<see_deduction style=''><a href='#'>查看日/月限</a></see_deduction>";
	//echo "&nbsp;";
	//echo "<add_deduction_commit value='$row[0]'><a href='#'>提交</a></add_deduction_commit>";
	echo "</td>";
	//开通省份
	$open_province = $row[8]?$row[8]:"默认全部开通";
	echo "<td align=center><font size=2>$open_province</td>";
	//禁止地区
	echo "<td align=center><font size=2>$row[9]</td>";
	
	//状态
	if($row[5]==1)
		echo "<td align=center><font size=2>正常</td>";
	else if($row[5]==2)
		echo "<td align=center><font size=2>关闭</td>";
	else
		echo "<td align=center><font size=2>数据异常</td>";

	//modify
	//	echo "<td align=center><font size=2>编辑</td>";


	echo "<td align=center><font size=2><a href=\"cmd_edit.php?cmd_id=$row[0]\" >编辑</a>&nbsp;</td>";
	//delete
	echo "<td align=center onclick=\"return ask($row[0]);\" ><font size=2><a href=\"cmd_del.php?cmdid=$row[0]\" >删除</a>&nbsp;</td>";
	echo"</tr>";
}
mysqli_free_result($result);
echo "</table>";
echo "</font>";

?>


</body>
