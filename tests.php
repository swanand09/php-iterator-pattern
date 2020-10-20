<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "vendor/autoload.php";

use App\UnitTest;

$unitTest1 = new UnitTest();
if((int)$argv[1]>0) {
	$unitTest1->set_maxCommand($argv[1]);
	$unitTest1->generateRandomCommand();
}else{
	echo "Please pass a number!".PHP_EOL;
}