<?php
namespace App\Classes;

use Iterator;
use App\Classes\Block;
use App\Classes\StacksOrderIterator;

//A collection of blockCollection
class StackCollection implements \IteratorAggregate{

    const maxStacks  = 25;

    private $numBlocks;

    private $listStacks= [];
    
    private $stackOrderIterator;
	
	public function set_numBlocks($num)
	{
		
		$this->numBlocks = $num;
	}
	public function get_numBlocks()
	{
		
		return $this->numBlocks;
	}
    
	public function getStacks()
	{
		return $this->listStacks;
	}
	
	public function addStack(BlockCollection $blockCollection)
	{
		$this->listStacks[] = $blockCollection;
	}
	
	
	public function setIterator()
	{
		$this->stackOrderIterator = new StacksOrderIterator($this);
	}
	
	public function getIterator(): Iterator
	{
		return $this->stackOrderIterator;
	}
	
	public function getReverseIterator(): Iterator
	{
		return new StacksOrderIterator($this, true);
	}
}