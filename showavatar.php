<?php
header('Content-Type: application/json');
session_start();

$user = $_SESSION['user'];
$link = mysqli_connect("localhost","root","root","messageboard");
$stmt = mysqli_prepare($link,"SELECT avatar FROM test1 WHERE username = ?");
mysqli_stmt_bind_param($stmt,'s',$user);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$ravatar);
mysqli_stmt_fetch($stmt);
$avatar = $ravatar;
mysqli_stmt_close($stmt);

$result = $avatar;
echo json_encode($result);