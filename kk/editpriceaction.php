<?php
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

$SQL = "call sp_editprice('".$_SESSION['userid']."','". $checkedproduct."')";
//echo $SQL; die();
if (mysql_query($SQL, $con)==false)  var_dump(mysql_error());

 
mysql_close($con);
$RS=NULL;
$Con =NULL;

 header("location:editprice.php");
?>

