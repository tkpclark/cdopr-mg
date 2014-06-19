<?php
require_once 'mysql.php';
$id = $_GET['id'];
$sql = "select id from wraith_message_complaint where id=$id";
$r=exsql($sql);
if(mysqli_num_rows($r)){
	echo 3;
}else{
	$sql="insert into wraith_message_complaint (id,motime,phone_number,mo_message,sp_number,linkid,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,gw_resp,gw_resp_time,report,report_time,province,area,cmdID,cmd_mocmd,cmd_spnumber,spID,sp_id,spname,serviceID,serv_mocmd,serv_spnumber,service_name,cpID,cpname,cp_productID,cp_product_name,forward_status,forward_mo_time,forward_mo_result,forward_mt_time,forward_mt_result)  select  id ,motime,phone_number,mo_message,sp_number,linkid,gwid,mo_status,fee,feetype,mt_message,service_id,msgtype,is_agent,gw_resp,gw_resp_time,report,report_time,province,area,cmdID,cmd_mocmd,cmd_spnumber,spID,sp_id,spname,serviceID,serv_mocmd,serv_spnumber,service_name,cpID,cpname,cp_productID,cp_product_name,forward_status,forward_mo_time,forward_mo_result,forward_mt_time,forward_mt_result from wraith_message_history where id=$id";
	$result=exsql($sql);
	if($result){
		echo 1;
	}else{
		echo 2;	
	}
}

?>