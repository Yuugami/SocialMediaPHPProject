<?php

// Login Query

$UserId = "0001";
$UserPassword = 'password1';

$dbConnection = parse_ini_file("db_connection.ini");
extract($dbConnection);
$myPdo = new PDO($dsn, $user, $password);
$sql = 'SELECT UserId, Name FROM Users WHERE UserId = :userId AND Password = :password';
$pStatment = $myPdo->prepare($sql);
$pStatment->execute(array('userId' => $UserId, 'password' => $UserPassword));

$data = $pStatment->fetch();

if($data['UserId'] != null){
    print_r($data['Name']);
}else{
    print_r('No user login');
}

?>