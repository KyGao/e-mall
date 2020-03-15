var repeat=0;
var empty=0;
var xmlHttp;

function overflow_check(this_temp, stocknum){
	console.log(stocknum,this_temp.value);
	inputnum=this_temp.value
	if(inputnum=="")	
	{	//console.log(stocknum);	
		return;
	}
	else
	{
		if(inputnum>stocknum)	
        {	console.log(stocknum);
            document.getElementById('text1').value = ""
            alert("库存不够啦，少买一点吧");
		    return;
        }
    }
} 
		  