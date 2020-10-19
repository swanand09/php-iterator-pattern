<?php

namespace App\Classes;

use App\Classes\Command;

class Robot {

    private $command;

    function __construct(){
	
	    $this->command = new Command();
    }
  
	/**
	 * break command text into parts to interpret
	 * @param $commandText
	 */
    public function handleCommand($commandText){
        
        list($firstPart,$firstBlock,$secondPart,$secondBlock) = explode(" ",$commandText);
        $this->command->set_firstPart($firstPart);
	    $this->command->set_firstBlock($firstBlock);
	    $this->command->set_secondPart($firstPart);
	    $this->command->set_secondBlock($secondBlock);
    }
  	
	/**
	 * interpret command in parts
	 */
    private function interpretCommand(){

    	//move a onto b
        if($this->command->get_firstPart()=='move' && $this->command->get_secondPart =='onto'){
	        $this->moveBlockOnto();
        }
	
        //move a over b
	    if($this->command->get_firstPart()=='move' && $this->command->get_secondPart =='over'){
		    $this->moveBlockOver();
	    }
	
	    //pile a onto b
	    if($this->command->get_firstPart()=='pile' && $this->command->get_secondPart =='onto'){
		    $this->pileBlockStackOnto();
	    }
	    
	    //pile a over b
	    if($this->command->get_firstPart()=='pile' && $this->command->get_secondPart =='over'){
		    $this->pileBlockStackOver();
	    }
    }
    
    private function moveBlockOnto(){
    
    
    }
    
    private function moveBlockOver(){
    
    
    }
    
    private function pileBlockStackOnto(){
    
    
    }
	
	private function pileBlockStackOver(){
	
	
	}

}