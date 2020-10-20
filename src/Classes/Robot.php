<?php

namespace App\Classes;

use App\Classes\Command;
use App\Classes\BlockCollection;

class Robot {

    private $command;
    private $message;
    
    private $blockCollection;

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
	
    public function get_blockCollection()
    {
    	
    	return $this->blockCollection;
    }
    
	/**
	 * @param $num
	 *
	 */
	public function generateBlockCollection($num)
	{
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
		        $this->message = "The second block cannot be greater than the total number of blocks $this->blockCollection->get_numBlocks(). Please try again!";
	        }
        }else{
	        $this->message = "The first block cannot be greater than the total number of blocks $this->blockCollection->get_numBlocks(). Please try again!";
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
		    $this->blockCollection->setIterator();
		    $this->blockCollection->getIterator()->set_position((int)$this->command->get_firstBlock());
		   
		    $firstBlock = $this->blockCollection->getIterator()->current();
		
		    //check if first block has stack
		    // if yes set each block to its initial position
		    $this->emptyStackBlock($firstBlock);
			
		
		    //lookup secondBlock from collection
		    $this->blockCollection->getIterator()->set_position((int)$this->command->get_secondBlock());
		    $secondBlock = $this->blockCollection->getIterator()->current();
		
		    //check if second block has stack
		    // if yes set each block to its initial position
		    $this->emptyStackBlock($secondBlock);
		    
		    //add firstBlock as stack of secondBlock;
		    $secondBlock->get_stack()->addBlock($firstBlock);
		    
		    //set actual position of first block to the initial position of second block;
		    $firstBlock->set_actualPosition($secondBlock->get_initialPosition());
		    
		    
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
	 * empty stack of a particular block
	 * @param Block $block
	 */
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

}