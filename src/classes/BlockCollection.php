<?php
namespace App\Classes;

use Iterator;
use App\Classes\Block;

class BlocksOrderIterator implements \Iterator {
	
	/**
	 * @var BlockCollection
	 */
	private $collection;
	
	/**
	 * @var int Stores the current traversal position.
	 */
	private $position = 0;
	
	/**
	 * @var bool This variable indicates the traversal direction.
	 */
	private $reverse = false;
	
	public function __construct($collection, $reverse = false)
	{
		$this->collection = $collection;
		$this->reverse = $reverse;
	}
	
	public function rewind()
	{
		$this->position = $this->reverse ?
			count($this->collection->getItems()) - 1 : 0;
	}
	
	public function current()
	{
		return $this->collection->getItems()[$this->position];
	}
	
	public function key()
	{
		return $this->position;
	}
	
	public function next()
	{
		$this->position = $this->position + ($this->reverse ? -1 : 1);
	}
	
	public function valid()
	{
		return isset($this->collection->getItems()[$this->position]);
	}
}

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