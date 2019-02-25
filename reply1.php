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
    mysqli_stmt_bind_result($stmt,$ruser);
    mysqli_stmt_fetch($stmt);
    $replyuser = $ruser;
    mysqli_stmt_close($stmt);
}else{
    $result=[
        'errcode' => 1,
        'errmsg' => '你还没有登录！',
    ];
    echo json_encode($result);
    die();
}



$replycontent = $_POST['content'];
$reply = htmlspecialchars($replycontent,ENT_QUOTES);
if ( empty($reply) OR $reply==null){
    $result=[
        'errcode' => 2,
        'errmsg' => '回复内容不能为空！',
    ];
}else{
    $result = [
        'errcode' => 0,
        'errmsg' => '回复成功',     
    ] ;

    $stmt = mysqli_prepare($link,"SELECT avatar FROM test1 WHERE username = ?");
    mysqli_stmt_bind_param($stmt,'s',$user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$ravatar);
    mysqli_stmt_fetch($stmt);
    $avatar = $ravatar;
    mysqli_stmt_close($stmt);

    date_default_timezone_set('PRC');
	$datenew = date('Y-m-d H:i:s',time());
    $stmt = mysqli_prepare($link,"INSERT INTO replylist (username,reply,time,replyID,replyuser,parentID,avatar) values 	(?,?,'$datenew',?,?,?,?)");				
    mysqli_stmt_bind_param($stmt,'ssisis',$user,$replycontent,$pid,$replyuser,$pid,$avatar);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

echo json_encode($result);
mysqli_close($link);