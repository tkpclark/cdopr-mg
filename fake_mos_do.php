<?php
include("check.php"); 
$redis = new redis();  
$redis->connect('127.0.0.1', 6379);

$spnumber_mo_message = isset($_REQUEST['spnumber_mo_message'])?$_REQUEST['spnumber_mo_message']:"";
$arr = explode('-',$spnumber_mo_message);
$spnumber  = $arr[0];
$mo_message=$arr[1];
$service   =$arr[2];
$cmdID     =$arr[3];
$cp_productID =$arr[4];
$linkid =date("YmdH",time());

if(!isset($_FILES['phone_number']) || empty($linkid) || empty($spnumber) || empty($mo_message))
	exit;


$sql = "select fee,feetype,service_id,msgtype,spID,name from mtrs_service where ID=$service";
$result=exsql($sql);
$row=mysqli_fetch_row($result);
if(!empty($row)){
	$fee = $row[0];
	$feetype = $row[1];
	$service_id = $row[2];
	$msgtype = $row[3];
	$spid=$row[4];
	$servicename=$row[5];

	$sql = "select spname from mtrs_sp where ID=$spid";
	$resultsp=exsql($sql);
	$rowsp=mysqli_fetch_row($resultsp);
	$spname=$rowsp[0];
}else{
	exit;
}

$sql = "select cpID,name from mtrs_cp_product where ID=$cp_productID";
$result=exsql($sql);
$rows=mysqli_fetch_row($result);
if(!empty($rows)){
	$cpID = $rows[0];
	$cp_product_name = $rows[1];

	$sql = "select cpname from mtrs_cp where ID=$cpID";
	$resultcp=exsql($sql);
	$rowcp=mysqli_fetch_row($resultcp);
	$cpname=$rowcp[0];
}else{
	exit;
}


$first_file = $_FILES['phone_number'];  //获取文件1的信息

$upload_dir = './upload/'; //保存上传文件的目录
 if(!file_exists("./upload")){
       mkdir("./upload"); 
   }

//处理上传的文件1
if ($first_file['error'] == UPLOAD_ERR_OK){
    //上传文件1在服务器上的临时存放路径
    $temp_name = $first_file['tmp_name'];
    //上传文件1在客户端计算机上的真实名称
    $file_name = $first_file['name'];
    //移动临时文件夹中的文件1到存放上传文件的目录，并重命名为真实名称
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
				$province = '未知';
				$area     = '未知';
				$phone = sprintf("%s",$line);
				$phone = substr($phone,0,7);
				$redis->SELECT(1);
				$province_area = $redis->get($phone);
				if($province_area != null){
					$province_area = explode('_',$province_area);
					$province = $province_area[0];
					$area    = $province_area[1];
				}
				
				$redis->SELECT(2);
				$res = $redis->get($line);
				if(empty($res)){
					//echo "格式正确!<br>";
					$sql=sprintf("insert into wraith_message(mo_status,fee,feetype,service_id,msgtype,phone_number,mo_message,sp_number,linkid,gwid,motime,province,area,spID,spname,serviceID,service_name,cp_productID,cp_product_name,cpID,cpname,cmdID) values('ok','$fee','$feetype','$service_id','$msgtype','%s','$mo_message','$spnumber','$linkid','40',NOW(),'$province','$area','$spid','$spname','$service','$servicename','$cp_productID','$cp_product_name','$cpID','$cpname','$cmdID')",$line);
					//echo $sql;exit;
					exsql($sql);
					$count++;
				}

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
	}else{
		echo '上传失败';
	}
}else{
	
	echo "失败！ 原因：";
    switch($first_file['error']) {

    
	case 1:
		echo "文件大小超出了服务器的空间大小";
		break;

	case 2:
		echo "要上传的文件大小超出浏览器限制";
		break;
		 
	case 3:
		echo "文件仅部分被上传";
		break;
		 
	case 4:
		echo "没有找到要上传的文件";
		break;
		 
	case 5:
		echo "服务器临时文件夹丢失";
		break;
		 
	case 6:
		echo "文件写入到临时文件夹出错";
		break;
}
    exit;
}







?>