
<?php
session_start();
if (($_SESSION['userid'] == '') || ($_SESSION['usertype'] <> '0')) 
{
	die('<script language="javascript">top.location.href="loginexit.php"</script>');
}

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");

$gett=$_GET['gett'];
$userid=$_SESSION['userid'];
$usertype=$_SESSION['usertype'];

if($gett==1){
	$ordercode1=$_GET['ordercode'];
	$buyerid=$_GET['buyerid'];
	 
	//����Ϊ"�ѷ���"״̬
 	$SQL4="update t_express set status='2' where ordercode='".$ordercode1."' and userid='".$buyerid."'";
 	//echo $SQL4;die();
 	$RS4 = mysql_query($SQL4, $con);
}

$productname = $_POST['productname'];
$SQL = "select ordercode, address, sjaddress , status ,userid from t_express where  shangjiaid='". $userid ."'";
$SQL = $SQL. "and orderid in (select t_express.orderid from t_orderdetail,t_product,t_express where t_orderdetail.productcode=t_product.productcode and t_orderdetail.orderid=t_express.orderid and t_orderdetail.shangjiaid=t_express.shangjiaid and t_express.shangjiaid='".$userid."' and productname like '%". $productname."%')";
//echo $SQL; die();
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

<script language=javascript>
	
 function beginship(ordercode_temp,userid_temp)
{	
	//alert(userid_temp);
	window.location.href="mydeliver.php?ordercode="+ordercode_temp+"&buyerid="+userid_temp+"&gett="+1;
		
 }
</script>
</HEAD>
<TITLE>��������</TITLE>

<BODY>



<p></p>
<center>
<table  ID="SrhTable" border=1 width=100% cellpadding=0 cellspacing=1 align=center width=80%>
<tr>
<td>��������</td>
<td>���͵�ַ</td>
<td>������ַ</td>
<td>��Ʒ�۸�</td>
<td>�ɹ�����</td>
<td>��ƷͼƬ</td>
<td>��Һ�</td>
<td>���״̬</td>

</tr>

<?php
	while($RS = mysql_fetch_array($RS0))
	{
		$SQL1 = "select price,purchasenumber,productimage from t_orderdetail,t_express where t_orderdetail.orderid=t_express.orderid and t_orderdetail.shangjiaid=t_express.shangjiaid and t_express.shangjiaid='".$userid."' and ordercode='".strval($RS["ordercode"])."' ";
		//	echo $SQL1; die();
		$RS1 = mysql_query($SQL1, $con);
?>

<tr class="01">
	<td rowspan=<?php echo mysql_affected_rows($con) ?>><?php echo strval($RS["ordercode"])?></td>
	<td rowspan=<?php echo mysql_affected_rows($con) ?>><?php echo strval($RS["address"])?></td>
	<td rowspan=<?php echo mysql_affected_rows($con) ?>><?php echo strval($RS["sjaddress"])?></td>

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
		if ($i==0) 
		{
?>

  	<td class="02" rowspan=<?php echo mysql_affected_rows($con) ?>><?php echo strval($RS["userid"])?></td>

	<!--���δ��������beginship�����޸�״̬������mydeliver�޸����ݿ�-->
  	<td class="03" rowspan=<?php echo mysql_affected_rows($con) ?>><?php
		if($RS["status"]==1)
			echo "<a href=javascript:beginship('".$RS["ordercode"]."','".$RS["userid"]."')> δ��������������� </a>";
		else if($RS["status"]==2)
			echo "��ǩ��";
		else if($RS["status"]==3)
			echo "��ǩ��"
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
