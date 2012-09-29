<?php

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Close and unset log</p>';
$log->close();

echo '<p>Trying getAfter </p>';
try {
	$res = $log->getAfter('x');
}catch(Exception $e) {
	echo '<p>Exception triggered ! ' . $e->getMessage() . '</p>';
}

echo '<p>Trying getAll </p>';
try {
	$res = $log->getAll();
}catch(Exception $e) {
	echo '<p>Exception triggered ! ' . $e->getMessage() . '</p>';
}

echo '<p>Trying getBefore </p>';
try {
	$res = $log->getBefore('x');
}catch(Exception $e) {
	echo '<p>Exception triggered ! ' . $e->getMessage() . '</p>';
}

echo '<p>Trying getBetween </p>';
try {
	$res = $log->getBetween('x', 'x');
}catch(Exception $e) {
	echo '<p>Exception triggered ! ' . $e->getMessage() . '</p>';
}

echo '<p>Trying getLast </p>';
try {
	$res = $log->getLast(5);
}catch(Exception $e) {
	echo '<p>Exception triggered ! ' . $e->getMessage() . '</p>';
}

echo '<p>Trying write </p>';
try {
	$res = $log->getBefore(SkyLogger::NONE, 'x');
}catch(Exception $e) {
	echo '<p>Exception triggered ! ' . $e->getMessage() . '</p>';
}

echo '<p>Trying getSize </p>';
try {
	$res = $log->getSize();
}catch(Exception $e) {
	echo '<p>Exception triggered ! ' . $e->getMessage() . '</p>';
}

unset($log);

?>