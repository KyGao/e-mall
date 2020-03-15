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
$SQL = "select * from t_product where productname like '%". $productname ."%'"; //关键词搜索商品

//echo $sql1; die();
$RS0 = mysql_query($SQL, $con);
//print_r(mysql_fetch_array($RS0));
?>

<HTML>
<HEAD>
<script src="overflow_check.js?a=13"></script>
<style type="text/css">
<!--
font{font-family: "微软雅黑";font-size:9pt}
.font1{font-family: "微软雅黑";font-size:14.3px}
td{font-family: "微软雅黑";font-size:9pt}
a{text-decoration:none}
-->
</style>

<script language=javascript>
	function addorder()	//通过hidden控件定义过来的
	{
        var r = /^\+?[1-9][0-9]*$/;　　//正则表达式
        var checkboxes = document.getElementsByName("checkbox1");	//注意是getElementsByName，这里是elements，即这是个数组 
        var nums = document.getElementsByName("purchasenum");	//购买数量
        var ids=document.getElementsByName("sellerid");
        var str = []; 	//用来装		
/*  多对多尝试失败
        var idx = new Array(ids.length);   //存排序后的顺序
        
        //排序数组初始化
        for (var i = 0; i < ids.length; i++) {
            idx[i] = i;
        }

        //先根据卖家id做一个排序，方便之后生成多对多订单
        for (var i = 0; i < ids.length; i++) {  //冒泡排序
            for (var j = 0; j < ids.length - 1 - i; j++) {
                //compareToIndexValue(ids, j, checkboxes, nums);    //递归函数
                var debug1 = ids[idx[j]].textContent.substring(0, 1);
                var debug2 = ids[idx[j + 1]].textContent.substring(0, 1);
                if(debug1 > debug2) {
                    var temp = idx[j+1];
                    idx[j + 1] = idx[j];
                    idx[j] = temp;
                }
            }	
        }
		
		for(i=0;i<checkboxes.length;i++){ //数量
            if(checkboxes[idx[i]].checked){ //第i个checkbox被选中
                str.push(checkboxes[idx[i]].value); //把商品编码推进str数组里 
                if (nums[idx[i]].value=="" || !(r.test(nums[idx[i]].value))) { alert('请正确输入购买数量'); return false; }	//购买数量填的空或不满足正则表达式
                str.push(nums[idx[i]].value); //购买数量
				str.push(ids[idx[i]].innerHTML);
				
            } 
        } 
*/

for(i=0;i<checkboxes.length;i++){ //数量
            if(checkboxes[i].checked){ //第i个checkbox被选中
                str.push(checkboxes[i].value); //把商品编码推进str数组里 
                if (nums[i].value=="" || !(r.test(nums[i].value))) { alert('请正确输入购买数量'); return false; }	//购买数量填的空或不满足正则表达式
                str.push(nums[i].value); //购买数量
				str.push(ids[i].innerHTML);
				
            } 
        } 

        document.getElementById("checkedproduct").value = str;
        if((""==str)){	//如果为空
            alert('请选择商品添加订单'); return false; 
        }else{	//如果不为空，模拟submit
            document.form1.action = 'addorder0.php';
            document.form1.submit();
        }	
    }

    //根据首字母 排序,如果首字母相同则根据第二个字母排序...直到排出大小
   /* function compareToIndexValue(ids, arrIndex, checkboxes, nums)
    {
        int=0;
        if(ids[arrIndex].textContent.substring(int,int+1) == ids[arrIndex + 1].textContent.substring(int,int+1)){
            compareToIndexValue(ids,int+1,arrIndex);//  如果第一位相等,则继续比较第二个字符
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
<TITLE>购物广场</TITLE>

<BODY>
<!----------------修改买家主页的版式在这里---------------->
<!----------------修改买家主页的版式在这里---------------->
<!----------------修改买家主页的版式在这里---------------->
    <form id=form1 name=form1 method=post>
    搜索商品：<input type=text name=productname>
    <input type=submit value=搜索>
    配送地址：<input type=text name=address>
    <input align=left type=button value=生成订单 onClick="return addorder();">  <!--addorder是前面写的js函数-->
    <input type=hidden id=checkedproduct name=checkedproduct>
    </form>
    <p></p>
    <center>

    <table  ID="SrhTable" border=0 width=100% cellpadding=0 cellspacing=1>
    <tr>
    <td></td>
    <td>商品编码</td>
    <td>商品名称</td>
    <td>商家名称</td>
    <td>商品价格</td>
    <td>商品库存</td>
    <td>购买数量</td>
    <td>商品图片</td>
    </tr>

    <?php
        while($RS = mysql_fetch_array($RS0))    //接好久以前的RS0
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
        }   //接上面的while

        mysql_close($con);
        $RS=NULL;
        $Con =NULL;
    ?>

    </table>

</html>
