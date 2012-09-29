<?php

global $template;

$template->open('test_simple.html');

$template->addSimpleVar('TITLE', 'Bonjour !');

$template->addArrayVar(Array('TEST' => 'Hello world !', 'TEST2' => 'Coucou !'));

echo '<!-- Time : ' . $template->parse() . ' -->';

echo $template->getOutput();

$template->close();
        
?>
