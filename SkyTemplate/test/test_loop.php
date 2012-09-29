<?php
global $template;

$template->open('test_loop.html');

$template->addNamespaceVar('test', 'nom', Array('John', 'Epic', 'Nyan'));
$template->addNamespaceVar('test', 'prenom', Array('Doe', 'Win', 'Cat'));

echo '<!-- Time : ' . $template->parse() . ' -->';

echo $template->getOutput();

$template->close();
?>
