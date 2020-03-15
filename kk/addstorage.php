<?php
//ini_set("display_errors", 0);
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL ^ E_WARNING);

session_start();
if (($_SESSION['userid'] == '') || ($_SESSION['usertype'] <> '0'))
{
	die('<script language="javascript">top.location.href="loginexit.php"</script>');
}

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

//error_reporting(E_ALL);

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");

date_default_timezone_set("Asia/Shanghai");
$ordercode= date("ymdhis",time());

$checkedproduct = $_POST['checkedproduct'];
//$purchasearray=explode(',',$checkedproduct,1000000);

//---------------------------------------------------------
//在存储过程中判断是否可加，并返回是否加货成功
//flag在存储过程中相当于初始化一个会话变量，数据库运行时始终存在
//所以再在php中用select语句选出还在作用域内的会话变量flag
//通过mysql_result获取query得到的信息，即flag
//---------------------------------------------------------
$_SESSION['flag'] = 0;	//标记是否存储成功（存款是否足够）
$SQL = "call sp_addstorage('".$_SESSION['userid']."','". $checkedproduct."',@flag)";	//flag根据存储过程给的参数来
//echo $SQL; die();
if (mysql_query($SQL, $con)==false)  var_dump(mysql_error());
$SQL_get = "select @flag";
$_SESSION['flag'] = mysql_result(mysql_query($SQL_get, $con),0);	//	获取存储过程的输出

/*
if ($flag==1){
	$_SESSION['flag'] = 
	//echo "<html><head><script language=javascript>alert('存款不够！');</script></head></html>";
}
else{
	echo "<html><head><script language=javascript>alert('加货成功！');</script></head></html>";
}
*/

 
mysql_close($con);
$RS=NULL;
$Con =NULL;

 header("location:manageproduct0.php");
?>

