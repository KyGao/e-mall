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

$productname = $_POST['productname'];
$SQL = "select * from t_product where productname like '%". $productname ."%'"; //�ؼ���������Ʒ

//echo $sql1; die();
$RS0 = mysql_query($SQL, $con);
//print_r(mysql_fetch_array($RS0));
?>

<HTML>
<HEAD>
<script src="overflow_check.js?a=13"></script>
<style type="text/css">
<!--
font{font-family: "΢���ź�";font-size:9pt}
.font1{font-family: "΢���ź�";font-size:14.3px}
td{font-family: "΢���ź�";font-size:9pt}
a{text-decoration:none}
-->
</style>

<script language=javascript>
	function addorder()	//ͨ��hidden�ؼ����������
	{
        var r = /^\+?[1-9][0-9]*$/;����//������ʽ
        var checkboxes = document.getElementsByName("checkbox1");	//ע����getElementsByName��������elements�������Ǹ����� 
        var nums = document.getElementsByName("purchasenum");	//��������
        var ids=document.getElementsByName("sellerid");
        var str = []; 	//����װ		
/*  ��Զೢ��ʧ��
        var idx = new Array(ids.length);   //��������˳��
        
        //���������ʼ��
        for (var i = 0; i < ids.length; i++) {
            idx[i] = i;
        }

        //�ȸ�������id��һ�����򣬷���֮�����ɶ�Զඩ��
        for (var i = 0; i < ids.length; i++) {  //ð������
            for (var j = 0; j < ids.length - 1 - i; j++) {
                //compareToIndexValue(ids, j, checkboxes, nums);    //�ݹ麯��
                var debug1 = ids[idx[j]].textContent.substring(0, 1);
                var debug2 = ids[idx[j + 1]].textContent.substring(0, 1);
                if(debug1 > debug2) {
                    var temp = idx[j+1];
                    idx[j + 1] = idx[j];
                    idx[j] = temp;
                }
            }	
        }
		
		for(i=0;i<checkboxes.length;i++){ //����
            if(checkboxes[idx[i]].checked){ //��i��checkbox��ѡ��
                str.push(checkboxes[idx[i]].value); //����Ʒ�����ƽ�str������ 
                if (nums[idx[i]].value=="" || !(r.test(nums[idx[i]].value))) { alert('����ȷ���빺������'); return false; }	//����������Ŀջ�����������ʽ
                str.push(nums[idx[i]].value); //��������
				str.push(ids[idx[i]].innerHTML);
				
            } 
        } 
*/

for(i=0;i<checkboxes.length;i++){ //����
            if(checkboxes[i].checked){ //��i��checkbox��ѡ��
                str.push(checkboxes[i].value); //����Ʒ�����ƽ�str������ 
                if (nums[i].value=="" || !(r.test(nums[i].value))) { alert('����ȷ���빺������'); return false; }	//����������Ŀջ�����������ʽ
                str.push(nums[i].value); //��������
				str.push(ids[i].innerHTML);
				
            } 
        } 

        document.getElementById("checkedproduct").value = str;
        if((""==str)){	//���Ϊ��
            alert('��ѡ����Ʒ��Ӷ���'); return false; 
        }else{	//�����Ϊ�գ�ģ��submit
            document.form1.action = 'addorder0.php';
            document.form1.submit();
        }	
    }

    //��������ĸ ����,�������ĸ��ͬ����ݵڶ�����ĸ����...ֱ���ų���С
   /* function compareToIndexValue(ids, arrIndex, checkboxes, nums)
    {
        int=0;
        if(ids[arrIndex].textContent.substring(int,int+1) == ids[arrIndex + 1].textContent.substring(int,int+1)){
            compareToIndexValue(ids,int+1,arrIndex);//  �����һλ���,������Ƚϵڶ����ַ�
            if(int>) return;
        }
        else if(ids[arrIndex].textContent.substring(int,int+1) > ids[arrIndex + 1].textContent.substring(int,int+1)) {
            var temp = ids[arrIndex + 1];
            ids[arrIndex + 1] = ids[arrIndex];
            ids[arrIndex] = temp;

            temp = checkboxes[arrIndex + 1];
            checkboxes[arrIndex + 1] = checkboxes[arrIndex];
            checkboxes[arrIndex] = temp;

            temp = nums[arrIndex + 1];
            nums[arrIndex + 1] = nums[arrIndex];
            nums[arrIndex] = temp;
        }
        return;
    }
*/
</script>
</HEAD>
<TITLE>����㳡</TITLE>

<BODY>
<!----------------�޸������ҳ�İ�ʽ������---------------->
<!----------------�޸������ҳ�İ�ʽ������---------------->
<!----------------�޸������ҳ�İ�ʽ������---------------->
    <form id=form1 name=form1 method=post>
    ������Ʒ��<input type=text name=productname>
    <input type=submit value=����>
    ���͵�ַ��<input type=text name=address>
    <input align=left type=button value=���ɶ��� onClick="return addorder();">  <!--addorder��ǰ��д��js����-->
    <input type=hidden id=checkedproduct name=checkedproduct>
    </form>
    <p></p>
    <center>

    <table  ID="SrhTable" border=0 width=100% cellpadding=0 cellspacing=1>
    <tr>
    <td></td>
    <td>��Ʒ����</td>
    <td>��Ʒ����</td>
    <td>�̼�����</td>
    <td>��Ʒ�۸�</td>
    <td>��Ʒ���</td>
    <td>��������</td>
    <td>��ƷͼƬ</td>
    </tr>

    <?php
        while($RS = mysql_fetch_array($RS0))    //�Ӻþ���ǰ��RS0
        {
    ?>

    <tr>
    <td><input type=checkbox id="checkbox1" name="checkbox1" 
        value="<?php echo strval($RS["productcode"])?>"></td>
    <td><?php echo strval($RS["productcode"])?></td>
    <td><?php echo strval($RS["productname"])?></td>
    <td name="sellerid"><?php echo strval($RS["shangjiaid"])?></td>
    <td><?php echo strval($RS["price"])?></td>
    <td><?php echo strval($RS["stocknumber"])?></td>
    <td><input type=text id="purchasenum" name="purchasenum" onkeyup="overflow_check(this, <?php echo $RS["stocknumber"] ?>)"></td>
    <td><?php echo "<img src=" . strval($RS["productimage"]) . " style=\"width:100px;height:100px;\"". ">"?></td></tr>
    
    <?php 
        }   //�������while

        mysql_close($con);
        $RS=NULL;
        $Con =NULL;
    ?>

    </table>

</html>
