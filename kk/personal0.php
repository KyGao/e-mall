<?php
session_start();
if (($_SESSION['userid'] == '') )//|| ($_SESSION['usertype'] <> '1')) 
{
	die('<script language="javascript">top.location.href="loginexit.php"</script>');
}


header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");

$userid=$_SESSION['userid'];
$usertype=$_SESSION['usertype'];

$con = mysql_connect("localhost","root","sql");
mysql_select_db("qingzhou", $con);
mysql_query("set names gb2312 ");

$upload=$_POST["upload"];   //submit֮��uploadΪ1

if($upload==1){
  //��ȡҪ����ĸ�����Ϣ
	$uname=$_POST["uname"];
	$upwd=$_POST["upwd"];
	$uck=$_POST["uck"];
  if($usertype==0)
	 $uad=$_POST["uad"];
	
  //д�����ݿ�
	if($usertype==1){
  	$sqll="update php_admin set username='" . strval($uname)."',password='" . strval($upwd) . "',cunkuan='" . strval($uck)."' where userid='" . strval($userid)."'";	
  }
	else if($usertype==0){
	  $sqll="update shangjia set shangjianame='" . strval($uname) . "',password='" . strval($upwd) . "',cunkuan='" . strval($uck) . "',address='" . strval($uad) . "' where shangjiaid='" . strval($userid) ."'";	
  }
  
  //echo $sqll; die();
	$RS0 = mysql_query($sqll, $con);
}

$upload=0;

if($usertype==1)
	$SQL = "select * from php_admin where userid='". $userid ."'";
else if($usertype==0)
	$SQL = "select * from shangjia where shangjiaid='".$userid ."'";

$RS0 = mysql_query($SQL, $con);
while($RS = mysql_fetch_array($RS0))
{
    if($usertype==1){
		$userid=$RS["userid"];
		$username=$RS["username"];
		$password=$RS["password"];
		$cunkuan=$RS["cunkuan"];
	}
	else if($usertype==0){
		$shangjiaid=$RS["shangjiaid"];
		$shangjianame=$RS["shangjianame"];
		$password=$RS["password"];
		$lirun=$RS["lirun"];
		$cunkuan=$RS["cunkuan"];
		$address=$RS["address"];
	}	
}
?>

<style>
#person_info_here{
    margin:0 auto;
    width: 500px;
    border: 3px solid green;
    padding: 10px;
}

.jmp_button{margin:20px auto; width:300px}
</style>


<body>
  <div id="person_info_here">
    <form method="post" name="frmUpload" enctype="multipart/form-data" action="">
    <?php     
      if($usertype==1)  //��Ϊ���
      {         
    ?>
      <!--userid�������������޸�-->
      <div class="jmp_button" id="">
      <p class="erzi13" >�û�ID��<?php echo $userid  ?></p> 
      </div>

      <div class="jmp_button">
      �û�����<input class="erzi13" type="text" value="<?php echo $username  ?>" onFocus="record(this)" onBlur="out(this)" name="uname">
      </div>

      <div class="jmp_button">
      ��   �� ��<input class="erzi13" type="text" value="<?php echo $password ?>" onFocus="record(this)" onBlur="out(this)" name="upwd"> 
      </div>

      <div class="jmp_button">
      ��   �� ��<input class="erzi13" type="text" value="<?php echo $cunkuan ?>" onFocus="record(this)" onBlur="out(this)" name="uck"> 
      </div>
    <?php 
      } 
    ?>

    <?php     
      if($usertype==0)  //��Ϊ����
      {
    ?>
      <!--userid�������������޸�-->
      <div class="jmp_button">
      <p class="erzi13" name="uid">�û�ID��<?php echo $shangjiaid  ?></p>
      </div>
      <div class="jmp_button">
      �û�����<input class="erzi13" type="text" value="<?php echo $shangjianame  ?>" onFocus="record(this)" onBlur="out(this)" name="uname">
      </div>
      <div class="jmp_button">
      ��   �� ��<input class="erzi13" type="text" value="<?php echo $password ?>" onFocus="record(this)" onBlur="out(this)" name="upwd"> 
      </div>
      <div class="jmp_button">
      <p class="erzi13">��   �� ��<?php echo $lirun  ?></p>
      </div>
      <div class="jmp_button">
      ��   �� ��<input class="erzi13" type="text" value="<?php echo $cunkuan ?>" onFocus="record(this)" onBlur="out(this)" name="uck"> 
      </div>
      <div class="jmp_button">
      ��   ַ ��<input class="erzi13" type="text" value="<?php echo $address ?>" onFocus="record(this)" onBlur="out(this)" name="uad"> 
      </div>
    <?php
      } 
    ?>
      
      <!--�������֮�����upload������������Ӧ���ݿ����-->
      <div class="jmp_button"><input type="submit" value="����"></div>
      <input type="hidden" value=1 name="upload">   
    </form>
  </div>
</body>

<?php 

mysql_close($con);
$RS=NULL;
$Con =NULL;
?>

<script>
//�����ݿ���ԭ������show����
//��ȷ�ϵ������֮��ϵͳ�ɹ�д�����ݿ�
var ssave;  
//
function record(temp){
 ssave=temp.value;
}
//
function out(temp){
 if(temp.value=="")
  temp.value=ssave;	
}
</script>