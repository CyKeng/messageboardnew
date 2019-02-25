<?php
header('Content-Type: application/json');

$link = mysqli_connect("localhost","root","root","messageboard");
$row = mysqli_fetch_assoc(mysqli_query($link,"SELECT count(*) AS record FROM mbd"));	
$rows = $row['record'];
$rowsPerPage = 10;

$pid = $_POST['pid'];
if($pid*10 > $rows){
    $res = [
        'errcode' => 1,
    ] ;
    echo json_encode($res);
    die();
}
$sql = "select user,msg,ID,time,avatar from mbd order by ID DESC limit ".($pid*$rowsPerPage) .",10";
$res = mysqli_query($link,$sql);
$arr = mysqli_fetch_all($res);
$result = [
    'errcode' => 0,
    'data' => $arr
] ;
echo json_encode($result);
