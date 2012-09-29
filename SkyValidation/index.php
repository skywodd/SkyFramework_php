<html>
    <head>
        <title>Test ticket management</title>
    </head>
    <body>

        <form action="index.php" method="POST">
            <label for="uid">User id</label><br />
            <input type="text" name="uid" id="uid" />
            <input type="submit" />
        </form>

        <?php
        define('APPS_RUNNING', true);

        include '../SkySql/SkySql.class.php';
        include 'SkyValidation.php';
        include '../SkyFormCheck/SkyFormCheck.class.php';

        $sql = new SkySql('localhost', 'skyduino', 'skyduino', 'skyduino');

        $form = new SkyFormCheck($_POST);
        $form->addInput('uid');

        if ($form->isComplete()) {

            $ticket = new SkyValidation('tickets');

            $ticket->openById($form->getValue('uid'));

            echo 'Has ticket ? ' . (int) $ticket->hasTicket() . '<br />';
            
            $ticket->createTicket();

            echo 'New ticket : ' . $ticket->getTicket() . '<br />';
            
            $ticket->deleteTicket();
            
            $ticket->close();
            
        }
        ?>
    </body>
</html>