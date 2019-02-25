<?php
header('Content-Type: application/json');

$link = mysqli_connect("localhost","root","root","messageboard");
$pid = $_POST['pid'];
$sql = "select user,msg,ID,time,avatar from mbd order by ID DESC limit " .($pid-2)*10 .",10";
$res = mysqli_query($link,$sql);
$arr = mysqli_fetch_all($res);
echo json_encode($arr);