<?php
header('Content-Type: application/json');

$connect =  mysqli_connect("localhost","root","root","messageboard");

$parentID = $_POST['pid'];
$sql = "select username,reply,replyuser,time,ID,avatar from replylist where parentID = '$parentID'";
$res = mysqli_query($connect,$sql);
$arr = mysqli_fetch_all($res);

echo json_encode($arr);
mysqli_close($connect);