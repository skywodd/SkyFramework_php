<html>
    <head>
        <title>Mail sender test</title>
    </head>
    <body>

        <?php
        define('APPS_RUNNING', true);

        include 'SkyMail.class.php';
        
        $mail = new SkyMail();
        
        $mail->setDateNow();
        //$mail->setContentTypeHtml(SkyMail::CHARSET_UTF8);
        $mail->setContentTypeMultiPart(SkyMail::MULTIPART_MIXED);
        
        $mail->addTo('skywodd@gmail.com');
        $mail->addFrom('chuck.norris@life.org');
        $mail->addNamedReplyTo('Root', 'root@example.com');
        
        $mail->addContent('Hi ! This is a fucking simple Hello World from SkyMail !');
        $mail->addSubject('SkyMail Test');
        
        $mail->setPriority(SkyMail::PRIORITY_NON_URGENT);
        $mail->setContentDescription('Sent from SkyMail !');
        
        $mail->addAttachement('index.php');
        $mail->addBcc('plop@example.com');
        $mail->addNamedBcc('Mr Plop', 'plop2@example.com');
        
        $mail->send();
        
        ?>
    </body>
</html>