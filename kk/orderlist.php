
<?php
session_start();
if (($_SESSION['userid'] == '') || ($_SESSION['usertype'] <> '1')) 
{
	die('<script language="javascript">top.location.href="loginexit.php"</script>');
}

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");

date_default_timezone_set("Asia/Shanghai");

$userid=$_SESSION['userid'];
$usertype=$_SESSION['usertype'];

$productname = $_POST['productname'];
$SQL = "select ordercode, address, orderprice,ispay,orderid from t_order0 where  userid='". $userid ."'";
$SQL = $SQL. "and orderid in (select t_order0.orderid from t_orderdetail,t_product,t_order0 where t_orderdetail.productcode=t_product.productcode and t_orderdetail.orderid=t_order0.orderid and t_order0.userid='".$userid."' and productname like '%". $productname."%')";
    
//echo $SQL; die();
$RS0 = mysql_query($SQL, $con);
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
	
		//alert(bb);
		window.location.href="pay0.php?ordercode="+bb;
		
		/*
             document.form1.action = 'beginpay.php';
             document.form1.submit();
    */
 }
 function shanchu(bb)
	{
	
		//alert(bb);
		window.location.href="shanchu.php?ordercode="+bb;
	}
</script>
</HEAD>
<TITLE>用户订单</TITLE>

<BODY>
<form id=form1 name=form1 method=post>
搜索商品：<input type=text name=
>
<input type=submit value=搜索>

<input type=hidden id=checkedproduct name=checkedproduct>
</form>
<p></p>
<center>
<table  ID="SrhTable" border=1 width=100% cellpadding=0 cellspacing=1 align=center width=80%>
<tr>
<td>订单编码</td>
<td>配送地址</td>
<td>商品价格</td>
<td>采购数量</td>
<td>商品图片</td>
<td>订单价格</td>
<td>订单状态</td>
<td>删除</td>

</tr>

<?php
while($RS = mysql_fetch_array($RS0))
{
	$SQL1 = "select price,purchasenumber,productimage from t_orderdetail,t_order0 where  t_orderdetail.orderid=t_order0.orderid and userid='".$userid."' and ordercode='".strval($RS["ordercode"])."' ";
//	echo $SQL1; die();
	$RS1 = mysql_query($SQL1, $con);
?>
	<tr class="01">
	<td rowspan=<?php echo mysql_affected_rows($con) ?>><?php echo strval($RS["ordercode"])?></td>
	<td rowspan=<?php echo mysql_affected_rows($con) ?>><?php echo strval($RS["address"])?></td>

<?php
	$i = 0;
	while($RS2 = mysql_fetch_array($RS1))
	{
		if ($i>0) {
			echo "<tr>\n";
		}
	?>
	<td><?php echo strval($RS2["price"])?></td>	
	<td><?php echo strval($RS2["purchasenumber"])?></td>
	<td><img src=<?php echo strval($RS2["productimage"])?> width=86px height=84px></td>	
	<?php 
	if ($i==0) {
		?>
		<td class="02" rowspan=<?php echo mysql_affected_rows($con) ?>><?php echo strval($RS["orderprice"])?></td>
		<td class="03" rowspan=<?php echo mysql_affected_rows($con) ?>><?php
			if($RS["ispay"]==0){
				//查询是否超时，超时就改ispay
				$nowtime = date("ymdhis",time());
				$nowtime = intval(substr($nowtime,2));
				$gentime = intval(substr($RS['ordercode'],2));
				if ($nowtime - $gentime < 100){
					echo "<a href=javascript:beginpay(".$RS["ordercode"].")>未付款（点击付款） </a>";
				}
				else{
					//失效操作
					//1. ispay改成2
					$SQL3 = "update t_order0 set ispay='2' where ordercode='".$RS["ordercode"]."'";
					$temp = mysql_query($SQL3, $con);
					//2. 商品库存加回来
					$SQL5 = "select productcode from t_orderdetail,t_order0 where  t_orderdetail.orderid=t_order0.orderid and userid='".$userid."' and ordercode='".strval($RS["ordercode"])."' ";
					//echo $SQL5; die();
					$RS4 = mysql_query($SQL5, $con);
					while($RS5 = mysql_fetch_array($RS4))
					{
						$SQL4 = "update t_product set stocknumber=stocknumber+(";
						$SQL4 = $SQL4 . "select purchasenumber from t_orderdetail where orderid='" .$RS['orderid']. "' and productcode='" .$RS5['productcode']. "'";
						$SQL4 = $SQL4 . ") where productcode='" .$RS5['productcode']. "'";
						//echo $SQL4;die();
						$temp = mysql_query($SQL4, $con);
					}
					
					echo "已失效";
				}
			}
			else if($RS["ispay"]==1)
				echo "已付款";
			else
				echo "已失效"
		?></td>
		
		<td class="04" rowspan=<?php echo mysql_affected_rows($con) ?>><?php
		if($RS["ispay"]==0){
			?><a href=javascript:shanchu(<?php echo $RS["ordercode"] ?>)>删除</a><?php		
		}
		else
			echo "订单无法删除";
		?></td>
	</tr>
	<?php	
		}
		if ($i>0) {
			echo "</tr>\n";
		}
		$i++;
	}	

$RS1=NULL;

?>


<?php 
}
mysql_close($con);
$RS=NULL;
$Con =NULL;
?>

</table>

</html>
