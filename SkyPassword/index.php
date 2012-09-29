<p>Check password (good password is azerty)</p>
<form action="index.php" method="GET">
    <input type="hidden" name="action" value="check" />
    <input type="text" name="password" />
    <input type="submit" />
</form>

<p>Generate password (length : 12, upper + lower + numeric)</p>
<form action="index.php" method="GET">
    <input type="hidden" name="action" value="generate" />
    <input type="submit" />
</form>

<p>Generate password (length : 15, upper + lower + numeric + special)</p>
<form action="index.php" method="GET">
    <input type="hidden" name="action" value="generate2" />
    <input type="submit" />
</form>

<p>Get password strength</p>
<form action="index.php" method="GET">
    <input type="hidden" name="action" value="strength" />
    <input type="text" name="password" />
    <input type="submit" />
</form>

<?php
define('APPS_RUNNING', true);

include_once 'SkyPassword.class.php';

try {
    echo '<p>Instanciate new SkyPassword</p>';
    $passwd = new SkyPassword();

    //echo hash('sha256', 'azerty');
    
    if (!isset($_GET['action']))
        exit();

    switch ($_GET['action']) {

        case 'check':
            if ($passwd->check('f2d81a260dea8a100dd517984e53c56a7523d96942a834b9cdc249bd4e8c7aa9', $_GET['password']))
                echo '<br />Password match !';
            else
                echo '<br />Pasword don\'t match !';
            break;

        case 'generate':
            echo '<br />Password : ' . $passwd->generate(12, true, true);
            break;

        case 'generate2':
            echo '<br />Password : ' . $passwd->generate(15, true, true, true);
            break;

        case 'strength':
            echo '<br />Strength : ' . $passwd->getStrength($_GET['password']);
            break;

        default :
            echo '.';
            break;
    }
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>