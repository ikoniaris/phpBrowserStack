<?php
require_once(__DIR__.'/phpBrowserStack.class.php');

$browserStack = new phpBrowserStack('foo', 'bar');

print_r($browserStack);

?>