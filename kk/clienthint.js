var xmlHttp
var user_flag=1;	//1为买家，0为卖家
var repeat=0;
var empty=1;

//更改买家/卖家登录模式
function exchange(this_temp){
	identity=document.getElementById("identity_flag");	//获取隐藏控件的信息

	if(user_flag==1)	//为买家
	{
		this_temp.innerText="买家登录请点此";
		user_flag=0;
		identity.value=0;
	}
	else if(user_flag==0)	//为卖家
	{	
		this_temp.innerText="商家登录请点此";
		user_flag=1;
		identity.value=1;
	}
}

//检查登录信息是否合格
//-----------------------------------
//检测对象
//账户名是否为空
//密码是否为空
//浏览器是否支持HTTP请求
//账户名与密码是否匹配
//password
//-----------------------------------
function check(){
	var warning_span=document.getElementById("warning");
  	if(document.getElementById("userid").value==""){
	  	warning_span.innerHTML="userid cannot be empty";
      	return;
	}
	if(document.getElementById("password").value==""){
		warning_span.innerHTML="password cannot be empty";
      	return;
	}
	warning_span.innerHTML="";
	
	var userid=document.getElementById("userid").value;
	var pssword=document.getElementById("password").value;
	var sf=document.getElementById("identity_flag").value;
	    
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null){
    	alert ("Browser does not support HTTP Request")
    	return
    } 
	
	var url="login.php"
	url=url+"?userid="+userid+"&password="+pssword+"&sf="+sf;
	url=url+"&sid="+Math.random()
	
	for(var i=0;i<4;i++){
  	  	xmlHttp.onreadystatechange=stateChanged;
      	xmlHttp.open("GET",url,true);
      	xmlHttp.send(null)
	}
}

//状态检测函数，相当于中断的触发
function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		gett=xmlHttp.responseText;	// 通过login.php得到的返回值
		var warning_span=document.getElementById("warning");
		if(gett=="0"){
			warning_span.innerHTML="cannnot accept";
		}
 		else if(gett=="1"){
			warning_span.innerHTML="wrong number";
		}
 		else if(gett=="2"){
	 		warning_span.innerHTML="success";
 			window.location.href="main.php";
 		}
	} 
}


//切换进注册页面（登录/注册）（买家端/卖家端）
function regis_check(){
	var login_temp=document.getElementById("login");
	var regis_temp=document.getElementById("register");
	var regis_buy_temp=document.getElementById("register_buy");
	var regis_sell_temp=document.getElementById("register_sell");
	//要进入注册页面的初始化是登录，所以可点图标是注册不是登录
	login_temp.style.display="none";	
	regis_temp.style.display="block";

	//买家注册页面
	if(user_flag==1){	
		regis_sell_temp.style.display="none";
		regis_buy_temp.style.display="block";
	}
	//卖家注册页面
	if(user_flag==0){	
		regis_buy_temp.style.display="none";
		regis_sell_temp.style.display="block";
	}

}

//切换进登陆界面
function login_check(){
	var login_temp=document.getElementById("login");
	var regis_temp=document.getElementById("register");

	regis_temp.style.display="none";
	login_temp.style.display="block";
}

//注册时检查id（买家/卖家）是否重复
function repeat_check(this_temp){
	userid=this_temp.value
	if(userid=="")	//是空直接返回 不判断
		return;
	else
	{
		xmlHttp=GetXmlHttpObject()	//创建实例
    	if (xmlHttp==null)	//确认浏览器支持
    	{
     		alert ("Browser does not support HTTP Request")
     		return
    	} 
		  
		var url="repeat_check.php"	//到repeat_check.php查看是否
	  	url=url+"?userid="+userid+"&sf="+user_flag;
	  	url=url+"&sid="+Math.random()
		  
		  for(var i=0;i<4;i++){
  	  		xmlHttp.onreadystatechange=stateChanged1;
      		xmlHttp.open("GET",url,true);
      		xmlHttp.send(null)
		}
	}

	function stateChanged1() 	//内嵌状态检测函数
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 		{ 
			gett=xmlHttp.responseText;
			var warning_span=document.getElementById("warning1");
			
			if(gett=="0")
			{
				warning_span.innerHTML="";
				repeat=0;
			}

			else if(gett=="1"){
				warning_span.innerHTML="ID repeat";
				repeat=1;
			}
		}
	} 
}

//检查注册信息是否合格
//-----------------------------------
//检测对象
//所有注册信息是否存在空
//浏览器是否支持HTTP请求
//id是否存在重复
//是否成功写入
//（待加）name不能重复
//-----------------------------------
//
//若检查无误则直接在register.php中写入数据
function register()
{ 
 	if(user_flag==1)
 		var get_info= document.getElementsByClassName("class_buy");	//
 	else if(user_flag==0)
 		var get_info= document.getElementsByClassName("class_sell");
 	var warning_span=document.getElementById("warning1");
 	var empty=0;
   
  	for(var i=0;i<get_info.length;i++){	//确保没有空的信息
		if(get_info[i].value=="")
	 		empty=1;
	}

  	if(empty==1){	//存在空的信息
		warning_span.innerHTML="请将信息填写完整";
		return;  
	}
	  
  	else if(repeat==0){
	 	xmlHttp=GetXmlHttpObject()	//不重复则创建实例
    	if (xmlHttp==null)
    	{
     		alert ("Browser does not support HTTP Request")
     		return
		}	 
		
	  	var url="register.php";	//去register.php查看是否可以注册  
		if(user_flag==0){	//卖家端查询的sql语句
	  		url=url+"?shangjiaid="+get_info[0].value+"&shangjianame="+get_info[1].value+"&password="+get_info[2].value+"&address="+get_info[3].value+"&cunkuan="+get_info[4].value+"&sf="+user_flag;
	  	}
		else if(user_flag==1){	//买家端查询的sql语句
		  	url=url+"?userid="+get_info[0].value+"&username="+get_info[1].value+"&password="+get_info[2].value+"&cunkuan="+get_info[3].value+"&sf="+user_flag;
	  	}
		url=url+"&sid="+Math.random()
		console.log(url);
		  
		  for(var i=0;i<4;i++){
  	  		xmlHttp.onreadystatechange=stateChanged2;
      		xmlHttp.open("GET",url,true);
      		xmlHttp.send(null);
  		}
	}
	
	function stateChanged2() //内嵌状态检测函数
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 
			gett=xmlHttp.responseText;
			var warning_span=document.getElementById("warning1");
			
			if(gett=="0")
			{
				warning_span.innerHTML="注册失败";
			}
			else if(gett=="1"){
				warning_span.innerHTML="注册成功";
				repeat=1;
			}
		}
	} 
}





/*
GetXmlHttpObject() 

AJAX 应用程序只能运行在完整支持 XML 的 web 浏览器中。

上面的代码调用了名为 GetXmlHttpObject() 的函数。

该函数的作用是解决为不同浏览器创建不同 XMLHTTP 对象的问题。
*/
function GetXmlHttpObject()
{
	var xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e){
		// Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}


function GetXmlHttpObject()
{
	var xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e){
		// Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}
