<?php

$user = new SkyUsers('users');

$res = $user->listById(0, 15, SkyUsers::DESC);

var_dump($res);

$res = $user->listById(0, 15, SkyUsers::ASC);

var_dump($res);

?>
