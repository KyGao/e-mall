<?php 

ini_set("display_errors", 0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);

session_start();

header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$dan="fail"
?>
<script src="repeatname.js?a=123"></script>
<style>
.center {
    margin:0 auto;
    width: 500px;
    border: 3px solid green;
    padding: 10px;
}
.section_add{margin:20px auto;}
.txtinput{
	 margin:0 auto;
	}
.showline{
	  margin:0 auto;

	}
</style>





<?php
//filename:upldfile.php

if($_POST["ifupload"]=="1") 
{
    $path=AddSlashes(dirname(__FILE__))  . "\\\\images2\\\\";
    $files="afile1";     
            
    if (is_uploaded_file($_FILES[$files]['tmp_name'])) {
        $filename = $_FILES[$files]['name'];
        $localfile = $path . $filename;
        //move_uploaded_file() 函数将上传的文件移动到新位置。
        move_uploaded_file($_FILES[$files]['tmp_name'], $localfile);
    }
    $uploadplace="images2\\\\".$filename;
    // $pdcode=$_POST['pdcode'];
    $pdname=$_POST['pdname'];
    $pprice=$_POST['pprice'];
    $slcode=$_SESSION['userid'];
//    $stnumber=$_POST['stnumber'];
    $stnumber=0;
    $con=mysql_connect("localhost","root","sql");
    mysql_select_db("qingzhou",$con);
      mysql_query("set names gb2312");


    $SQL="insert into t_product(productname,price,shangjiaid,productimage,stocknumber,originalprice) value(";
    $SQL=$SQL."'". $pdname."','". $pprice."','". $slcode."','".$uploadplace."','".$stnumber. "','" .$pprice . "')";
    //echo $SQL;die();
    $RS1=mysql_query($SQL,$con);
    $sqll="select * from t_product where productname='".$pdname."' and shangjiaid='".$slcode."'";
    //$sqll=$sqll.$pdcode;
    $dan=$con;
    //echo $sqll;die();
    $RS0=mysql_query($sqll,$con);
}
?>

<div class="center">
<form method="post" name="frmUpload" enctype="multipart/form-data" action="" onsubmit="return jiancha()">

<input type="file" id="file" tabindex="1" name="afile1" onchange="document.getElementById("file").value=this.value" >

<div class="section_add">
产品名：<input type="text" class="txtinput" placeholder="productname" name="pdname" onkeyup="repeatname(this,'<?php echo $_SESSION['userid'] ?>')">
</div>

<div class="section_add">
进  价 ：<input type="text" class="txtinput" placeholder="price" name="pprice">
</div>
<!--
<div class="section_add">
库  存 ：<input type="text" class="txtinput" placeholder="stocknumber" name="stnumber"><br>
</div>
-->
<div class="section_add">
<input type="submit" name="submit" value="确定" />
</div>

<input type="hidden" name="ifupload" value=1>&nbsp;&nbsp;

</form>
<p id="warning2" class="section_add"></p>
</div>


<div class="center">
<?php
  while($RS = mysql_fetch_array($RS0))
  {
?>
<p>成功上传的信息</p><br>
<div class="showline">产品编号:<?php echo $RS["productcode"] ?></div>
<div class="showline">产品名称:<?php echo $RS["productname"] ?></div>
<div class="showline">进货价格:<?php echo $RS["price"] ?></div>
<div class="showline">产品库存:<?php echo $RS["stocknumber"] ?></div>
<image src="<?php echo $RS["productimage"] ?>" width=86px height=84px style="margin:0 auto">
</div>

<?php
  }
//retrieve session data
  mysql_close($con);
  $RS=NULL;
  $con =NULL;
?>

