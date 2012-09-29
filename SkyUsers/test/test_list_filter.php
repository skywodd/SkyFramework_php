<?php

$user = new SkyUsers('users');

echo 'Status = 1';
$res = $user->listById(0, 15, SkyUsers::ASC, Array('status' => '1'));

var_dump($res);

echo 'Groupe id = 1';
$res = $user->listById(0, 15, SkyUsers::ASC, Array('groupe_id' => '1'));

var_dump($res);

echo 'Groupe id = 0';
$res = $user->listById(0, 15, SkyUsers::ASC, Array('groupe_id' => '0'));

var_dump($res);

echo 'Status = 1 AND Groupe id = 1';
$res = $user->listById(0, 15, SkyUsers::ASC, Array('status' => '1', 'groupe_id' => '1'));

var_dump($res);

?>
