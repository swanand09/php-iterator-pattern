<?php
namespace App\Classes;

use Iterator;
use App\Classes\Block;
use App\Classes\BlocksOrderIterator;

class BlockCollection implements \IteratorAggregate{

    const maxBlocks  = 25;

    private $numBlocks;

    private $listBlocks= [];
    
    public function set_numBlocks($num){
    	
    	$this->numBlocks = $num;
    }
	public function get_numBlocks(){
    	
    	return $this->numBlocks;
	}
	
	public function getBlocks()
	{
		return $this->listBlocks;
	}
	
	public function addBlock(Block $block)
	{
		$this->listBlocks[] = $block;
	}
	
	public function getIterator(): Iterator
	{
		return new BlocksOrderIterator($this);
	}
	
	public function getReverseIterator(): Iterator
	{
		return new BlocksOrderIterator($this, true);
	}
}