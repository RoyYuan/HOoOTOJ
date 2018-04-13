function check_password()
{
    var flag=true;
    var password=document.getElementById("password").value;
    if(password==null || password==""){
        document.getElementById("password_error").innerHTML="必须填写";
        flag=false;
        return;
    }
    else if(password.length)
    else{
        document.getElementById("password_error").innerHTML=null;
    }
}