
<?php
session_start();
if (($_SESSION['userid'] == '') || ($_SESSION['usertype'] <> '1'))
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
$address= $_POST['address'];
//$purchasearray=explode(',',$checkedproduct,1000000);

// ���ʴ洢����
// ���붩���ţ����id����ַ��checkpoint(��Ʒ�ţ��ɹ�����������id)
$SQL = "call sp_addorder('".$ordercode."','".$_SESSION['userid']."','".$address."','". $checkedproduct."')";
//echo $SQL; die();
if (mysql_query($SQL, $con)==false)  
	var_dump(mysql_error());

// ���¶�������Ʒ������ӡ���� 
$SQL1 = "select ordercode,productcode,price,purchasenumber,productimage,address from t_order0, t_orderdetail ";
$SQL1 = $SQL1. " where t_order0.orderid=t_orderdetail.orderid and ispay='0' and userid='". $_SESSION['userid'] ."' and ordercode= '".  $ordercode ."'";
//echo $SQL1; die();
$RS0 = mysql_query($SQL1, $con);

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
<script language=javascript>
	function beginpay(bb)
	{
	
	//	alert(bb);
		window.location.href="pay0.php?ordercode="+bb;
		
 	}
</script>

</HEAD>
<TITLE>�µ��ɹ�</TITLE>

<BODY>
<input type="button" value='��ת���������' onClick="beginpay(<?php echo $ordercode ?>)">
	���͵�ַ��<?php echo $address?>


<p></p>
<center>
<table  ID="SrhTable" border=0 width=100% cellpadding=0 cellspacing=1>
<tr>

<td>��������</td>
<td>��Ʒ����</td>
<td>��Ʒ�۸�</td>
<td>�ɹ�����</td>
<td>��ƷͼƬ</td>
</tr>

<?php
	while($RS = mysql_fetch_array($RS0))
	{
?>
<tr>

<td><?php echo strval($RS["ordercode"])?></td>
<td><?php echo strval($RS["productcode"])?></td>
<td><?php echo strval($RS["price"])?></td>
<td><?php echo strval($RS["purchasenumber"])?></td>
<td><?php echo "<img src=" . strval($RS["productimage"])." width=86px height=84px>"?></td></tr>

<?php 
	}
	mysql_close($con);
	$RS=NULL;
	$Con =NULL;
?>

</table>

</html>
