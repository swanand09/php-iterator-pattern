<?php
namespace App\Classes;
use App\Classes\AbstractBlock;
use App\Classes\BlockCollection;

class Block extends AbstractBlock {

    public function set_initialPosition($initialPosition)
    {
    	
    	$this->initialPosition = $initialPosition;
    }
	public function get_initialPosition(){
  
		return $this->initialPosition;
	}
	
	public function set_name(int $name)
	{
  
		$this->name = $name;
	}
	public function get_name(): int
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