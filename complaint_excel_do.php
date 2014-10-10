<?php
include("check.php");

if(!isset($_FILES['userfile']))
	exit;
$first_file = $_FILES['userfile'];  //获取文件1的信息

//$upload_dir = '/tmp/upload/'; //保存上传文件的目录
$upload_dir = './upload/'; 
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
		$file_handle = fopen($upload_dir.$file_name, "r");
		$phone_numbers='';
		$name=("被投诉渠道.xls");
        iconv("UTF-8", "GBK", $name);
        header("Content-Type: application/vnd.ms-excel;charset=GBK"); 
        header("Content-Disposition:attachment;filename=$name");
		while (!feof($file_handle)) {
			$line = trim(fgets($file_handle));
			if($line=='')
				continue;
			if(1)
			{
				$phone_number=sprintf("%s",$line);
				$sql="select phone_number , cpname ,cp_product_name,motime,province from wraith_message_history where phone_number='$phone_number' and motime>='2014-07-01 00:00:00' and mo_status!='老数据' and feetype='1'";
				$result=exsql($sql);
				$rows=array();
				while($row=mysqli_fetch_row($result))
				{
					$rows[]=$row;
				}
				//获取渠道
				$sql="select DISTINCT(cpname) from wraith_message_history where phone_number='$phone_number' and motime>='2014-07-01 00:00:00' and mo_status!='老数据' and feetype='1'";
				$result=exsql($sql);
				$rows_qudao=array();
				while($row_qudao=mysqli_fetch_row($result))
				{
					$rows_qudao[]=$row_qudao[0];
				}
		
				
				foreach($rows_qudao as $r_q){
					$num=0;
					$time='';
					foreach($rows as $r){
						if($r[1]==$r_q){
							$num+=1;
							$time.=$r[3].'/';
						}
						$province=$r['4'];
					}
					echo iconv("UTF-8", "GBK",$phone_number."\t".$province."\t".$r_q."\t".$num."\t".$time."\t\n");
				}

				
				


			}		
			//$phone_numbers.=$phone_number;
		}
		fclose($file_handle);




		/*$phone_numbers=substr($phone_numbers,0,strlen($phone_numbers)-1);
		$sql="set names utf8";
		exsql($sql);
		$sql="select distinct phone_number , cpname , province from wraith_message_history where phone_number in ($phone_numbers)";
		//echo $sql; exit;
		$result=exsql($sql);
		$rows=array();
		while($row=mysqli_fetch_row($result))
		{
			$rows[]=$row;
		}
		//$rowss['count']=mysqli_num_rows($result);
		//print_r($rows);exit;
		//导出
		$name=("被投诉渠道.xls");
        iconv("UTF-8", "GBK", $name);
        header("Content-Type: application/vnd.ms-excel;charset=GBK"); 
        header("Content-Disposition:attachment;filename=$name");   
        //表头
        echo iconv("UTF-8", "GBK","手机号码\t");echo iconv("UTF-8", "GBK","渠道名称\t");echo iconv("UTF-8", "GBK","省份\t\n");
        //内容
        foreach($rows as $v){
            echo iconv("UTF-8", "GBK",$v[0]."\t".$v[1]."\t".$v[2]."\t\n");
        }
        exit;*/
		
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
