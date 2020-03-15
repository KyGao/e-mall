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

$productname = $_POST['productname'];
$SQL = "select * from t_product where productname like '%". $productname ."%' and shangjiaid='".$_SESSION['userid']."'";

//echo $sql1; die();
$RS0 = mysql_query($SQL, $con);
//print_r(mysql_fetch_array($RS0));
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
font{font-family: "微软雅黑";font-size:9pt}
.font1{font-family: "微软雅黑";font-size:14.3px}
td{font-family: "微软雅黑";font-size:9pt}
a{text-decoration:none}
-->

</style>

<script language=javascript>
	function addstorage()
	{
        var r = /^\+?[1-9][0-9]*$/;
        var checkboxes = document.getElementsByName("checkbox1"); 
        var texts = document.getElementsByName("text1");
        var str = []; 
        for(i=0;i<checkboxes.length;i++){ 
            if(checkboxes[i].checked){ 
                str.push(checkboxes[i].value); 
                if (texts[i].value=="" || !(r.test(texts[i].value))) { alert('请输入正确信息'); return false; }
                str.push(texts[i].value); 
            } 
        } 
        document.getElementById("checkedproduct").value = str;
        
		if((""==str)){
            alert('请填写信息'); return false; 
        }
		else{   //到editpriceaction.php中修改数据库库存
            document.form1.action = 'editpriceaction.php';
            document.form1.submit();
        }	
	}
</script>
</HEAD>
<TITLE>??????????????????</TITLE>

<BODY>
<form id=form1 name=form1 method=post>
搜索商品<input type=text name=productname>
<input type=submit value="搜索">
<input align=left type=button value="确认改价" onClick="return addstorage();">
<input type=hidden id=checkedproduct name=checkedproduct>
</form>
<p></p>
<center>
<table  ID="SrhTable" border=0 width=100% cellpadding=0 cellspacing=1>
<tr>
<td></td>
<td>商品编码</td>
<td>商品名称</td>
<td>商品价格</td>
<td>商品库存</td>
<td>新的价格</td>
<td>商家名</td>
<td>商品图片</td>
</tr>

<?php
while($RS = mysql_fetch_array($RS0))
{
?>
<tr>
<td><input type=checkbox id="checkbox1" name="checkbox1" 
	value="<?php echo strval($RS["productcode"])?>"></td>
<td><?php echo strval($RS["productcode"])?></td>
<td><?php echo strval($RS["productname"])?></td>
<td><?php echo strval($RS["price"])?></td>
<td><?php echo strval($RS["stocknumber"])?></td>
<td><input type=text id="text1" name="text1"></td>
<td><?php echo strval($RS["shangjiaid"])?></td>
<td><?php echo "<img src=" . strval($RS["productimage"])." width=86px height=84px>"?></td></tr>

<?php 
}
mysql_close($con);
$RS=NULL;
$Con =NULL;
?>

</table>

</html>
