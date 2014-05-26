<head>
<script>
$(document).ready(function(){	
		//delete deduction
		$("deduction_del").click(function(){
			var cmd=$(this);
			var deduction_id=$(this).attr("value");
			//alert($(this).attr("value"));
			$.get("cmd_del_deduction.php?id="+deduction_id,function(result){
					var cmd_id=$(cmd).parent().parent().parent("tr").children("td:eq(0)").text();
					//cmd_id=$(cmd).text();
					//alert("delete"+cmd_id);
						$.get("cmd_display_deduction.php?cmd_id="+cmd_id,function(result){
							//alert($(cmd).parent().parent().children("display_deduction").text());
	    					$(cmd).parent().parent().children("display_deduction").replaceWith(result);
	    			});
			});	
		});

		$("strong").click(function(){$(this).parent().replaceWith("<display_deduction></display_deduction>");});
		$("add_deduction").click(function(){

				var add_deduction=$(this);
				//alert($(this).parent().parent().parent("tr:eq(0)").children("td:eq(0)").text());
				//alert($(tr_old).children("td:eq(1)").text());
				//alert($(this).attr("value"));

				var cmd_id=$(add_deduction).parent().parent().parent("tr:eq(0)").children("td:eq(0)").text();


				$.get("cmd_edit_deduction.php?id="+cmd_id,function(result){
					$(add_deduction).before(result);

					$("#deduction_submit").click(function(){
						//alert($("#deduction_value").val()+" "+$("#area_code").find("option:selected").text());
						var add_deduction_url="cmd_add_deduction.php?cmd_id="+cmd_id+"&province="+$("#province").find("option:selected").val()+"&deduction_value="+$("#deduction_value").val();
						//alert(add_deduction_url);
						$.get(add_deduction_url,function(result){
							//alert(result);
							$("edit_deduction").remove();

							$.get("cmd_display_deduction.php?cmd_id="+cmd_id,function(result){
								$(add_deduction).parent().replaceWith(result);


								});



							});
						});
				});
		});
});
</script>
</head>
<?php

		require_once("area_code.php");
		require_once("check.php");
	
		if(!isset($_GET['cmd_id']))
		{
			echo "no argument cmd_id";
		}
		$cmd_id=$_GET['cmd_id'];
		echo "<display_deduction style='position:absolute;top:30%;left:50%;margin-left:-150px;z-index:2;display:block; width:300px;background:#fff;border:1px solid #85B6E2;'><strong style='width:98%;display:block;padding-top:3px;text-align:right;border-bottom:1px solid #85B6E2;'>关闭</strong>";
		$sql="select zone,deduction,ID from mtrs_deduction where cmdID='$cmd_id'";
		$result=exsql($sql);
		while($row=mysqli_fetch_row($result))
		{
				$zone=$row[0];
				
			$per=100*$row[1];
				
			echo $zone."&nbsp;扣&nbsp;".$per."%&nbsp;";
			echo "<deduction_del value='$row[2]'><a href=#>删&nbsp;</a></deduction_del>";
			//echo "<deduction_modi><a href=#>改</a></deduction_modi>";
			echo "<br>";
		}
		echo "<add_deduction><a href='#'>添加扣量</a></add_deduction>";
		echo "</display_deduction>";
?>