--TEST--
Test Imagick, setRegistry and getRegistry
--SKIPIF--
<?php require_once(dirname(__FILE__) . '/skipif.inc'); ?>
--FILE--
<?php

$tmpPath = Imagick::getRegistry("temporary-path");
if ($tmpPath == null) {
	//I am unsure if this is guaranteed - it might be set via policy.xml
	echo "Temporary-path was empty at start.".PHP_EOL;
}

$currentPath = realpath(dirname(__FILE__));

Imagick::setRegistry("temporary-path", $currentPath);

$tmpPath = Imagick::getRegistry("temporary-path");
if ($tmpPath === false) {
	echo "Failed to set temporary-path".PHP_EOL;
}
else if ($tmpPath == $currentPath) {
	echo "Temporary path was set correctly.".PHP_EOL;
}

$registry = Imagick::listRegistry();

if (array_key_exists("temporary-path", $registry) == true) {
	if ($registry["temporary-path"] === $currentPath) {
		echo "Temporary path was listed correctly.".PHP_EOL;
	}
}


// https://github.com/mkoppanen/imagick/issues/185
// Calling Imagick::getRegistry() using a key that has not yet been set to the registry results in the following:
$imagick = new Imagick();
$imagick->setRegistry('temporary-path', '/home/vagrant');
$imagick->getRegistry('temporary-path'); // "/home/vagrant"
$imagick->getRegistry('this-is-a-non-existing-key');


?>
--EXPECTF--
Temporary-path was empty at start.
Temporary path was set correctly.
Temporary path was listed correctly.
