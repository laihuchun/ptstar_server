var xmlHttp

function showHint(str)
{
var url="gethint.php"
xmlHttp=GetXmlHttpObject()
url=url+"?q="+str
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged() 
{ 
document.getElementById("imei").innerHTML=xmlHttp.responseText
var oTextbox2=document.getElementById("imei")
}

function GetXmlHttpObject()
{
var xmlHttp=null;
xmlHttp=new XMLHttpRequest();
return xmlHttp;
}
