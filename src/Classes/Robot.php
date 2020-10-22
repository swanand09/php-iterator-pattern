<?php

namespace App\Classes;

use App\Classes\Command;
use App\Classes\BlockCollection;
use App\Classes\StackCollection;

class Robot {

    private $command;
    private $message;
    
    private $stackCollection;

    function __construct(){
	
	    $this->command = new Command();
    }
	
	/**
	 * maximum blocks allowed
	 * @return int
	 */
    public function get_maxBlocks() :int
    {
    	return BlockCollection::maxBlocks;
    }
    
    public function get_command()
    {
    	return $this->command;
    }
	
    public function get_stackCollection()
    {
    	
    	return $this->stackCollection;
    }
    
	/**
	 * @param $num
	 *
	 */
	public function generateBlockCollection($num)
	{
		$this->stackCollection = new StackCollection();
		for($i=1;$i<=$num;$i++){
			$block = new Block();
			$block->set_name($i);
			$block->set_initialPosition(($i-1));
			$block->set_actualPosition(($i-1));
			$blockCollection  = new BlockCollection();
			$blockCollection->addBlock($block);
			$this->stackCollection->addStack($blockCollection);
		}
		$this->stackCollection->set_numBlocks((int)$num);
		
	}
	
	public function validateCommand($commandText)
	{
		if($this->command->get_exitCommand()!=$commandText) {
			
			$textSplit = explode(" ", $commandText);
			if (sizeof($textSplit) == 4) {
		
				return $this->handleCommand($textSplit);
			}else{
				$this->message = "Invalid Command. Please try again!";
			}
		}else{
			$this->message="exit command";
		}
		
		return false;
	}
  
	public function getMessage()
	{
		return $this->message;
	}
	
	/**
	 * break command text into parts to interpret
	 * @param $textSplit
	 * @return bool
	 *
	 */
    public function handleCommand($textSplit): bool
    {
        
		list($firstPart,$firstBlock,$secondPart,$secondBlock) = $textSplit;
		$isValid = true;
		
		if(!is_numeric($firstBlock)) {

			$this->message = "The first block entered should be a number. Please try again!";
			$isValid = false;
		}	
		
		if(!is_numeric($secondBlock)) {

			$this->message = "The second block entered should be a number. Please try again!";
			$isValid = false;
		}	
		
        if($firstBlock >= $this->stackCollection->get_numBlocks()) {

			$this->message = "The first block cannot be greater than the total number of blocks {$this->stackCollection->get_numBlocks()}. Please try again!";
			$isValid = false;
		}	
	
		if($secondBlock >= $this->stackCollection->get_numBlocks()) {

			$this->message = "The second block cannot be greater than the total number of blocks {$this->stackCollection->get_numBlocks()}. Please try again!";
			$isValid = false;
		}
		
		if ($firstBlock == $secondBlock) {

			$this->message = "The first block cannot be same number as second block. Please try again!";
			$isValid = false;
		}

		if (!in_array($firstPart, $this->command->get_firstPartValues())) {

			$this->message = "First text of the command should be 'move' or 'pile'. Please try again!";	
			$isValid = false;
		}	
		if ((int)$firstBlock < 0) {	        

			$this->message = "First block should be a number. Please try again!";
			$isValid = false;
		}
		if (!in_array($secondPart, $this->command->get_secondPartValues())) {
			
			$this->message = "Third text of the command should be 'onto' or 'over'. Please try again!";
			$isValid = false;
		}		
		if ((int)$secondBlock < 0) {

			$this->message = "Second block should be a number. Please try again!";
			$isValid = false;
		}	
		
		if($isValid){
				
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
    public function executeCommand()
    {
	
	    try {
		
		    //lookup firstBlock from collection
		    //attempt to check if the block based on its name or initial position is on same stack as initially set
		    $blockPosition = ((int)$this->command->get_firstBlock()-1);
		    $blockName = (int)$this->command->get_firstBlock();
		
		    //Quick Lookup
		    $detached_firstBlock = $this->searchStackByPosition($blockName,$blockPosition,'firstBlock');
		
		    if(is_null($detached_firstBlock)){
			
			    //search entire stack collection
			    $detached_firstBlock = $this->searchStackCollection($blockName,$blockPosition,'firstBlock');
		    }
		
		    //lookup secondBlock from collection
		    $secondBlockPosition = ((int)$this->command->get_secondBlock()-1);
		    $secondBlockName = (int)$this->command->get_secondBlock();
		
		    //Quick Lookup
		    $secondBlock_blockCollection = $this->searchStackByPosition($secondBlockName,$secondBlockPosition,'secondBlock');
		
		    if(is_null($secondBlock_blockCollection)){
			
			    //search entire stack collection
			    $secondBlock_blockCollection = $this->searchStackCollection($secondBlockName,$secondBlockPosition,'secondBlock');
		    }
		
		
		
		    switch(get_class($detached_firstBlock)){
			    case 'App\Classes\Block':
				
				    //set actual position of first block to the initial position of second block;
				    $detached_firstBlock->set_actualPosition($secondBlockPosition);
				    //add firstBlock as stack of secondBlock;
				    if(!is_null($secondBlock_blockCollection)) {
					    $secondBlock_blockCollection->addBlock($detached_firstBlock);
				    }
				
				    break;
			    case 'App\Classes\BlockCollection':
				
				    $firstBlockCollection = $detached_firstBlock;
				    $firstBlockCollection->setIterator();
				    
				    if(!is_null($secondBlock_blockCollection)) {
					
					   foreach ($firstBlockCollection->getIterator() as $block) {
						
						   $secondBlock_blockCollection->addBlock($block);
					   }
				    }else{
				    	
				    	$this->stackCollection->setIterator();
				    	$this->stackCollection->getIterator()->set_position($secondBlockPosition);
					    $secondBlock_blockCollection  = $this->stackCollection->getIterator()->current();
					    $secondBlock_blockCollection->setIterator();
					    $secondBlock_blockCollection->getIterator()->set_position(0);
					    foreach ($firstBlockCollection->getIterator() as $block) {
						
						    $secondBlock_blockCollection->addBlock($block);
					    }
					   
				    }
				
				    
				    break;
		    }
		    //ensure right index in blockCollection
		    $secondBlock_blockCollection->reindexBlock();
		
	    }catch (\Exception $e){
		
		    $this->message = "Got an internal problem({$e->getMessage()}). Please contact my creator!";
	    }
    	
    }
    
	
	//search stack for block at given position
	private function searchStackByPosition($name,$position,$whichBlock)
	{
		$this->stackCollection->setIterator();
		$this->stackCollection->getIterator()->set_position($position);
		$blockCollection = $this->stackCollection->getIterator()->current();
		return $this->searchBlockByName($blockCollection,$name,$whichBlock);
	}
	
	
	
	// search block from entire stack collection given its name
	private function searchStackCollection($name,$positionToOmit,$whichBlock)
	{
		$this->stackCollection->setIterator();
		$lookupItem = null;
		foreach($this->stackCollection->getIterator() as $blockCollection){
			
			if($this->stackCollection->getIterator()->key()!=$positionToOmit){ // already look into this position
			
				$lookupItem =  $this->searchBlockByName($blockCollection,$name,$whichBlock);
				if(!is_null($lookupItem)){
					return $lookupItem;
				}
			}
		}
	}
	
	
	
	//search block by name, given block collection
	private function searchBlockByName($blockCollection,$name,$whichBlock)
	{
		$blockCollection->setIterator();
		foreach ($blockCollection->getIterator() as $block) {
			
			if ($block->get_name() == $name) {
				
				//move a onto b
				if($this->command->get_firstPart()=='move' && $this->command->get_secondPart() =='onto'){
					
					switch($whichBlock){
						
						case "firstBlock":
							//remove block from block collection
							$blockCollection->getIterator()->remove();
							//verify if there are other blocks on top of firstBlock, reinitialise their positions
							$this->reinitialiseBlockPosition($blockCollection);
							$blockCollection->reindexBlock();
							return $block;
							break;
						
						case "secondBlock":
							//verify if there are other blocks on top of firstBlock, reinitialise their positions
							$this->reinitialiseBlockPosition($blockCollection);
							$blockCollection->reindexBlock();
							return $blockCollection;
							break;
					}
					
				}
				
				//move a over b
				if($this->command->get_firstPart()=='move' && $this->command->get_secondPart() =='over'){
					
					switch($whichBlock){
						
						case "firstBlock":
							//remove block from block collection
							$blockCollection->getIterator()->remove();
							//verify if there are other blocks on top of firstBlock, reinitialise their positions
							$this->reinitialiseBlockPosition($blockCollection);
							$blockCollection->reindexBlock();
							return $block;
							break;
						
						case "secondBlock":
							
							return $blockCollection;
							break;
					}
					
				}
				
				//pile a onto b
				if($this->command->get_firstPart()=='pile' && $this->command->get_secondPart() =='onto'){
					
					switch($whichBlock){
						
						case "firstBlock":
							$newBlockCollection = new BlockCollection();
							$newBlockCollection->addBlock($block);
							$blockCollection->getIterator()->remove();
							$this->getStackOfBlock($newBlockCollection,$blockCollection);
							$newBlockCollection->reindexBlock();
							return $newBlockCollection;
							break;
						
						case "secondBlock":
							//verify if there are other blocks on top of firstBlock, reinitialise their positions
							$this->reinitialiseBlockPosition($blockCollection);
							$blockCollection->reindexBlock();
							return $blockCollection;
							break;
					}
				}
				
				//pile a over b
				if($this->command->get_firstPart()=='pile' && $this->command->get_secondPart() =='over'){
					
					switch($whichBlock){
						
						case "firstBlock":
							$newBlockCollection = new BlockCollection();
							$newBlockCollection->addBlock($block);
							$blockCollection->getIterator()->remove();
							$this->getStackOfBlock($newBlockCollection,$blockCollection);
							$newBlockCollection->reindexBlock();
							return $newBlockCollection;
							break;
						
						case "secondBlock":
							
							return $blockCollection;
							break;
					}
					
				}
			}
		}
		return null;
	}
	
	//Get all blocks found on top of a block
	private function getStackOfBlock(&$newBlockCollection, $blockCollection)
	{
		$blockCollection->getIterator()->next();
		if($blockCollection->getIterator()->valid()) {
			
			$block = $blockCollection->getIterator()->current();
			$newBlockCollection->addBlock($block);
			$blockCollection->getIterator()->remove();
			$this->getStackOfBlock($newBlockCollection,$blockCollection);
		}
	}
	
	/**
	 * add block back to initial position in the stack
	 * @param $blockCollection
	 */
	private function reinitialiseBlockPosition($blockCollection)
	{
		if($blockCollection->getIterator()->next() && $blockCollection->getIterator()->valid()){
			
			$block =  $blockCollection->getIterator()->current();
			
			//return block to its initial position in the stack collection
			$this->stackCollection->getIterator()->set_position($block->get_initialPosition());
			$initialBlockCollection = $this->stackCollection->getIterator()->current();
			$block->set_actualPosition($block->get_initialPosition());
			$initialBlockCollection->addBlock($block);
			$initialBlockCollection->reindexBlock();
			$blockCollection->getIterator()->remove();
			
			//do same for next block in the stack
			$this->reinitialiseBlockPosition($blockCollection);
		}
	}
	
	/**
	 * print final result on screen
	 */
	public function printResult()
	{
		$this->stackCollection->setIterator();
		
		foreach($this->stackCollection->getIterator() as $blockCollection){
			
			$blockCollection->setIterator();
			$stackText = '';
			$blockCollection->reindexBlock();
			foreach($blockCollection->getIterator() as $block){
				$stackText .= $block->get_name().' ';
				
			}
			echo ($this->stackCollection->getIterator()->key()+1) .": ". $stackText . PHP_EOL;
		}
	}
	

}