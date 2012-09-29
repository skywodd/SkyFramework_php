<html>
    <head>
        <title>Test ticket management</title>
    </head>
    <body>

        <form action="index.php" method="POST">
            <label for="gid">Groupe id</label><br />
            <input type="text" name="gid" id="gid" />
            <input type="submit" />
        </form>

        <form action="index.php" method="POST">
            <label for="name">Search Groupe name</label><br />
            <input type="text" name="name" id="name" />
            <input type="submit" />
        </form>

        <?php
        define('APPS_RUNNING', true);

        include '../SkySql/SkySql.class.php';
        include 'SkyPermission.php';
        include '../SkyFormCheck/SkyFormCheck.class.php';

        $sql = new SkySql('localhost', 'skyduino', 'skyduino', 'skyduino');

        $form1 = new SkyFormCheck($_POST);
        $form1->addInput('gid');

        $form2 = new SkyFormCheck($_POST);
        $form2->addInput('name');
        
        $groupe = new SkyPermission('groupes');

        if ($form1->isComplete()) {

            $perm = $groupe->getPermission($form1->getValue('gid'));

            var_dump($perm);
        }

        if ($form2->isComplete()) {

            $perm = $groupe->searchByName($form2->getValue('name'), 0, 15);

            var_dump($perm);
        }
        
        var_dump($groupe->listPermissionById(0, 15, 'ASC'));
        
        var_dump($groupe->listPermissionByName(0, 15, 'ASC'));
        
        ?>
    </body>
</html>