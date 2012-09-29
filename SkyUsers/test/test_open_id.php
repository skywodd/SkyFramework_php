<form action="index.php?test=openid" method="POST">
    <label for="uid">User id</label><br />
    <input type="text" name="uid" id="uid" />
    <input type="submit" />
</form>

<?php

$form = new SkyFormCheck($_POST);
$form->addInput('uid');

if($form->isComplete()) {
    
  $user = new SkyUsers('users');
  
  if(!$user->openById($form->getValue('uid'))) {
      
      echo '<p>User not found !</p>';
  } else {
      
      var_dump($user->getUser()->toArray());
  }
}

?>
