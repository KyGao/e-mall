<?php
session_start();
if (($_SESSION['userid'] == '') || ($_SESSION['usertype'] <> '1')) 
{
	die('<script language="javascript">top.location.href="loginexit.php"</script>');
}

ini_set("display_errors", 0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");

$ordercode=$_GET['ordercode'];
$userid=$_SESSION['userid'];


$SQL1 ="select orderid,ispay from t_order0 where ordercode='".$ordercode."'";
	$RS1 = mysql_query($SQL1, $con);
	if (mysql_affected_rows($con)>0)
{
	while($RS = mysql_fetch_array($RS1)){
		$orderid=$RS["orderid"];
		$ispay=$RS["ispay"];
	}
	$SQL2="delete from t_order0 where ordercode='".$ordercode."'";
	$RS2 = mysql_query($SQL2, $con);
	$SQL3="select purchasenumber,shangjiaid,productcode from t_orderdetail where orderid=".$orderid;
	$RS3 = mysql_query($SQL3, $con);
	if (mysql_affected_rows($con)>0)
{
	while($RS = mysql_fetch_array($RS3)){
	$pnumber=$RS["purchasenumber"];
	$shangjiaid=$RS["shangjiaid"];
	$productcode=$RS["productcode"];
	if($ispay=='0'){
	$SQL4="update t_product set stocknumber=stocknumber+".$pnumber." where productcode=".$productcode." and shangjiaid='".$shangjiaid."'";
	$RS4 = mysql_query($SQL4, $con);
	}
	
	}
	
}
$SQL5="delete from t_order0 where orderid=".$orderid;
	$RS5 = mysql_query($SQL5, $con);
	$con=0;
	header("location:orderlist.php");
}
?>