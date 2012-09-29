<form action="index.php?test=update" method="POST">
    <label for="nickname">Nickname</label><br />
    <input type="text" name="nickname" id="nickname" />
    <input type="submit" />
</form>

<?php
$form = new SkyFormCheck($_POST);
$form->addInput('nickname');

if ($form->isComplete()) {

    $user = new SkyUsers('users');

    if (!$user->openByNickname($form->getValue('nickname'))) {

        echo '<p>User not found !</p>';
    } else {

        $data = $user->getUser();
        ?>
        <p>Editing : <?php echo $data->getNickname(); ?></p>
        <form action="index.php?test=update" method="POST">

            <input type="hidden" name="nickname" value="<?php echo $data->getNickname(); ?>" />

            <label for="displayname">Display Name</label><br />
            <input type="text" name="displayname" id="displayname" value="<?php echo $data->getDisplayName(); ?>" /><br />

            <label for="email">Email</label><br />
            <input type="text" name="email" id="email" value="<?php echo $data->getEmail(); ?>" /><br />

            <label for="password">Password</label><br />
            <input type="text" name="password" id="password" value="<?php echo $data->getPassword(); ?>" /><br />

            <label for="sexe">Sexe</label><br />
            <input type="text" name="sexe" id="sexe" value="<?php echo $data->getSexe(); ?>" /><br />

            <label for="region">Region</label><br />
            <input type="text" name="region" id="region" value="<?php echo $data->getRegion(); ?>" /><br />

            <label for="birthday">Birthday date</label><br />
            <input type="text" name="birthday" id="birthday" value="<?php echo $data->getBirthday(); ?>" /><br />

            <label for="status">Status</label><br />
            <input type="text" name="status" id="status" value="<?php echo $data->getStatus(); ?>" /><br />

            <label for="slogan">Slogan</label><br />
            <input type="text" name="slogan" id="slogan" value="<?php echo $data->getSlogan(); ?>" /><br />

            <label for="websitename">Website name</label><br />
            <input type="text" name="websitename" id="websitename" value="<?php echo $data->getWebsiteName(); ?>" /><br />

            <label for="websiteurl">Website url</label><br />
            <input type="text" name="websiteurl" id="websiteurl" value="<?php echo $data->getWebsiteUrl(); ?>" /><br />

            <label for="groupeid">Groupe id</label><br />
            <input type="text" name="groupeid" id="groupeid" value="<?php echo $data->getGroupeId(); ?>" /><br />

            <input type="submit" />
        </form>
        <?php
        unset($form);

        $form = new SkyFormCheck($_POST);
        $form->addInputs(Array('displayname', 'email', 'password', 'sexe', 'region', 'birthday', 'status', 'slogan', 'websitename', 'websiteurl', 'groupeid'));

        if ($form->isComplete()) {

            var_dump($_POST);

            $user->updateDisplayName($form->getValue('displayname'));

            $user->updateEmail($form->getValue('email'));

            if ($form->getValue('password') != $data->getPassword())
                $user->updatePassword(SkyPassword::compute($form->getValue('password')));

            $user->updateSexe($form->getValue('sexe'));

            $user->updateRegion($form->getValue('region'));

            $user->updateBirthday($form->getValue('birthday'));

            $user->updateStatus($form->getValue('status'));

            $user->updateSlogan($form->getValue('slogan'));

            $user->updateWebsiteName($form->getValue('websitename'));

            $user->updateWebsiteUrl($form->getValue('websiteurl'));

            $user->updateGroupeID($form->getValue('groupeid'));

            var_dump($user->getUser()->toArray());
        } else {
            echo 'Form empty !';
        }
    }
}
?>
