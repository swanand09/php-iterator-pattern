<?php
namespace App\Classes;
use App\Classes\AbstractBlock;
use App\Classes\BlockCollection;

class Block extends AbstractBlock {

    private $actualPosition;
    private $initialPosition;
    private $name;
    
    private $stack;
    
    //order in the current stack
    private $order;




    function __construct()
    {
		$this->stack = new BlockCollection();
    }
	
    public function set_stack(BlockCollection $stack)
    {
    	$this->stack = $stack;
    }
	public function get_stack()
	{
		return $this->stack;
	}
	
	public function has_stack()
	{
		//echo 'count: '.count($this->stack->getBlocks()).PHP_EOL;
    	return count($this->stack->getBlocks()) > 0;
	}
    
    
    public function set_initialPosition($initialPosition)
    {
    	
    	$this->initialPosition = $initialPosition;
    }
	public function get_initialPosition(){
  
		return $this->initialPosition;
	}
	
	public function set_name($name)
	{
  
		$this->name = $name;
	}
	public function get_name()
	{
  
		return $this->name;
	}
	
	public function set_actualPosition($actualPosition)
	{
		
		$this->actualPosition = $actualPosition;
	}
	public function get_actualPosition()
	{
		
		return $this->actualPosition;
	}
}