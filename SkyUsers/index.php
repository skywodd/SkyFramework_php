<html>
    <head>
        <title>Test User management</title>
    </head>
    <body>
        <?php
        define('APPS_RUNNING', true);

        include_once '../SkySql/SkySql.class.php';
        include_once '../SkyPassword/SkyPassword.class.php';
        include_once '../SkyRedirect/SkyRedirect.class.php';
        include_once '../SkyFormCheck/SkyFormCheck.class.php';
        include_once 'SkyUsers.class.php';

        if (!isset($_GET['test'])) {
            ?>
            <a href="index.php?test=openid">Test open by id</a><br />
            <a href="index.php?test=opennickname">Test open by nickname</a><br />
            <a href="index.php?test=openemail">Test open by email</a><br />
            <a href="index.php?test=create">Test create new user</a><br />
            <a href="index.php?test=delete">Test delete user</a><br />
            <a href="index.php?test=search">Test search user</a><br />
            <a href="index.php?test=listid">Test list users by id</a><br />
            <a href="index.php?test=listnickname">Test list users by nickname</a><br />
            <a href="index.php?test=listdate">Test list users by inscription date</a><br />
            <a href="index.php?test=listfilter">Test list users with filters</a><br />
            <a href="index.php?test=update">Test update user info</a><br />
            <?php
        }

        try {

            $redirect = new SkyRedirect(Array(
                        'default' => 'test/default.php',
                        'error' => 'test/error.php',
                        'openid' => 'test/test_open_id.php',
                        'opennickname' => 'test/test_open_nickname.php',
                        'openemail' => 'test/test_open_email.php',
                        'create' => 'test/test_create.php',
                        'delete' => 'test/test_delete.php',
                        'search' => 'test/test_search.php',
                        'listid' => 'test/test_list_id.php',
                        'listnickname' => 'test/test_list_nickname.php',
                        'update' => 'test/test_update.php',
                        'listfilter' => 'test/test_list_filter.php',
                        'listdate' => 'test/test_list_date.php'
                            ), $_GET, 'test');

            $sql = new SkySql('localhost', 'skyduino', 'skyduino', 'skyduino');

            $redirect->redirect();

            echo '<p>Sql request : ' . $sql->getQueryCount() . ' - Time used : ' . $sql->getExecutionTime() . '</p>';

            $sql->close();
        } catch (Exception $e) {
            echo '<p>Got exception : ' . $e->getMessage() . '</p>';
        }
        ?>
    </body>
</html>