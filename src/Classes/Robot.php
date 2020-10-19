<?php

namespace App\Classes;

use App\Classes\Command;

class Robot {

    private $command;

    function __construct(){
	
	    $this->command = new Command();
    }
	
	/**
	 * @param $num
	 * @return BlockCollection
	 */
	public function generateBlockCollection($num): BlockCollection {
		$blockCollection = new BlockCollection();
		for($i=1;$i<=$num;$i++){
			$block = new Block();
			$block->set_name($i);
			$block->set_initialPosition($i);
			$block->set_actualPosition($i);
			$blockCollection->addBlock($block);
		}
		return $blockCollection;
	}
	
	public function validateCommand($commandText){
		
		$textSplit = explode(" ",$commandText);
		if(sizeof($textSplit)==4){
			return $this->handleCommand($textSplit);
		}
		
		return false;
	}
  
	/**
	 * break command text into parts to interpret
	 * @param $textSplit
	 */
    public function handleCommand($textSplit){
        
        list($firstPart,$firstBlock,$secondPart,$secondBlock) = $textSplit;
        
        if(in_array($firstPart,$this->command->get_firstPartValues()) && (int)$firstBlock > 0
	        && in_array($secondPart,$this->command->get_secondPartValues()) && (int)$secondBlock > 0) {
	     
	        $this->command->set_firstPart($firstPart);
	        $this->command->set_firstBlock($firstBlock);
	        $this->command->set_secondPart($secondPart);
	        $this->command->set_secondBlock($secondBlock);
	        return true;
        }
        return false;
    }
  	
	/**
	 * interpret command in parts
	 */
    public function executeCommand(){

    	//move a onto b
        if($this->command->get_firstPart()=='move' && $this->command->get_secondPart() =='onto'){
	        $this->moveBlockOnto();
        }
	
        //move a over b
	    if($this->command->get_firstPart()=='move' && $this->command->get_secondPart() =='over'){
		    $this->moveBlockOver();
	    }
	
	    //pile a onto b
	    if($this->command->get_firstPart()=='pile' && $this->command->get_secondPart() =='onto'){
		    $this->pileBlockStackOnto();
	    }
	    
	    //pile a over b
	    if($this->command->get_firstPart()=='pile' && $this->command->get_secondPart() =='over'){
		    $this->pileBlockStackOver();
	    }
    }
    
    private function moveBlockOnto(){
        
        die('moveBlockOnto');
    }
    
    private function moveBlockOver(){
    
    	die('moveBlockOver');
    }
    
    private function pileBlockStackOnto(){
    
        die('pileBlockStackOnto');
    }
	
	private function pileBlockStackOver(){
	
		die('pileBlockStackOver');
	}

}