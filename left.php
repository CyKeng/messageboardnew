<?php
header('Content-Type: application/json');
session_start();

unset($_SESSION['user']);
$result=[
    'errcode' => 0,
];
echo json_encode($result);
