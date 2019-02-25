function myfunction()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            var res = JSON.parse(xhttp.responseText);
            var content = document.getElementById("msg-list");
            //console.log(xhttp.responseText);
            //res.length
            for (let i = (res.length-1);i >= (res.length-10);i--){
                $a = (res[i])[0];
                $b = (res[i])[1];
                $c = (res[i])[2];
                $d = (res[i])[3];
                $e = (res[i])[4];
                var con = document.createElement("li");
                con.id = $c;
                con.class = "Square";
                con.innerHTML ='<div class="username"><img src="./' + $e + ' "id="pictures">' + $a + ':' + '</div>' + '<br>' + '<div class="content">' + $b + '</div>' + '<br>' + '<div class="time">' + $d + '</div>' + '<footer><button type="button" class="button1" onclick="modify(' + $c +')"> 修改 </button><button type="button" class="button2" onclick="Delete(' + $c +')"> 删除 </button><button type="button" class="button1" onclick="reply1(' + $c +')"> 回复 </button><button type="button" class="button2" onclick="seereply(' + $c +')"> 查看回复 </button></footer>' + '<br>';
                content.insertBefore(con,content.childNodes[0]);
                //content.appendChild(con);
            }
            turnpage();
            seeavatar();        
        }
}
    xhttp.open("get","./MB.php");
    xhttp.send();
}

window.onload=myfunction;

function turnpage(){
    var pcontent = document.getElementById("msg-page");
    var turn = document.createElement("div");
    turn.id = "1";
    turn.innerHTML = '<footer><div><button type="button" class="turn_to_last_page" onclick="lastpage(1)">上一页</button></div><div id="page_number">第1页</div><div><button type="button" class="turn_to_next_page" onclick="nextpage(1)">下一页</button></div></footer>';
    pcontent.appendChild(turn);
}

function seeavatar(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            var res = JSON.parse(xhttp.responseText);
            var div = document.getElementById("avatar");
            div.innerHTML = '<img src="./' + res + ' "id="pictures">';
        }
    
}
    xhttp.open("get","./showavatar.php");
    xhttp.send();
}


function tosend(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            console.log(xhttp.responseText);
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode == 2){
                var judge = confirm(res.errmsg+"是否立即前往登录？")
                if(judge == true){
                    window.location.href="Login.html";
                }
            }else{
                if(res.errcode == 1){
                    alert(res.errmsg);
                }else{
                    var thepage = document.getElementById("page_number").innerText;
                    if(thepage == "第1页"){
                        var content = document.getElementById("msg-list");
                        var con = document.createElement("li");
                        con.id = res.data.id;
                        con.class = "Square";
                        con.innerHTML = '<div class="username"><img src="./' + res.data.avatar + ' "id="pictures">' + res.data.user + ':' + '</div>' + '<br>' + '<div class="content">' + res.data.msg + '</div>' + '<br>' + '<div class="time">' + res.data.time + '</div>' + '<footer><button type="button" class="button1"' + 'onclick="modify(' + res.data.id +')"> 修改 </button><button type="button" class="button2" onclick="Delete(' + res.data.id +')"> 删除 </button><button type="button" class="button1" onclick="reply1(' + res.data.id +')"> 回复 </button><button type="button" class="button2" onclick="seereply(' + res.data.id +')"> 查看回复 </button></footer>'+ '<br>';
                        content.insertBefore(con,content.childNodes[0]); 
                    }
                           
            }           
            }
        }
    }
    var msg = document.getElementById("msg").value;

    xhttp.open("POST","./MB.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    var arr = {msg};
    JSON.stringify(arr);
    xhttp.send("msg=" + msg)
}
function modify(data){
    var pid = data;
    console.log(pid);
    var content = prompt("请输入新的留言");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode == 1){
                var judge = confirm(res.errmsg+"是否立即前往登录？")
                if(judge == true){
                    window.location.href="Login.html";
                }
            }else{
                if(res.errcode == 2){
                    alert(res.errmsg);
                }else{
                    document.getElementById(pid).innerHTML = '<div class="username"><img src="./' + res.data.avatar + ' "id="pictures">' + res.data.user + ':' + '</div>' + '<br>' + '<div class="content">' + res.data.msg + '</div>' + '<br>' + '<div class="time">' + res.data.time + '</div>' + '<footer><button type="button" class="button1" ' + 'onclick="modify(' + pid + ')"> 修改 </button><button type="button" class="button2" onclick="Delete(' + pid + ')"> 删除 </button><button type="button" class="button1" onclick="reply1(' + pid +')"> 回复 </button><button type="button" class="button2" onclick="seereply(' + pid +')"> 查看回复 </button></footer>'+ '<br>';
                }
            }
        }
    }
    xhttp.open("POST","./MBmodify.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    var arr = {content,pid};
    JSON.stringify(arr);
    xhttp.send("content=" + content + "&pid=" + pid);
}

function Delete(data){
    var pid = data;
    var mymessage = confirm("确定要删除此留言？");
    if(mymessage == true){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode!=0){
                var judge = confirm(res.errmsg+"是否立即前往登录？")
                if(judge == true){
                    window.location.href="Login.html";
                }
            }else{
                alert(res.errmsg);
                var p = document.getElementById("msg-list");
                var c = document.getElementById(pid);
                p.removeChild(c);
            }
        }
    }
    xhttp.open("POST","./MBDelete.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    var arr = {pid};
    JSON.stringify(arr);
    xhttp.send("pid=" + pid);
    }
}

function cancel(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
    if ( xhttp.readyState == 4 && xhttp.status == 200){
        console.log(xhttp.responseText);
        var res = JSON.parse(xhttp.responseText);
        if(res.errcode==0){
            alert("注销成功");
            window.location.href="Login.html";
        }
    }}
    
    xhttp.open("POST","./left.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhttp.send();
}

function lastpage(data){
    var pid = data;
    if(pid == 1){
        alert("已经是第一页了");
    }else{
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if ( xhttp.readyState == 4 && xhttp.status == 200){
                var ul = document.getElementById("msg-list");
                while(ul.hasChildNodes()) //当div下还存在子节点时 循环继续
                {
                    ul.removeChild(ul.firstChild);
                }
                var res = JSON.parse(xhttp.responseText);
                var content = document.getElementById("msg-list");
                //console.log(xhttp.responseText);
                //res.length
                for (let i = (res.length-1);i >= (res.length-10);i--){
                    $a = (res[i])[0];
                    $b = (res[i])[1];
                    $c = (res[i])[2];
                    $d = (res[i])[3];
                    $e = (res[i])[4];
                    var con = document.createElement("li");
                    con.id = $c;
                    con.class = "Square";
                    con.innerHTML ='<div class="username"><img src="./' + $e + ' "id="pictures">' + $a + ':' + '</div>' + '<br>' + '<div class="content">' + $b + '</div>' + '<br>' + '<div class="time">' + $d + '</div>' + '<footer><button type="button" class="button1" onclick="modify(' + $c +')"> 修改 </button><button type="button" class="button2" onclick="Delete(' + $c +')"> 删除 </button><button type="button" class="button1" onclick="reply1(' + $c +')"> 回复 </button><button type="button" class="button2" onclick="seereply(' + $c +')"> 查看回复 </button></footer>' + '<br>';
                    content.insertBefore(con,content.childNodes[0]);
                    //content.appendChild(con);
                }
                turningpage1(pid-1);
            }
        }

        xhttp.open("POST","./lastpage.php");
        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var arr = {pid};
        JSON.stringify(arr);
        xhttp.send("pid=" + pid);
}}

function nextpage(data){
    var pid = data;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
         if ( xhttp.readyState == 4 && xhttp.status == 200){  
            //console.log(xhttp.responseText);
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode==1){
                alert("已经是最后一页了");
            }else{
                var ul = document.getElementById("msg-list");
                while(ul.hasChildNodes()) //当div下还存在子节点时 循环继续
                {
                    ul.removeChild(ul.firstChild);
                }
                var content = document.getElementById("msg-list");
                
                //res.length
                for (let i = (res.data.length-1);i >= 0;i--){
                    $a = (res.data[i])[0];
                    $b = (res.data[i])[1];
                    $c = (res.data[i])[2];
                    $d = (res.data[i])[3];
                    $e = (res.data[i])[4];
                    var con = document.createElement("li");
                    con.id = $c;
                    con.class = "Square";
                    con.innerHTML ='<div class="username"><img src="./' + $e + ' "id="pictures">' + $a + ':' + '</div>' + '<br>' + '<div class="content">' + $b + '</div>' + '<br>' + '<div class="time">' + $d + '</div>' + '<footer><button type="button" class="button1" onclick="modify(' + $c +')"> 修改 </button><button type="button" class="button2" onclick="Delete(' + $c +')"> 删除 </button><button type="button" class="button1" onclick="reply1(' + $c +')"> 回复 </button><button type="button" class="button2" onclick="seereply(' + $c +')"> 查看回复 </button></footer>' + '<br>';
                    content.insertBefore(con,content.childNodes[0]);
                    //content.appendChild(con);
                }
                turningpage2(pid+1);
            }
            
            }
        }

    xhttp.open("POST","./nextpage.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var arr = {pid};
    JSON.stringify(arr);
    xhttp.send("pid=" + pid);
}

function turningpage1(data){
    var pages = data;
    var div = document.getElementById("msg-page");
    while(div.hasChildNodes()) //当div下还存在子节点时 循环继续
    {
        div.removeChild(div.firstChild);
    }
    var pcontent = document.getElementById("msg-page");
    var turn = document.createElement("div");
    turn.id = pages;
    turn.innerHTML = '<footer><div><button type="button" class="turn_to_last_page" onclick="lastpage('+pages+')">上一页</button></div><div id="page_number">第'+ pages + '页</div><div><button type="button" class="turn_to_next_page" onclick="nextpage('+pages+')">下一页</button></div></footer>';
    pcontent.appendChild(turn);
}
function turningpage2(data){
    var pages = data;
    var div = document.getElementById("msg-page");
    while(div.hasChildNodes()) //当div下还存在子节点时 循环继续
    {
        div.removeChild(div.firstChild);
    }
    var pcontent = document.getElementById("msg-page");
    var turn = document.createElement("div");
    turn.id = pages;
    turn.innerHTML = '<footer><div><button type="button" class="turn_to_last_page" onclick="lastpage('+pages+')">上一页</button></div><div id="page_number">第'+ pages + '页</div><div><button type="button" class="turn_to_next_page" onclick="nextpage('+pages+')">下一页</button></div></footer>';
    pcontent.appendChild(turn);
}

function reply1(data){
    var pid = data;
    var content = prompt("请输入您的回复");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode == 1){
                var judge = confirm(res.errmsg+"是否立即前往登录？")
                if(judge == true){
                    window.location.href="Login.html";
                }
            }else{
                if(res.errcode == 2){
                    alert(res.errmsg);
                }else{
                    alert(res.errmsg);
                }
            }
        }
    }
    xhttp.open("POST","./reply1.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    var arr = {content,pid};
    JSON.stringify(arr);
    xhttp.send("content=" + content + "&pid=" + pid);
}

function reply2(data){
    var pid = data;
    var content = prompt("请输入您的回复");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode == 1){
                var judge = confirm(res.errmsg+"是否立即前往登录？")
                if(judge == true){
                    window.location.href="Login.html";
                }
            }else{
                if(res.errcode == 2){
                    alert(res.errmsg);
                }else{
                    var content = document.getElementById("replycontent");
                        var con = document.createElement("li");
                        con.id = res.data.id;
                        con.class = "Square";
                        con.innerHTML = '<div class="username"><img src="./' + res.data.avatar + ' "id="pictures">' + res.data.user + ':' + '</div>' + '<br>' + '<div class="content">回复' + res.data.replyuser +':'+ res.data.reply + '</div>' + '<br>' + '<div class="time">' + res.data.time + '</div>' + '<footer><button type="button" class="button1" onclick="reply2(' + res.data.id +')"> 回复 </button></footer>'+ '<br>';
                        content.appendChild(con);
                }
            }
        }
    }
    xhttp.open("POST","./reply2.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    var arr = {content,pid};
    JSON.stringify(arr);
    xhttp.send("content=" + content + "&pid=" + pid);
}

function seereply(data){
    var pid = data;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if ( xhttp.readyState == 4 && xhttp.status == 200){
            var res = JSON.parse(xhttp.responseText);
            if(res.errcode==1){
                alert(res.errmsg);
            }
            for (let i = 0;i <= (res.length-1);i++){
                $user = (res[i])[0];
                $reply = (res[i])[1];
               	$replyuser = (res[i])[2];
                $time = (res[i])[3];
                $ID = (res[i])[4];
                $avatar = (res[i])[5];
                var content = document.getElementById("replycontent");
                var con = document.createElement("li");
                con.id = $ID;
                con.class = "Square";
                con.innerHTML = '<div class="username"><img src="./' + $avatar + ' "id="pictures">' + $user + ':' + '</div>' + '<br>' + '<div class="content">回复' + $replyuser +':'+ $reply + '</div>' + '<br>' + '<div class="time">' + $time + '</div>' + '<footer><button type="button" class="button1" onclick="reply2(' + $ID +')"> 回复 </button></footer>'+ '<br>';
                content.appendChild(con);   
            }
            var content = document.getElementById("replycontent");
            var con = document.createElement("li");
            con.class = "Square";
            con.innerHTML = '<div class="closereply"><button class="button1"onclick="closereply()">关闭回复</button></div>'
            content.insertBefore(con,content.childNodes[0]);
            content.style.visibility = "visible";
        }
    }  
    xhttp.open("POST","./viewreply.php");
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    
    var arr = {pid};
    JSON.stringify(arr);
    xhttp.send("pid=" + pid);
}


function closereply(){
    var replywindow = document.getElementById("replycontent");
    replywindow.style.visibility = "hidden";
    while(replywindow.hasChildNodes()) //当div下还存在子节点时 循环继续
    {
        replywindow.removeChild(replywindow.firstChild);
    }
}