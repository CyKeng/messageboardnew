<?php
header('Content-Type: application/json');
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $link = mysqli_connect("localhost","root","root","messageboard");

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}else{
    $result=[
        'errcode' => 2,
        'errmsg' => '你还没有登录！',
        'data' =>''
    ];
    echo json_encode($result);
    die();
}

$amsg = $_POST['msg'];
$msg = htmlspecialchars($amsg,ENT_QUOTES);

if ( empty($msg)OR $msg==null){
    $result=[
        'errcode' => 1,
        'errmsg' => '留言内容不能为空！',
        'data' => ''
    ];
}else{
    date_default_timezone_set('PRC');
    $datenew = date('Y-m-d H:i:s',time());
    
    $stmt = mysqli_prepare($link,"SELECT avatar FROM test1 WHERE username = ?");
    mysqli_stmt_bind_param($stmt,'s',$user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$ravatar);
    mysqli_stmt_fetch($stmt);
    $avatar = $ravatar;
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($link,"INSERT INTO mbd (user,msg,time,avatar) values (?,?,'$datenew',?)");
    mysqli_stmt_bind_param($stmt,'sss',$user,$msg,$avatar);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $i = "select ID,avatar from mbd where time = '$datenew'";
    $d = mysqli_query($link,$i);
    $id = mysqli_fetch_assoc($d);
    $result = [
        'errcode' => 0,
        'errmsg' => '',
        'data' => [
            'user' => $user,
            'msg' => $msg,
            'id' => $id['ID'],
            'time' => $datenew,
            'avatar' => $id['avatar']
        ],     
    ] ;
    
}
echo json_encode($result);}

else{
    $link = mysqli_connect("localhost","root","","messageboard");
    $sql = "select user,msg,ID,time,avatar from mbd order by ID DESC limit 0,10";
    $res = mysqli_query($link,$sql);
    $arr = mysqli_fetch_all($res);
    echo json_encode($arr);
}