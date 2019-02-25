<?php
header('Content-Type: application/json');
session_start();

$link = mysqli_connect("localhost","root","root","messageboard");

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $pid = $_POST['pid'];
    $stmt = mysqli_prepare($link,"SELECT user FROM mbd WHERE ID = ?");
    mysqli_stmt_bind_param($stmt,'i',$pid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$ID);
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
}else{
    
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($link,"DELETE FROM mbd WHERE ID = ?");
    mysqli_stmt_bind_param($stmt,'i',$pid);
    mysqli_stmt_execute($stmt);
    $result=[
        'errcode' => 0,
        'errmsg' => '删除成功！',
    ];
}echo json_encode($result);