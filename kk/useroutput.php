
<?php

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$userid = "1";

$con = mysql_connect("localhost","root","sql");

mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");


//$sql1 = "select * from php_admin where userid='".$userid."'";
$SQL = "select userid,username,password from hhh";

//echo $sql1; die();
$RS0 = mysql_query($SQL, $con);
//print_r(mysql_fetch_array($RS0));
?>

<HTML>
<HEAD>
<style type="text/css">
<!--
font{font-family: "΢���ź�";font-size:9pt}
.font1{font-family: "΢���ź�";font-size:14.3px}
td{font-family: "΢���ź�";font-size:9pt}
a{text-decoration:none}
-->
</style>

</HEAD>
<TITLE>�û�����ʾ������ѧ�ã�</TITLE>

<BODY>
<form id=form1 name=form1 method=post>
<center>
<table  ID="SrhTable" border=0 width=100% cellpadding=0 cellspacing=1>


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
$Con =NULL;
?>

</table>


</html>
