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

//	����֮ǰ��Ҫ����֤����
$ordercode=$_GET['ordercode'];
$userid=$_SESSION['userid'];
$sql1 = "select password from php_admin where userid='".$userid."'";
$RS0 = mysql_query($sql1, $con);

if (mysql_affected_rows($con)>0){
	while($RS = mysql_fetch_array($RS0)){
	$password=$RS["password"];	
	}
}
$dan="";	//��־�Ƿ�����ݿ�����ɹ�
//���µ�HTML����ɹ�submit�˾ͻᴫ����ggt��ordercode1��������
$ggt=$_POST['ggt'];		//ֻҪsubmit�˼�match�ˣ�value�ͺ�Ϊ1
$ordercode1=$_POST['ordercode1'];
if($ggt==1){
	//	1. ordercodeƥ������ݽ�ispay��Ϊ1�����ɹ�����
	$SQL0 = "update t_order0 set ispay='1' where ordercode='".$ordercode1."'";
    $RS0 = mysql_query($SQL0, $con);
	
	//	��ѯ����Ŀ��ordercode1
	//	2. ������Ҵ��
	//	3 ���ӵ������Ϣ
    $SQL1 ="select orderprice,orderid from t_order0 where ordercode='".$ordercode1."'";
	$RS1 = mysql_query($SQL1, $con);
	if (mysql_affected_rows($con)>0)
	{
		while($RS = mysql_fetch_array($RS1)){
			$orderprice=$RS["orderprice"];
			$orderid=$RS["orderid"];
		}
		$SQL2="update php_admin set cunkuan=cunkuan-".$orderprice." where userid='".$userid."'";
		$RS2 = mysql_query($SQL2, $con);
		$SQL6 = "insert into t_express(ordercode,shangjiaid,address,sjaddress,userid,orderid) select ordercode,tt.shangjiaid,tt.address,shangjia.address,userid,orderid from(select distinct ordercode,shangjiaid,address,userid,orderid from t_order0 NATURAL INNER JOIN t_orderdetail where orderid=".$orderid." and ispay='1') as tt,shangjia where tt.shangjiaid=shangjia.shangjiaid";
		//echo $SQL6;die();
		$RS6 = mysql_query($SQL6, $con);
	}

	//	��ѯt_orderdetail�����з���������orderid
	//	4. ���Ҵ�����ӣ���������
   	$SQL3="select shangjiaid from t_orderdetail where orderid=".$orderid;
   	$RS3 = mysql_query($SQL3, $con);
   	if (mysql_affected_rows($con)>0)
	{
		while($RS = mysql_fetch_array($RS3)){
			$shangjiaid=$RS["shangjiaid"];
			$SQL4="select sum(purchasenumber*price) AS get_money from t_orderdetail where orderid=".$orderid." and shangjiaid='".$shangjiaid."'";
			$RS4 = mysql_query($SQL4, $con);
		
			while($RSk = mysql_fetch_array($RS4)){
				$geren=$RSk["get_money"];
				$SQL5="update shangjia set cunkuan=cunkuan+".$geren." ,lirun=lirun+".$geren." where shangjiaid='".$shangjiaid."'";
				$RS5 = mysql_query($SQL5, $con);
			}
		}
	}
    $dan="success";
	$ggt=0;	//��ʼ��
	}
?>

<style>
#pay_here{
    margin:0 auto;
    width: 500px;
    border: 3px solid green;
    padding: 10px;
}

.erzi13{margin:20px auto; width:200px}
</style>


<body>
 <div id="pay_here">
  <div class="erzi13">
  ����������
  </div> 
  
  <form method="post" name="frmUpload" enctype="multipart/form-data" action="" onSubmit="return match(<?php  echo $password ?>)" >
  
  <div class="erzi13">
  <input type="password" class="erzi13" id="pwd">
  </div>
  
  <div class="erzi13">
  <input type="submit" value= "ȷ��">
  </div>
 
  <input type="hidden" name="ggt" value=1>
  <input type="hidden" name="ordercode1" value=<?php  echo $ordercode ?>>
  </form>

  <p class="erzi13" id="warning6"><?php echo $dan ?></p>
 </div>
</body>

<script>
// ƥ������������Ƿ������ݿ���һ����һ����submit�ɹ�
function match(pwd_true){
 	pwd_input=document.getElementById("pwd");
 	warning_span=document.getElementById("warning6");
 	if(pwd_input.value!=pwd_true){
		warning_span.innerHTML="wrong password"; 
		return false;
 	}
 	warning_span.innerHTML="";
}
</script>