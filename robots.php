<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "vendor/autoload.php";

use App\Classes\BlockArranger;

$blockArranger = new BlockArranger();

try {
	
	$blockArranger->init();
}catch(Exception $e){
	
	$blockArranger->printText("Robot fails with error:{$e->getMessage()} Please contact its creator!");
}





