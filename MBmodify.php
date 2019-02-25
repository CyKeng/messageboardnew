<?php
header('Content-Type: application/json');
session_start();

$link = mysqli_connect("localhost","root","root","messageboard");

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $pid = $_POST['pid'];

    $stmt = mysqli_prepare($link,"SELECT user,avatar FROM mbd WHERE ID = ?");
    mysqli_stmt_bind_param($stmt,'i',$pid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$ID,$avatar);
    mysqli_stmt_fetch($stmt);

}else{
    $result=[
        'errcode' => 1,
        'errmsg' => '你还没有登录！',
    ];
    echo json_encode($result);
    die();
}

if($user != $ID){
    $result=[
        'errcode' => 1,
        'errmsg' => '你还没有登录！',
    ];
    echo json_encode($result);
    
    die();
}

$acontent = $_POST['content'];
$content = htmlspecialchars($acontent,ENT_QUOTES);
if ( empty($content) OR $content==null){
    $result=[
        'errcode' => 2,
        'errmsg' => '留言内容不能为空！',
    ];
}else{
    date_default_timezone_set('PRC');
    $datenew = date('Y-m-d H:i:s',time());
    $result = [
        'errcode' => 0,
        'errmsg' => '修改成功',
        'data' => [
            'msg' => $content,
            'user' => $user,
            'time' => $datenew,
            'avatar' => $avatar
        ],     
    ] ;
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($link,"UPDATE mbd SET msg = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt,'si',$content,$pid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    $stmt = mysqli_prepare($link,"UPDATE mbd SET time = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt,'si',$datenew,$pid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
echo json_encode($result);