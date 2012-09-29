<form action="index.php?test=create" method="POST">
    <label for="nickname">Nickname</label><br />
    <input type="text" name="nickname" id="nickname" /><br />

    <label for="displayname">Display Name</label><br />
    <input type="text" name="displayname" id="displayname" /><br />

    <label for="email">Email</label><br />
    <input type="text" name="email" id="email" /><br />

    <label for="password">Password</label><br />
    <input type="text" name="password" id="password" /><br />

    <label for="sexe">Sexe</label><br />
    <input type="text" name="sexe" id="sexe" /><br />

    <label for="region">Region</label><br />
    <input type="text" name="region" id="region" /><br />

    <label for="birthday">Birthday date</label><br />
    <input type="text" name="birthday" id="birthday" /><br />

    <label for="status">Status</label><br />
    <input type="text" name="status" id="status" /><br />

    <label for="slogan">Slogan</label><br />
    <input type="text" name="slogan" id="slogan" /><br />

    <label for="websitename">Website name</label><br />
    <input type="text" name="websitename" id="websitename" /><br />

    <label for="websiteurl">Website url</label><br />
    <input type="text" name="websiteurl" id="websiteurl" /><br />

    <label for="groupeid">Groupe id</label><br />
    <input type="text" name="groupeid" id="groupeid" /><br />

    <input type="submit" />
</form>

<?php
$form = new SkyFormCheck($_POST);
$form->addInputs(Array('nickname', 'displayname', 'email', 'password', 'sexe', 'region', 'birthday', 'status', 'slogan', 'websitename', 'websiteurl', 'groupeid'));

if ($form->isComplete()) {

    $user = new SkyUsers('users');

    if (!$user->openByNickname($form->getValue('nickname'))) {

        $data = Array(
            'nickname' => $form->getValue('nickname'),
            'display_name' => $form->getValue('displayname'),
            'email' => $form->getValue('email'),
            'password' => SkyPassword::compute($form->getValue('password')),
            'sexe' => $form->getValue('sexe'),
            'region' => $form->getValue('region'),
            'birthday' => $form->getValue('birthday'),
            'status' => $form->getValue('status'),
            'birthday' => $form->getValue('birthday'),
            'slogan' => $form->getValue('slogan'),
            'website_name' => $form->getValue('websitename'),
            'website_url' => $form->getValue('websiteurl'),
            'groupe_id' => $form->getValue('groupeid')
        );
        
        $newuser = new SkyUser($data);

        $user->create($newuser);

        var_dump($user->getUser()->toArray());
    } else {

        echo '<p>User allready exist !</p>';
    }
}
?>
