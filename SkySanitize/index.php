<?php

define('APPS_RUNNING', true);

include 'SkySanitize.class.php';

$sanitize = new SkySanitize();

echo '<h1>Filter test</h1><br />';

$input = 'john.doe@example.com';
echo 'Email : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterEmail($input) . '<br />';

$input = 'john.doe@example';
echo 'Email : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterEmail($input) . '<br />';

$input = 'john.doe';
echo 'Email : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterEmail($input) . '<br />';

$input = 'john.&éàç@example.com';
echo 'Email : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterEmail($input) . '<br />';

/* ----- */
echo '<br />';

$input = 'http://google.com';
echo 'Url : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterUrl($input) . '<br />';

$input = 'google.com';
echo 'Url : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterUrl($input) . '<br />';

$input = 'http://google';
echo 'Url : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterUrl($input) . '<br />';

$input = 'google';
echo 'Url : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterUrl($input) . '<br />';

$input = '#{[[~{.com';
echo 'Url : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterUrl($input) . '<br />';

/* ----- */
echo '<br />';

$input = '`"azerty"\'qwerty\'`';
echo 'Quotes : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterQuotes($input) . '<br />';

/* ----- */
echo '<br />';

$input = '3.14';
echo 'Float : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterFloat($input) . '<br />';

$input = '-13.37';
echo 'Float : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterFloat($input) . '<br />';

$input = '42';
echo 'Float : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterFloat($input) . '<br />';

$input = 'nyan';
echo 'Float : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterFloat($input) . '<br />';

/* ----- */
echo '<br />';

$input = '1337';
echo 'Integer: ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterInteger($input) . '<br />';

$input = '-42';
echo 'Integer: ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterInteger($input) . '<br />';

$input = '3.14';
echo 'Integer: ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterInteger($input) . '<br />';

$input = 'nyan';
echo 'Integer: ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterInteger($input) . '<br />';

/* ----- */
echo '<br />';

$input = '<h1>Bonjour !</h1>';
echo 'Html : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterHtml($input) . '<br />';

$input = '<script>alert("XSS");</script>';
echo 'Html : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterHtml($input) . '<br />';

$input = '<plop>Not html</plop>';
echo 'Html : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterHtml($input) . '<br />';

/* ----- */
echo '<br />';

$input = '\' or 1 = 1 --';
echo 'String : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterString($input) . '<br />';

$input = 'àé"#*ù$^:;';
echo 'String : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterString($input) . '<br />';

$input = '<p>Good job team !</p>';
echo 'String : ' . $input . '<br />';
echo 'Output : ' . $sanitize->filterString($input) . '<br />';

/* ----- ----- ----- ----- ----- ----- ----- ----- */

echo '<h1>Validation test</h1><br />';

$input = 'john.doe@example.com';
echo 'Email : ' . $input . '<br />';
echo 'Output : ' . (int) $sanitize->validateEmail($input) . '<br />';

$input = 'john.doe@example';
echo 'Email : ' . $input . '<br />';
echo 'Output : ' . (int) $sanitize->validateEmail($input) . '<br />';

$input = 'john.doe';
echo 'Email : ' . $input . '<br />';
echo 'Output : ' . (int) $sanitize->validateEmail($input) . '<br />';

$input = 'john.&éàç@example.com';
echo 'Email : ' . $input . '<br />';
echo 'Output : ' . (int) $sanitize->validateEmail($input) . '<br />';

?>
