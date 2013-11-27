<?php
require_once(__DIR__.'/phpBrowserStack.class.php');

$username   = 'user56';
$access_key = 'kUoC2qZFUQxi89teH5sm';

$browserStack = new phpBrowserStack($username, $access_key);
print_r($browserStack->getBrowsers(TRUE, TRUE));

?>