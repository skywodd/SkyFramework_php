<a href="index.php?test=blocks&show=1">Show block 1</a><br />
<a href="index.php?test=blocks&show=2">Show block 2</a><br />
<?php
global $template;

isset($_GET['show']) or $_GET['show'] = 1;

$template->open('test_blocks.html');

$template->addSimpleVar('MSG1', 'Hello block 1 !');
$template->addSimpleVar('MSG2', 'Hello block 2 !');

if ($_GET['show'] == 1) {
    $template->addBlock('block1', SkyTemplate::VISIBLE);
    $template->addBlock('block2', SkyTemplate::HIDDEN);
} else {
    $template->addBlock('block2', SkyTemplate::VISIBLE);
    $template->addBlock('block1', SkyTemplate::HIDDEN);
}

echo '<!-- Time : ' . $template->parse() . ' -->';

echo $template->getOutput();

$template->close();
?>
