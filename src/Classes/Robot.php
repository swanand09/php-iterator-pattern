<?php

namespace App\Classes;

use App\Classes\Command;

class Robot {

    private $command;
    private $shoutMessage;
    
    private $blockCollection;

    function __construct(){
	
	    $this->command = new Command();
    }
	
    public function get_blockCollection(){
    	
    	return $this->blockCollection;
    }
    
	/**
	 * @param $num
	 *
	 */
	public function generateBlockCollection($num) {
		$this->blockCollection = new BlockCollection();
		for($i=1;$i<=$num;$i++){
			$block = new Block();
			$block->set_name($i);
			$block->set_initialPosition($i);
			$block->set_actualPosition($i);
			$this->blockCollection->addBlock($block);
		}
		$this->blockCollection->set_numBlocks($num);
		
	}
	
	public function validateCommand($commandText){
		
		$textSplit = explode(" ",$commandText);
		if(sizeof($textSplit)==4){
			return $this->handleCommand($textSplit);
		}
		
		return false;
	}
  
	public function getShoutMessage()
	{
		return $this->shoutMessage;
	}
	
	/**
	 * break command text into parts to interpret
	 * @param $textSplit
	 * @return bool
	 *
	 */
    public function handleCommand($textSplit): bool{
        
        list($firstPart,$firstBlock,$secondPart,$secondBlock) = $textSplit;
        
        if($firstBlock <= $this->blockCollection->get_numBlocks()) {
	
	        if($secondBlock <= $this->blockCollection->get_numBlocks()) {
		
		        if ($firstBlock != $secondBlock) {
			
			        if (in_array($firstPart, $this->command->get_firstPartValues())) {
				
				        if ((int)$firstBlock > 0) {
					
					        if (in_array($secondPart, $this->command->get_secondPartValues())) {
						
						        if ((int)$secondBlock > 0) {
							
							        $this->command->set_firstPart($firstPart);
							        $this->command->set_firstBlock($firstBlock);
							        $this->command->set_secondPart($secondPart);
							        $this->command->set_secondBlock($secondBlock);
							
							        return true;
						        } else {
							        $this->shoutMessage = "Second block should be a number. Please try again!";
						        }
						
					        } else {
						
						        $this->shoutMessage = "Third text of the command should be 'onto' or 'over'. Please try again!";
					        }
					
				        } else {
					        $this->shoutMessage = "First block should be a number. Please try again!";
				        }
				
			        } else {
				        $this->shoutMessage = "First text of the command should be 'move' or 'pile'. Please try again!";
			        }
		        } else {
			        $this->shoutMessage = "Pile or move same block is not allowed. Please try again!";
		        }
	        }else{
		        $this->shoutMessage = "The second block cannot be greater than the total number of blocks $this->blockCollection->get_numBlocks(). Please try again!";
	        }
        }else{
	        $this->shoutMessage = "The first block cannot be greater than the total number of blocks $this->blockCollection->get_numBlocks(). Please try again!";
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
        
    	
        //check if first block has stack
	    // if yes set each block to its initial position
	    try {
		    foreach ($this->blockCollection->getIterator() as $block) {
			    if($block->get_name()==(int)$this->command->get_firstBlock()){
			    	
			    	if(count($block->getStackCollection())>0){
					    foreach ($block->getStackCollection->getIterator() as $block) {
					    
					    }
				    }
			    }
		    }
	    }catch (Exception $e){
		    $this->printText($e->getMessage());
		    exit;
	    }
	    
	    
	    //check if second block has stack
	    // if yes set each block to its initial position
	    
	    //change position of first block to position of second block
	    // set first block as stack of second block
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