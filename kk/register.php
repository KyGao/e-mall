<?php
ini_set("display_errors", 0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");


$response=0;
$sf=$_GET["sf"];
if($sf==1){
	$userid=$_GET["userid"];
	$username=$_GET["username"];
	$password=$_GET["password"];
	$cunkuan=$_GET["cunkuan"];
	$sql = "insert into php_admin values('".$userid."','".$username."','".$password."','1','".$cunkuan."')";
	//echo $sql;die();
}
else if($sf==0){
	$shangjiaid=$_GET["shangjiaid"];
	$shangjianame=$_GET["shangjianame"];
	$password=$_GET["password"];
	$cunkuan=$_GET["cunkuan"];
	$address=$_GET["address"];
	$sql = "insert into shangjia values('".$shangjiaid."','".$shangjianame."','".$password."','0','".$cunkuan."',0,'".$address."')";
	//echo $sql;die();
}

mysql_query($sql);

if($sf==1){
	$sql1 = "select userid from php_admin where userid='".$userid."'";
}
else if($sf==0){
	$sql1 = "select shangjiaid from shangjia where shangjiaid='".$shangjiaid."'";
}
$RS0 = mysql_query($sql1, $con);

if (mysql_affected_rows($con)>0)	//若写入成功，即查询到此条信息
    $response=1;
	
echo $response;

?>