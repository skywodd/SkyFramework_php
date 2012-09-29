<form action="index.php?test=opennickname" method="POST">
    <label for="nickname">Nickname</label><br />
    <input type="text" name="nickname" id="nickname" />
    <input type="submit" />
</form>

<?php

$form = new SkyFormCheck($_POST);
$form->addInput('nickname');

if($form->isComplete()) {
    
  $user = new SkyUsers('users');
  
  if(!$user->openByNickname($form->getValue('nickname'))) {
      
      echo '<p>User not found !</p>';
  } else {
      
      var_dump($user->getUser()->toArray());
  }
}

?>
