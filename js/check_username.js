function check_username()
{
    var flag=true;
    var username=document.getElementById("username").value;
    if(username==null || username==""){
        document.getElementById("username_error").innerHTML="必须填写";
        flag=false;
        return;
    }
    else if(username.length<5 || username.length>20){
        document.getElementById("username_error").innerHTML="长度应该在5-20之间";
        flag=false;
        return;
    }
    else{
        document.getElementById("username_error").innerHTML=null;
    }
}