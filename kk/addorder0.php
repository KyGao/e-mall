
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

// 访问存储过程
// 存入订单号，买家id，地址，checkpoint(商品号，采购数量，卖家id)
$SQL = "call sp_addorder('".$ordercode."','".$_SESSION['userid']."','".$address."','". $checkedproduct."')";
//echo $SQL; die();
if (mysql_query($SQL, $con)==false)  
	var_dump(mysql_error());

// 把下订单的商品完整打印出来 
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
font{font-family: "微软雅黑";font-size:9pt}
.font1{font-family: "微软雅黑";font-size:14.3px}
td{font-family: "微软雅黑";font-size:9pt}
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
<TITLE>下单成功</TITLE>

<BODY>
<input type="button" value='跳转至付款界面' onClick="beginpay(<?php echo $ordercode ?>)">
	配送地址：<?php echo $address?>


<p></p>
<center>
<table  ID="SrhTable" border=0 width=100% cellpadding=0 cellspacing=1>
<tr>

<td>订单编码</td>
<td>商品编码</td>
<td>商品价格</td>
<td>采购数量</td>
<td>商品图片</td>
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
