<?php

$user = new SkyUsers('users');

$res = $user->listByInscriptionDate(0, 15, SkyUsers::DESC);

var_dump($res);

?>
