<?php
session_start();

$result = [];
$link = mysqli_connect("localhost","root","root","messageboard");
if(!$link){
    $result = [
        'errcode' => 1,
        'errmsg' => '数据库连接失败',
        'data' => ''
    ];
   echo json_encode($result);
    exit();
}   

$ausername = $_POST['username'];
$apassword = $_POST['password'];
$username = htmlspecialchars($ausername,ENT_QUOTES);
$password = htmlspecialchars($apassword,ENT_QUOTES);


if(empty($username) OR empty($password)){
    $result=[
        'errcode' => 4,
        'errmsg' => '请保证填写所有内容！',
        'data' => ''

    ];
    echo json_encode($result);
    die();
}

$stmt = mysqli_prepare($link,"SELECT username FROM test1 WHERE username = ?");
mysqli_stmt_bind_param($stmt,'s',$username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$name);
mysqli_stmt_fetch($stmt);

if (empty($name)){
    
    $result = [
        'errcode' => 1,
        'errmsg' => '用户不存在或密码错误！',
        'data' => ''
    ];
}
else {
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($link,"SELECT username,password FROM test1 WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($stmt,'ss',$username,$password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$data1,$data2);
    mysqli_stmt_fetch($stmt);
    if (empty($data1) OR empty($data2)){
        $result=[
            'errcode' => 2,
            'errmsg' => '用户不存在或密码错误！',
            'data' => ''
        ];
    }
    else{
        mysqli_stmt_close($stmt);
        $stmt = mysqli_prepare($link,"SELECT times,lasttime FROM test1 WHERE username = ?");
        mysqli_stmt_bind_param($stmt,'s',$username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$data1,$data2);
        mysqli_stmt_fetch($stmt);
        
        $result = [
            'errcode' => 0,
            'errmsg' => '',
            'data' => [
                "number_of_times" => $data1,
                "last_login_time" => $data2
            ]
        ] ;
        date_default_timezone_set('PRC');
        $datenew = date('Y-m-d-H-i-s',time());
        
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($link,"UPDATE test1 SET lasttime = '$datenew' WHERE username = ?");
        mysqli_stmt_bind_param($stmt,'s',$username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($link,"UPDATE test1 SET times = times+1 WHERE username = ?");
        mysqli_stmt_bind_param($stmt,'s',$username);
        mysqli_stmt_execute($stmt);

        $_SESSION['user'] = $username;
        }
}
echo json_encode($result);
exit; 