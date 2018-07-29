function ajaxObj(meth, url){
	var x = new XMLHttpRequest();
	x.open(meth, url, true);
	x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	return x;
}
function ajaxReturn(x){
	if(x.readyState == 4 && x.status == 200){
		return true;
	}
}
function ajaxLoading(l){
	if(l.readyState == 3 && l.status == 200){
	    return true;	
	}
}
/*function ajaxObj( meth, url ) {
var x = new XMLHttpRequest();
x.open( meth, url, true );
x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
return x;
}
function ajaxReturn(x){
if(x.readyState == 4 && x.status == 200){
   return true;
}
}*/