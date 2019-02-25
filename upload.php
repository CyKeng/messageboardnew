<?php
header('Content-Type: application/json');
session_start();

$link = mysqli_connect("localhost","root","root","messageboard");
if($_FILES["file"]["error"]>0)
{
    echo"错误：".$_FILES["file"]["error"]."<br/>";
}
else{
    $user = $_SESSION['user'];
    $picturename = $_FILES["file"]["name"];
    move_uploaded_file($_FILES["file"]["tmp_name"],"avatar/" . $_FILES["file"]["name"]);
    $avatar = "avatar/" . $_FILES["file"]["name"];
    $stmt = mysqli_prepare($link,"UPDATE test1 SET avatar = ? WHERE username = ?");
    mysqli_stmt_bind_param($stmt,'ss',$avatar,$user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($link,"UPDATE mbd SET avatar = ? WHERE user = ?");
    mysqli_stmt_bind_param($stmt,'ss',$avatar,$user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($link,"UPDATE replylist SET avatar = ? WHERE username = ?");
    mysqli_stmt_bind_param($stmt,'ss',$avatar,$user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "修改成功";
}
?>
