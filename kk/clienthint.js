var xmlHttp
var user_flag=1;	//1Ϊ��ң�0Ϊ����
var repeat=0;
var empty=1;

//�������/���ҵ�¼ģʽ
function exchange(this_temp){
	identity=document.getElementById("identity_flag");	//��ȡ���ؿؼ�����Ϣ

	if(user_flag==1)	//Ϊ���
	{
		this_temp.innerText="��ҵ�¼����";
		user_flag=0;
		identity.value=0;
	}
	else if(user_flag==0)	//Ϊ����
	{	
		this_temp.innerText="�̼ҵ�¼����";
		user_flag=1;
		identity.value=1;
	}
}

//����¼��Ϣ�Ƿ�ϸ�
//-----------------------------------
//������
//�˻����Ƿ�Ϊ��
//�����Ƿ�Ϊ��
//������Ƿ�֧��HTTP����
//�˻����������Ƿ�ƥ��
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

//״̬��⺯�����൱���жϵĴ���
function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		gett=xmlHttp.responseText;	// ͨ��login.php�õ��ķ���ֵ
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


//�л���ע��ҳ�棨��¼/ע�ᣩ����Ҷ�/���Ҷˣ�
function regis_check(){
	var login_temp=document.getElementById("login");
	var regis_temp=document.getElementById("register");
	var regis_buy_temp=document.getElementById("register_buy");
	var regis_sell_temp=document.getElementById("register_sell");
	//Ҫ����ע��ҳ��ĳ�ʼ���ǵ�¼�����Կɵ�ͼ����ע�᲻�ǵ�¼
	login_temp.style.display="none";	
	regis_temp.style.display="block";

	//���ע��ҳ��
	if(user_flag==1){	
		regis_sell_temp.style.display="none";
		regis_buy_temp.style.display="block";
	}
	//����ע��ҳ��
	if(user_flag==0){	
		regis_buy_temp.style.display="none";
		regis_sell_temp.style.display="block";
	}

}

//�л�����½����
function login_check(){
	var login_temp=document.getElementById("login");
	var regis_temp=document.getElementById("register");

	regis_temp.style.display="none";
	login_temp.style.display="block";
}

//ע��ʱ���id�����/���ң��Ƿ��ظ�
function repeat_check(this_temp){
	userid=this_temp.value
	if(userid=="")	//�ǿ�ֱ�ӷ��� ���ж�
		return;
	else
	{
		xmlHttp=GetXmlHttpObject()	//����ʵ��
    	if (xmlHttp==null)	//ȷ�������֧��
    	{
     		alert ("Browser does not support HTTP Request")
     		return
    	} 
		  
		var url="repeat_check.php"	//��repeat_check.php�鿴�Ƿ�
	  	url=url+"?userid="+userid+"&sf="+user_flag;
	  	url=url+"&sid="+Math.random()
		  
		  for(var i=0;i<4;i++){
  	  		xmlHttp.onreadystatechange=stateChanged1;
      		xmlHttp.open("GET",url,true);
      		xmlHttp.send(null)
		}
	}

	function stateChanged1() 	//��Ƕ״̬��⺯��
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

//���ע����Ϣ�Ƿ�ϸ�
//-----------------------------------
//������
//����ע����Ϣ�Ƿ���ڿ�
//������Ƿ�֧��HTTP����
//id�Ƿ�����ظ�
//�Ƿ�ɹ�д��
//�����ӣ�name�����ظ�
//-----------------------------------
//
//�����������ֱ����register.php��д������
function register()
{ 
 	if(user_flag==1)
 		var get_info= document.getElementsByClassName("class_buy");	//
 	else if(user_flag==0)
 		var get_info= document.getElementsByClassName("class_sell");
 	var warning_span=document.getElementById("warning1");
 	var empty=0;
   
  	for(var i=0;i<get_info.length;i++){	//ȷ��û�пյ���Ϣ
		if(get_info[i].value=="")
	 		empty=1;
	}

  	if(empty==1){	//���ڿյ���Ϣ
		warning_span.innerHTML="�뽫��Ϣ��д����";
		return;  
	}
	  
  	else if(repeat==0){
	 	xmlHttp=GetXmlHttpObject()	//���ظ��򴴽�ʵ��
    	if (xmlHttp==null)
    	{
     		alert ("Browser does not support HTTP Request")
     		return
		}	 
		
	  	var url="register.php";	//ȥregister.php�鿴�Ƿ����ע��  
		if(user_flag==0){	//���Ҷ˲�ѯ��sql���
	  		url=url+"?shangjiaid="+get_info[0].value+"&shangjianame="+get_info[1].value+"&password="+get_info[2].value+"&address="+get_info[3].value+"&cunkuan="+get_info[4].value+"&sf="+user_flag;
	  	}
		else if(user_flag==1){	//��Ҷ˲�ѯ��sql���
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
	
	function stateChanged2() //��Ƕ״̬��⺯��
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 
			gett=xmlHttp.responseText;
			var warning_span=document.getElementById("warning1");
			
			if(gett=="0")
			{
				warning_span.innerHTML="ע��ʧ��";
			}
			else if(gett=="1"){
				warning_span.innerHTML="ע��ɹ�";
				repeat=1;
			}
		}
	} 
}





/*
GetXmlHttpObject() 

AJAX Ӧ�ó���ֻ������������֧�� XML �� web ������С�

����Ĵ����������Ϊ GetXmlHttpObject() �ĺ�����

�ú����������ǽ��Ϊ��ͬ�����������ͬ XMLHTTP ��������⡣
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
