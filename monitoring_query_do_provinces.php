<?php
include("check.php");

$parameter = isset($_GET['parameter'])?$_GET['parameter']:'';
$arr = explode('-',$parameter);
if(count($arr)==3){
	list($cmdid,$area,$type)=$arr;
	if(!empty($cmdid) && !empty($area) && !empty($type)){
		$sql= "SELECT open_province FROM mtrs_cmd where ID=$cmdid";
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		if(!empty($row[0])){
			if($type==2){
				$province = str_replace($area,'',$row[0]);
			}else{
				$province=$row[0].' '.$area;
			}
		}else{
			$province=$area;
		}
		
		$sql = "update mtrs_cmd set open_province='$province' where ID='$cmdid' ";
		$result=exsql($sql);
		if($result){
			echo 1;
		}
	}
}elseif(count($arr)==2){

	echo "<script>
		$('strong').click(function(){
			$('.see_area_open').replaceWith('<div class=see_area></div>');
		})
//修改禁止市区
		$('.content').click(function(){
			var cmdid = $(this).attr('_num');
			var area = $(this).attr('_area');
			var obj = $(this);
			if(obj.has('textarea').length){
				return;
			}
			var org = obj.html();
			var wid = obj.css('width');
			obj.html('');
			if(org=='没有禁止市区'){ var org_obj='';}else{ var org_obj=org;}
			obj.append('<textarea>'+org_obj+'</textarea>'); 
			var input = obj.find('textarea');
			input.focus();
			input.blur(function(){
			  var inputval = input.val();
			  if(inputval==''){ var inputval_obj='没有禁止市区';}else{ var inputval_obj=inputval;}
			  if(inputval=='' && org=='没有禁止市区'){inputval='没有禁止市区'}
			  obj.empty();
			  obj.html(inputval_obj);
			  $.ajax({
				   type: 'GET',
				   url: 'monitoring_query_do_provinces_ajax.php?forbidden_area='+inputval+'&cmdid='+cmdid+'&area='+area,
				   cache:false,
				   success: function(msg){
					if(msg!=1){
						alert('失败');
					}
				   }
				});
			});
		})
	</script>";

	list($cmdid,$area)=$arr;
	if(!empty($cmdid) && !empty($area)){
		$sql = "select forbidden_area from mtrs_cmd where ID= ".$cmdid;	
		$result=exsql($sql);
		$row=mysqli_fetch_row($result);
		$count = substr_count($row[0],$area);
		$str=$row[0];
		for($i=1;$i<=$count;$i++){
			if($i==$count && !strpos($str,' ',strpos($str,trim($area)))){
				$alert.=substr($str,strpos($str,trim($area))).' ';
			}else{
				$alert.=substr($str,strpos($str,trim($area)),strpos($str,' ',strpos($str,trim($area)))-strpos($str,trim($area))).' ';
			}
			$str = trim(substr($str,strpos($str,' ',strpos($str,trim($area)))));
		}
		if(empty($alert)){$alert='没有禁止市区';}
		echo "<div style='position:absolute;top:30%;left:50%;margin-left:-300px;z-index:2;display:block; width:600px;background:#fff;border:1px solid #85B6E2;height:200px;' class='see_area_open'><strong style='background:#15B6E2;width:100%;display:block;padding-top:3px;text-align:right;border-bottom:1px solid #85B6E2;'>关闭&nbsp;&nbsp;&nbsp;&nbsp;</strong><div style='text-align:center;padding-top:30px;' class='content' _num='$cmdid' _area='$area'>$alert</div></div>";
	}
}

?>



