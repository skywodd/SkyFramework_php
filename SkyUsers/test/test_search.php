<form action="index.php?test=search" method="POST">
    <label for="uid">User id</label><br />
    <input type="text" name="uid" id="uid" />
    <input type="submit" />
</form>

<form action="index.php?test=search" method="POST">
    <label for="nickname">Nickname</label><br />
    <input type="text" name="nickname" id="nickname" />
    <input type="submit" />
</form>


<form action="index.php?test=search" method="POST">
    <label for="dname">Display name</label><br />
    <input type="text" name="dname" id="dname" />
    <input type="submit" />
</form>

<form action="index.php?test=search" method="POST">
    <label for="email">Email</label><br />
    <input type="text" name="email" id="email" />
    <input type="submit" />
</form>


<?php

$formUID = new SkyFormCheck($_POST);
$formNickname = new SkyFormCheck($_POST);
$formDname = new SkyFormCheck($_POST);
$formEmail = new SkyFormCheck($_POST);

$formUID->addInput('uid');
$formNickname->addInput('nickname');
$formDname->addInput('dname');
$formEmail->addInput('email');

if($formUID->isComplete()) {
    
  $user = new SkyUsers('users');
  
  $res = $user->searchById($formUID->getValue('uid'), 0, 15);
  
  var_dump($res);
}

if($formNickname->isComplete()) {
    
  $user = new SkyUsers('users');
  
  $res = $user->searchByNickname($formNickname->getValue('nickname'), 0, 15);
  
  var_dump($res);
}

if($formDname->isComplete()) {
    
  $user = new SkyUsers('users');
  
  $res = $user->searchByDisplayName($formDname->getValue('dname'), 0, 15);
  
  var_dump($res);
}

if($formEmail->isComplete()) {
    
  $user = new SkyUsers('users');
  
  $res = $user->searchByEmail($formEmail->getValue('email'), 0, 15);
  
  var_dump($res);
}

?>
