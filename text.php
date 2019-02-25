<?php
header('Content-Type: application/json');
$result = [
    "errcode" => 1,
    "errmsg" => "出错了",
    "data" =>""
];
json_encode($result);