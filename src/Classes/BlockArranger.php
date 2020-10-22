<?php
namespace App\Classes;

use App\Classes\Robot;

class BlockArranger{
	
	public $robot;
	
	function __construct()
	{
		
		$this->robot = new Robot();
	}
	
	public function printText($text)
	{
		
		echo $text;
		echo PHP_EOL;
	}
	
	public function init()
	{
		$this->printText("Enter number of blocks: ");
		$this->handleUserInput();
	}
	
	public function readInput($input)
	{
		
		$filename = trim($input);
		$inputs = file($filename);
		
		if ($inputs && count($inputs) > 1) {
			$num =(int)$inputs[0];
			
			if ($num > 0 && $num <= $this->robot->get_maxBlocks()) {
				
				$this->printText("You have $num blocks");
				$this->robot->generateBlockCollection($num);
				array_shift($inputs);
				foreach ($inputs as $command) {
					$command = trim($command);
					if ($command != $this->robot->get_command()->get_exitCommand()) {
						//validate command
						if ($this->robot->validateCommand($command)) {
							
							$this->printText($command);
							// execute command
							$this->robot->executeCommand();
						} else {
							
							
							$this->printText($this->robot->getMessage());
							$this->printText($command);
							break;
						}
					} else {
						//print table blocks and respective stacks
						$this->robot->printResult();
						$this->printText("Humble servant always at your service! Bye!");
						break;
					}
				}
			} else {
				
				$this->printText("Wrong value! Please input a number within range 2 <= n <={$this->robot->get_maxBlocks()}!");
			}
		}else{
			throw new \Exception( "file does not exist");
		}
	}
	
	
	/*
	public function init()
	{
		$this->printText("Enter number of blocks: ");
		$this->handleUserInput();
	}
	*/
	
	
	
	
	public function handleUserInput($command=false)
	{
		
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
			if($commandText!=$this->robot->get_command()->get_exitCommand()) {
				
				if ($this->robot->validateCommand($commandText)) {
					
					// execute command
					$this->robot->executeCommand();
				} else {
					
					$this->printText($this->robot->getMessage());
					$this->handleUserInput(true);
				}
			}else{
				
				//print table blocks and respective stacks
				
				$this->printText("Humble servant always at your service! Bye!");
				exit;
			}
			
		}else {
			
			if ($num > 0 && $num<=$this->robot->get_maxBlocks()) {
				
				$this->printText("You have $num blocks");
				$this->robot->generateBlockCollection($num);
				
				$this->printText("Please enter a command");
				$this->handleUserInput(true);
			} else {
				
				$this->printText("Wrong value! Please input a number within range 2 <= n <={$this->robot->get_maxBlocks()}!");
				$this->handleUserInput();
			}
		}
	}
	
	public function __destruct() {
		$this->robot;
	}
	
}