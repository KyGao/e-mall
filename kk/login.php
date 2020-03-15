<?php
ini_set("display_errors", 0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);

//开启会话，以下两个变量在页面中持续有效
session_start();
$_SESSION['userid']='';
$_SESSION['usertype']='';

//控制编码
header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

//连接数据库
$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");

//获取clienthint.js来访问的值
$userid=$_GET["userid"];	//GET可以通过网页传参
$password=$_GET["password"];
$sf=$_GET["sf"];
$response=-1;	//初始化response
if($userid==""||$password=="")	
	$response=0;	//若都为空则返回0
else{
	//根据用户身份（买家/卖家）决定SQL语句
	if($sf==1)
		$sql1 = "select userid,usertype from php_admin where userid='".$userid."' and password='".$password."'";
	else if($sf==0)
		$sql1 = "select shangjiaid,usertype from shangjia where shangjiaid='".$userid."' and password='".$password."'";
	//访问数据库
	$RS0 = mysql_query($sql1, $con);
	//
	if (mysql_affected_rows($con)>0)
	{
		$RS = mysql_fetch_array($RS0);
		if($sf==1){
			$_SESSION['userid'] = $RS['userid'];
			$_SESSION['usertype'] ="1";
		}
		else{
			$_SESSION['userid'] = $RS['shangjiaid'];
			$_SESSION['usertype'] ="0";
		}
		$response=2;	//成功写入且更新了Session的变量
	}
	else
		$response=1;	//找不到匹配的信息

}

echo $response;
?>