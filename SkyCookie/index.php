<?php
define('APPS_RUNNING', true);

include_once 'SkyCookie.class.php';

if (!isset($_GET['test'])) {
    ?>
    <h1>Class Test</h1>
    <a href="index.php?test=create">Create</a><br />
    <a href="index.php?test=delete">Delete</a><br />
    <a href="index.php?test=exist">Exist</a><br />
    <a href="index.php?test=noexist">Not exist</a><br />
    <a href="index.php?test=get">Get</a><br />
    <?php
    exit();
}

//echo '<a href="index.php">Home</a><br />';
$cookie = new SkyCookie();

try {
    switch ($_GET['test']) {
        case 'create': {
                $cookie->create('test', 'Hello World !');
                echo 'Cookie created !';
            }
            break;

        case 'delete': {
                $cookie->delete('test');
                echo 'Cookie deleted !';
            }
            break;

        case 'exist': {
                if ($cookie->exist('test'))
                    echo 'Cookie exist';
                else
                    echo 'Cookie do not exist !';
            }
            break;

        case 'noexist': {
                if ($cookie->exist('johndoe'))
                    echo 'Cookie exist';
                else
                    echo 'Cookie do not exist !';
            }
            break;

        case 'get': {
                echo $cookie->getFrom('test');
            }
            break;
    }
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>