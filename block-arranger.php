<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "vendor/autoload.php";
use App\Classes\Block;
use App\Classes\BlockCollection;
use App\Classes\Robot;

class BlockArranger{
	
	public $robot;
	
	function __construct(){
		
		$this->robot = new Robot();
	}
	
	public function printText($text){
		
		echo $text;
		echo PHP_EOL;
	}
	
	public function init(){
		$this->printText("Enter number of blocks: ");
		$this->handleUserInput();
	}
	
	public function handleUserInput($command=false){
		
		
		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		$num=0;
		$commandText = '';
		if(!$command) {
			$num = (int)trim($line);
		}else{
			$commandText = trim($line);
		}
		
		if(!empty($commandText)){
			
			//validate command
			if($this->robot->validateCommand($commandText)){
				
				// execute command
				$this->robot->executeCommand();
			}else{
				
				$this->printText($this->robot->getShoutMessage());
				$this->handleUserInput(true);
			}
			
		}else {
			
			if ($num > 0) {
				
				$this->printText("You have $num blocks");
				$collection =  $this->robot->generateBlockCollection($num);
				
				/*
				 try {
					 foreach ($collection->getIterator() as $item) {
						$this->printText($item->get_name());
					 }
				 }catch (Exception $e){
					 $this->printText($e->getMessage());
					 exit;
				 }*/
				
				
				$this->printText("Please enter a command");
				$this->handleUserInput(true);
			} else {
				$this->printText("Wrong value! Please input a number greater than 0!");
				$this->handleUserInput();
			}
		}
	}

}

$blockArranger = new BlockArranger();

try {
	$blockArranger->init();
}catch(Exception $e){
	$blockArranger->printText($e->getMessage());
}





