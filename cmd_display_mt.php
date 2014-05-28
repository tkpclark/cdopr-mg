<head>
<script>
$(document).ready(function(){	
		//delete deduction
		$("mt_del").click(function(){
			var cmd=$(this);
			var mt_id=$(this).attr("value");
			//alert($(this).attr("value"));
			$.get("cmd_del_mt.php?id="+mt_id,function(result){
					var cmd_id=$(cmd).parent().parent().parent().parent().parent().parent().parent("tr").children("td:eq(0)").text();
					//cmd_id=$(cmd).text();
					//alert("delete"+cmd_id);
						$.get("cmd_display_mt.php?cmd_id="+cmd_id,function(result){
							//alert($(cmd).parent().parent().children("display_deduction").text());
	    					$(cmd).parent().parent().parent().parent().parent().parent().children("display_cmd_mt").replaceWith(result);
	    			});
			});	
		});

		$("strong").click(function(){$(this).parent().replaceWith("<display_cmd_mt></display_cmd_mt>");});
		$("add_mt").click(function(){

				var add_mt=$(this);
				//alert($(this).parent().parent().parent("tr:eq(0)").children("td:eq(0)").text());
				//alert($(tr_old).children("td:eq(1)").text());
				//alert($(this).attr("value"));

				var cmd_id=$(add_mt).parent().parent().parent("tr:eq(0)").children("td:eq(0)").text();


				$.get("cmd_edit_mt.php?id="+cmd_id,function(result){
					$(add_mt).before(result);

					$("#mt_submit").click(function(){
						//alert($("#deduction_value").val()+" "+$("#area_code").find("option:selected").text());
						var add_mt_url="cmd_add_mt.php?cmd_id="+cmd_id+"&content="+$("#content").val();
						//alert(add_mt_url);
						$.get(add_mt_url,function(result){
							//alert(result);
							$("edit_mt").remove();

							$.get("cmd_display_mt.php?cmd_id="+cmd_id,function(result){
								$(add_mt).parent().replaceWith(result);


								});



							});
						});
				});
		});
});
</script>
</head>
<?php

		require_once("check.php");
	
		if(!isset($_GET['cmd_id']))
		{
			echo "no argument cmd_id";
		}
		$cmd_id=$_GET['cmd_id'];
		echo "<display_cmd_mt style='position:absolute;top:30%;left:50%;margin-left:-300px;z-index:2;display:block; width:600px;background:#fff;border:1px solid #85B6E2;' }><strong style='background:#15B6E2;width:100%;display:block;padding-top:3px;text-align:right;border-bottom:1px solid #85B6E2;'>关闭&nbsp;&nbsp;&nbsp;&nbsp;</strong>";
		$sql="select content,id from mtrs_cmd_mt where cmdID='$cmd_id'";
		$result=exsql($sql);
		while($row=mysqli_fetch_row($result))
		{
			echo "<table style='border-style:none ;background:#fff'><tr>";
			echo "<td style='border:1px solid #F4F6FD;border-bottom:1px solid #85B6E2'>".$row[0]."</td>";
			echo "<td style='border:1px solid #F4F6FD;border-bottom:1px solid #85B6E2' width=10%><mt_del value='$row[1]'><a href=#>删除</a></mt_del></td>";
			//echo "<deduction_modi><a href=#>改</a></deduction_modi>";
			echo "</tr></table>";
		}
		echo "<br><add_mt><a href='#'>添加下行</a></add_mt>";
		echo "</display_cmd_mt>";
?>