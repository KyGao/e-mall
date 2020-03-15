var repeat=0;
var empty=0;
var xmlHttp;

function repeatname(this_temp, userid){
	//console.log(userid,this_temp.value);
	pdname=this_temp.value
	if(pdname=="")	
	{	console.log(userid);	
		return;
	}
	else
	{
		xmlHttp=GetXmlHttpObject()	
    	if (xmlHttp==null)	
    	{
     		alert ("Browser does not support HTTP Request")
     		return
    	} 
		  
		var url="repeatname.php"	
	  	url=url+"?userid="+userid+"&pdname="+pdname;
	  	url=url+"&sid="+Math.random()
		  
		  console.log(url);
		  for(var i=0;i<4;i++){
  	  		xmlHttp.onreadystatechange=stateChanged1;
      		xmlHttp.open("GET",url,true);
      		xmlHttp.send(null)
		}
	}

	function stateChanged1() 	
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 		{ 
			gett=xmlHttp.responseText;
			var warning_span=document.getElementById("warning2");
			
			if(gett=="0")
			{
				warning_span.innerHTML="";
				repeat=0;
			}

			else if(gett=="1"){
				warning_span.innerHTML="产品名称重复";
				repeat=1;
			}
		}
	} 
}

 
 function jiancha(){
	if(repeat==1)
	return false;
	empty=0;
	var ttp=document.getElementsByClassName("txtinput");
	 var warning_span=document.getElementById("warning2");
	 warning_span.innerHTML="";
	 for(var x=0;x<ttp.length;x++){
		 if(ttp[x].value=="")
		 empty=1; 
		 }
		 
		
		 if(empty==1){
		 warning_span.innerHTML="请填写完整信息"
		 return false;
		 }
 }
 
 
 function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}