
<?php

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$userid = $_POST["userid"];
$username = $_POST["username"];
$password = $_POST["password"];

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");

$sql = "insert into php_admin values('".$userid."','".$username."','".$password."')";

mysql_query($sql);
//echo $sql; die();

$sql1 = "select * from php_admin where userid='".$userid."'";
//echo $sql1; die();
$RS0 = mysql_query($sql1);
?>

<table>

<?php
while($RS = mysql_fetch_array($RS0))
{
?>
<tr><td><?php echo strval($RS["userid"])?></td>
<td><?php echo strval($RS["username"])?></td>
<td><?php echo strval($RS["password"])?></td></tr>

<?php 
}
mysql_close($con);
$RS=NULL;
$Conn =NULL;
?>

</table>


</html>
