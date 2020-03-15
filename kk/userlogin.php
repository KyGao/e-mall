<?php

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

session_start();
$_SESSION['userid']='';
$_SESSION['usertype']='';

$userid = $_POST['userid'];
$password = $_POST['password'];

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");

$sql1 = "select userid,usertype from php_admin where userid='".$userid."' and password='".$password."'";
//echo $sql1; die();
$RS0 = mysql_query($sql1, $con);
if (mysql_affected_rows($con)>0)
{
	$RS = mysql_fetch_array($RS0);
	$_SESSION['userid'] = $RS['userid'];
	$_SESSION['usertype'] = $RS['usertype'];
	header("location: main.php");
}  
else
{
	header("location: userlogin.htm");
}

?>

<html>
<body>

<?php
//retrieve session data
mysql_close($con);
$RS=NULL;
$con =NULL;
?>

</body>
</html>