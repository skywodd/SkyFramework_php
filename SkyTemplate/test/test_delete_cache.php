<?php

global $template;

$template->setCache('test_cache.html', 1);
$template->deleteFromCache();

echo '<p>test_cache.html deleted from cache !</p>';

$template->close();
?>
