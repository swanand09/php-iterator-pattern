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
		$this->stackCollection->set_numBlocks($num);
		
	}
	
	public function validateCommand($commandText)
	{
		if($this->command->get_exitCommand()!=$commandText) {
			
			$textSplit = explode(" ", $commandText);
			if (sizeof($textSplit) == 4) {
		
				return $this->handleCommand($textSplit);
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
        
        if($firstBlock <= $this->stackCollection->get_numBlocks()) {
	
	        if($secondBlock <= $this->stackCollection->get_numBlocks()) {
		
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
							        $this->message = "Second block should be a number. Please try again!";
						        }
						
					        } else {
						
						        $this->message = "Third text of the command should be 'onto' or 'over'. Please try again!";
					        }
					
				        } else {
					        $this->message = "First block should be a number. Please try again!";
				        }
				
			        } else {
				        $this->message = "First text of the command should be 'move' or 'pile'. Please try again!";
			        }
		        } else {
			        $this->message = "Pile or move same block is not allowed. Please try again!";
		        }
	        }else{
		        $this->message = "The second block cannot be greater than the total number of blocks $this->stackCollection->get_numBlocks(). Please try again!";
	        }
        }else{
	        $this->message = "The first block cannot be greater than the total number of blocks $this->stackCollection->get_numBlocks(). Please try again!";
        }
        
        return false;
    }
  	
	/**
	 * interpret command in parts
	 */
    public function executeCommand()
    {

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
    
    private function moveBlockOnto()
    {
     
    	//$firstBlock = new Block();
    	//$secondBlock = new Block();
    	
	    try {
		    
	    	//lookup firstBlock from collection
		    
		    //attempt to check if the block based on its name or initial position is on same stack as initially set
		    $blockPosition = ((int)$this->command->get_firstBlock()-1);
		    $blockName = (int)$this->command->get_firstBlock();
		    
		    //Quick Lookup
		    $firstBlockDetached = $this->searchStackByPosition($blockName,$blockPosition);
		    
		    if(is_null($firstBlockDetached)){
		     
		    	//search entire stack collection
			    $firstBlockDetached = $this->searchStackCollection($blockName,$blockPosition);
		    }
		    
		    
		    
		    
		    
		
		    //$firstBlock->set_actualPosition()
			   
		    
		    /*
		    //check if first block has stack
		    // if yes set each block to its initial position
		    $this->emptyStackBlock($firstBlock);
			
		
		    //lookup secondBlock from collection
		    $this->stackCollection->getIterator()->set_position((int)$this->command->get_secondBlock());
		    $secondBlock = $this->stackCollection->getIterator()->current();
		
		    //check if second block has stack
		    // if yes set each block to its initial position
		    $this->emptyStackBlock($secondBlock);
		    
		    //add firstBlock as stack of secondBlock;
		    $secondBlock->get_stack()->addBlock($firstBlock);
		    
		    //set actual position of first block to the initial position of second block;
		    $firstBlock->set_actualPosition($secondBlock->get_initialPosition());
		    */
		    
	    }catch (\Exception $e){
	    	
		    $this->message = "Got an internal problem({$e->getMessage()}). Please contact my creator!";
	    }
	    
	    
	    
    }
    
    private function moveBlockOver()
    {
    
    	echo 'moveBlockOver'.PHP_EOL;
    }
    
    private function pileBlockStackOnto()
    {
    
        echo 'pileBlockStackOnto'.PHP_EOL;
    }
	
	private function pileBlockStackOver()
	{
	
		echo 'pileBlockStackOver'.PHP_EOL;
	}
	
	
	/**
	 * search stack for block at given position
	 * @param $name
	 * @param $position
	 * @return mixed|null
	 */
	private function searchStackByPosition($name,$position)
	{
		$this->stackCollection->setIterator();
		$this->stackCollection->getIterator()->set_position($position);
		$blockCollection = $this->stackCollection->getIterator()->current();
		return $this->searchBlockByName($blockCollection,$name);
	}
	
	
	/**
	 * search block from entire stack collection given its name
	 * @param $name
	 * @param $positionToOmit
	 * @return mixed|null
	 */
	private function searchStackCollection($name,$positionToOmit)
	{
		$this->stackCollection->setIterator();
		foreach($this->stackCollection->getIterator() as $blockCollection){
			
			if($this->stackCollection->getIterator()->key()!=$positionToOmit){ // already look into this position
				
				return $this->searchBlockByName($blockCollection,$name);
			}
		}
	}
	
	
	/**
	 * search block by name, given block collection
	 * @param $blockCollection
	 * @param $name
	 * @return mixed|null
	 */
	private function searchBlockByName($blockCollection,$name)
	{
		$blockCollection->setIterator();
		foreach ($blockCollection->getIterator() as $block) {
			
			if ($block->get_name() == $name) {
				
				
				//remove block from block collection
				$blockCollection->getIterator()->remove();
				
				//verify if there are other blocks on top of firstBlock, reinitialise their positions
				$this->reinitialiseBlockPosition($blockCollection);
				return $block;
			}
		}
		return null;
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
			
			$blockCollection>getIterator()->remove();
			
			//do same for next block in the stack
			$this->reinitialiseBlockPosition($blockCollection);
		}
	}
	
	/**
	 * empty stack of a particular block
	 * @param Block $block
	 */
	/*
	private function emptyStackBlock(Block $block)
	{
		
		if($block->has_stack()){
			
			try {
				$block->get_stack()->setIterator();
				foreach ($block->get_stack()->getIterator() as $blockItem) {
					
					if ($blockItem->has_stack()) {
						
						return $this->emptyStackBlock($blockItem);
					} else {
						
						//set block position to initial
						$blockItem->set_actualPosition($blockItem->get_initialPosition());
						
						//pop block out of stack
						$block->get_stack()->getIterator()->remove();
						return;
					}
				}
			}catch(\Exception $e){
				
				$this->message="Error!";
			}
		}
	}
	*/

}