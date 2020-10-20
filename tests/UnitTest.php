<?php
namespace App\Tests;

use App\Classes\BlockArranger;
//use App\Classes\Robot;

class UnitTest{
	
	//public $commands = [];
	//public $robot;
	
	private $maxCommand;
	
	/*
	public function blockArranger()
	{
		$blockArranger = new BlockArranger();
	}
	*/
	
	public function set_maxCommand($max)
	{
		$this->maxCommand = $max;
	}
	
	public function generateRandomCommand()
	{
		$blockArranger = new BlockArranger();
		$numBlocks = rand(2,$blockArranger->robot->get_maxBlocks());
		$blockArranger->robot->generateBlockCollection($numBlocks);
		
		for($i=0;$i<$this->maxCommand;$i++){
			
			$textSplit = [];
			$firstPartValues = $blockArranger->robot->get_command()->get_firstPartValues();
			shuffle($firstPartValues);
			$firstPart = $firstPartValues[0];
			array_push($textSplit, $firstPart);
			$firstBlock = rand(1,$numBlocks);
			array_push($textSplit, $firstBlock);
			$secondPartValues = $blockArranger->robot->get_command()->get_secondPartValues();
			shuffle($secondPartValues);
			$secondPart = $secondPartValues[0];
			array_push($textSplit, $secondPart);
			$secondBlock= rand(1,$numBlocks);
			do{
				$secondBlock= rand(1,$numBlocks);
			}while($secondBlock == $firstBlock);
			
			array_push($textSplit, $secondBlock);
			
			$commandText = implode(" ",$textSplit);
			$blockArranger->printText($commandText);
			
			if($blockArranger->robot->handleCommand($textSplit)) {
				
				$blockArranger->robot->executeCommand();
			}
			
		}
		
		//display blocks stacks
	
	}
}