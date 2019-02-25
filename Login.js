function fnregist(){
    var xhttp = new XMLHttpRequest();   
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode !=0){
                var msg = document.getElementById("result-msg");
                //msg.innerHTML = res.errmsg;
                alert(res.errmsg);
            }
            else{
                var msg = document.getElementById("result-msg");
                msg.innerHTML = "注册成功！";
                //var a = "<div class=...>" + msg + "</div>";
            }
        }
    }
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var checkpwd = document.getElementById("checkpwd").value;
    
    xhttp.open("POST","./Signup.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    
    var arr = {username,password,checkpwd};
    JSON.stringify(arr);
    xhttp.send("username=" + username + "&password=" + password + "&checkpwd=" + checkpwd)
};


function fnLogin(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            console.log(xhttp.responseText);
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode != 0){
                var msg = document.getElementById("result-msg");
                //msg.innerHTML = res.errmsg;
                alert(res.errmsg);
            }
            else{
                var msg = document.getElementById("result-msg");
                msg.innerHTML = '<p>登录成功！ 这是你的第 ' + res.data.number_of_times + ' 次登录</p>' +
                '<p>最近一次登录在 ' + res.data.last_login_time + '</p>'
                window.location.href="MB.html";             
            }
        }
    }
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    xhttp.open("POST","./Login.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    var arr = {username,password};
    JSON.stringify(arr);
    xhttp.send("username=" + username + "&password=" + password)
}