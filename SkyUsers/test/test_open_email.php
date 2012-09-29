<form action="index.php?test=openemail" method="POST">
    <label for="email">User email</label><br />
    <input type="text" name="email" id="email" />
    <input type="submit" />
</form>

<?php

$form = new SkyFormCheck($_POST);
$form->addInput('email');

if($form->isComplete()) {
    
  $user = new SkyUsers('users');
  
  if(!$user->openByEmail($form->getValue('email'))) {
      
      echo '<p>User not found !</p>';
  } else {
      
      var_dump($user->getUser()->toArray());
  }
}

?>
