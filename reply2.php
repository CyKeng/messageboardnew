<?php
header('Content-Type: application/json');
session_start();

$connect = mysqli_connect("localhost","root","root","messageboard");

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $pid = $_POST['pid'];
    
    $stmt = mysqli_prepare($connect,"SELECT user FROM mbd WHERE ID = ?");
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
    date_default_timezone_set('PRC');
	$datenew = date('Y-m-d H:i:s',time());
    $stmt = mysqli_prepare($connect,"SELECT username,parentID FROM replylist WHERE ID = ?");
    mysqli_stmt_bind_param($stmt,'i',$pid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$ruser,$puserID);
    mysqli_stmt_fetch($stmt);
    $replyuser = $ruser;
    $parentuserID = $puserID;
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($connect,"SELECT avatar FROM test1 WHERE username = ?");
    mysqli_stmt_bind_param($stmt,'s',$user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$ravatar);
    mysqli_stmt_fetch($stmt);
    $avatar = $ravatar;
    mysqli_stmt_close($stmt);
    
    $stmt = mysqli_prepare($connect,"INSERT INTO replylist (username,reply,time,replyID,replyuser,parentID,avatar) values 	(?,?,'$datenew',?,?,?,?)");				
    mysqli_stmt_bind_param($stmt,'ssisis',$user,$replycontent,$pid,$replyuser,$parentuserID,$avatar);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
    
    $i = "select ID,avatar from replylist where time = '$datenew'";
    $d = mysqli_query($connect,$i);
    $id = mysqli_fetch_assoc($d);
    $result = [
        'errcode' => 0,
        'data' => [
            'user' => $user,
            'reply' => $replycontent,
            'id' => $id['ID'],
            'time' => $datenew,
            'replyuser' => $replyuser,
            'avatar' => $avatar
        ],     
    ] ;
}
echo json_encode($result);