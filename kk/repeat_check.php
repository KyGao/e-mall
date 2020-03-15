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
$sf=$_GET["sf"];
$response=0;
    if($sf==1)
		$sql1 = "select userid from php_admin where userid='".$userid."'";
	else if($sf==0)
		$sql1 = "select shangjiaid from shangjia where shangjiaid='".$userid."'";
	
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
