<?php
namespace App\Classes;

use Iterator;
use App\Classes\Block;
use App\Classes\BlocksOrderIterator;

class BlockCollection implements \IteratorAggregate{

    const maxBlocks  = 25;

    private $numBlocks;

    private $listBlocks= [];
    
    private $blockOrderIterator;
    
    public function set_numBlocks($num)
    {
    	
    	$this->numBlocks = $num;
    }
	public function get_numBlocks()
	{
    	
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

	public function unsetBlock($position)
	{
		unset($this->listBlocks[$position]);
	}
	public function reindexBlock()
	{
		$this->listBlocks = array_values($this->listBlocks);
	}
	
	public function setIterator()
	{
		$this->blockOrderIterator = new BlocksOrderIterator($this);
	}
	
	public function getIterator(): Iterator
	{
		return $this->blockOrderIterator;
	}
	
	public function getReverseIterator(): Iterator
	{
		return new BlocksOrderIterator($this, true);
	}
}