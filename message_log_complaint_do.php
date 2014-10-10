<?php
include("check.php"); 
include("style.php");
set_time_limit(0);

if(!isset($_FILES['myfile']))
	exit;

$first_file = $_FILES['myfile']; 
$upload_dir = './upload/';
 if(!file_exists("./upload")){
       mkdir("./upload"); 
   }

$type=$_POST['type'];
if ($first_file['error'] == 0){
    $temp_name = $first_file['tmp_name'];
    $file_name = $first_file['name'];
    if(move_uploaded_file($temp_name, $upload_dir.$file_name)){
		echo '上传成功!  开始导入...<br/><br/><br/>';

		$file_handle = fopen($upload_dir.$file_name, "r");
		$count=0;
		while (!feof($file_handle)) {
			$line = trim(fgets($file_handle));
			if($line=='')
				continue;
			if(1)
			{	
				$str=MD5($line."Linktech");

				$sql="insert into wraith_message_complaint select *,NOW(),'$line' from wraith_message_history where phone_number='$str' and report='1' and cp_product_name like '%$type%' and id not in (select id from wraith_message_complaint);";
				$result = exsql($sql);
				$count++;
			}
			else
			{
				$a=strlen($line);
				echo $a;
				echo "<font color='red'>[".$line."] 格式错误!忽略</font><br>";
			}	
		}
		fclose($file_handle);
		echo "<br><br>成功导入".$count."个号码!";

	}
}


/*
	$sql="insert into wraith_message_complaint (id,motime,phone_number,mo_message,sp_number,linkid,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,gw_resp,gw_resp_time,report,report_orig,report_time,province,area,cmdID,cmd_mocmd,cmd_spnumber,spID,sp_id,spname,serviceID,serv_mocmd,serv_spnumber,service_name,cpID,cpname,cp_productID,cp_product_name,forward_status,forward_mo_time,forward_mo_result,forward_mo_resp,forward_mo_url,forward_mr_time,forward_mr_result,forward_mr_resp,forward_mr_url)  select  id,motime,phone_number,mo_message,sp_number,linkid,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,gw_resp,gw_resp_time,report,report_orig,report_time,province,area,cmdID,cmd_mocmd,cmd_spnumber,spID,sp_id,spname,serviceID,serv_mocmd,serv_spnumber,service_name,cpID,cpname,cp_productID,cp_product_name,forward_status,forward_mo_time,forward_mo_result,forward_mo_resp,forward_mo_url,forward_mr_time,forward_mr_result,forward_mr_resp,forward_mr_url from wraith_message_history where id=$id";
*/


function write($wjm,$nr){
       $fq=fopen($wjm,"a");
	   if(flock($fq,LOCK_EX)){
	   fwrite($fq,$nr);
	   flock($fq,LOCK_UN);
	   }else{
	   echo "锁定失败";
	   }
       fclose($fq);

}

?>