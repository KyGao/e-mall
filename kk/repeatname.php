<?php
ini_set("display_errors", 0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");
session_start();

$userid=$_GET["userid"];
$pdname=$_GET["pdname"];
$response=0;

   
$sql1 = "select shangjiaid from t_product where shangjiaid='".$userid."' and productname='".$pdname."'";
	//$response=$sql1;
	//echo $sql1 ;die();
$RS0 = mysql_query($sql1, $con);
if (mysql_affected_rows($con)>0)
    $response=1;
	
echo $response;

?>
<?php
//retrieve session data
mysql_close($con);
$RS=NULL;
$con =NULL;
?>
