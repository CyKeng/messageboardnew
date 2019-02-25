<?php
header('Content-Type: application/json');


$link = mysqli_connect("localhost","root","root","messageboard");
if(!$link){
    $result = [
        'errcode' => 1,
        'errmsg' => '数据库连接失败',
        'data' => ''
    ];
   echo json_encode($result);
}   

$ausername = $_POST['username'];
$apassword = $_POST['password'];
$acheckpwd = $_POST['checkpwd'];
$username = htmlspecialchars($ausername,ENT_QUOTES);
$password = htmlspecialchars($apassword,ENT_QUOTES);
$checkpwd = htmlspecialchars($acheckpwd,ENT_QUOTES);

if(empty($username) OR empty($password) OR empty($checkpwd)){
    $result=[
        'errcode' => 4,
        'errmsg' => '请保证填写所有内容！',
        'data' => ''

    ];
    echo json_encode($result);
    die();
}

$postname = $username;
$stmt = mysqli_prepare($link,"SELECT username FROM test1 WHERE username = ?");
mysqli_stmt_bind_param($stmt,'s',$postname);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$name);
mysqli_stmt_fetch($stmt);

if (!empty($name)){
    
    $result = [
        'errcode' => 2,
        'errmsg' => '该用户名已经存在！',
        'data' => ''
    ];
}
else{
    if($password != $checkpwd){
        $result=[
            'errcode' => 3,
            'errmsg' => '两次输入密码不一致！',
            'data' => ''
        ];
    }
    else{
        $result = [
            'errcode' => 0,
            'errmsg' => '',
            'data' => ''
        ] ;
        mysqli_stmt_close($stmt);
        $avatar = "avatar/default.jpg";
        $stmt = mysqli_prepare($link,"INSERT INTO test1 (username,password,times,avatar) values (?,?,?,?)");
        $times = 1;
        $postname = $username;
        $postpwd = $password;
        mysqli_stmt_bind_param($stmt,'ssis',$postname,$postpwd,$times,$avatar);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);        
    }
}
echo json_encode($result);
exit;   
