<p>Good form</p>
<form action="index.php" method="POST">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" /><br />
    <label for="password">Password</label>
    <input type="password" name="password" id="password" /><br />
    <label for="password2">Repeat password</label>
    <input type="password" name="password2" id="password2" /><br />
    <label for="mail">Mail</label>
    <input type="text" name="mail" id="mail" /><br />
    <label for="mail2">Repeat mail</label>
    <input type="text" name="mail2" id="mail2" /><br />
    <input type="submit" />
</form>

<p>Bad form</p>
<form action="index.php" method="POST">
    <label for="xusername">Username</label>
    <input type="text" name="username" id="xusername" /><br />
    <label for="xpassword">Password</label>
    <input type="password" name="password" id="xpassword" /><br />
    <label for="xmail">Mail</label>
    <input type="text" name="mail" id="xmail" /><br />
    <input type="submit" />
</form>

<?php

define('APPS_RUNNING', true);

include_once 'SkyFormCheck.class.php';

try {
    echo '<p>Instanciate new SkyFormCheck</p>';
    $form = new SkyFormCheck($_POST);

    $form->addInput('username');
    $form->addInputs(Array('password', 'password2', 'mail', 'mail2'));
    
    if(!$form->isComplete())
        echo 'Form not completed !';
    else
        echo 'Form completed !';
    
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>