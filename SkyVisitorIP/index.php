<html>
    <head>
        <title>Visitor IP Test</title>
    </head>
    <body>
        <?php
        define('APPS_RUNNING', true);

        include 'SkyVisitorIP.class.php';

        echo '<h1>Your IP is : ' . SkyVisitorIP::getIP() . '</h1><br />';
        echo '<h1>Your Referer is : ' . SkyVisitorIP::getReferer() . '</h1><br />';
        echo '<h1>Your User-Agent is : ' . SkyVisitorIP::getUserAgent() . '</h1><br />';
        ?>
    </body>
</html>