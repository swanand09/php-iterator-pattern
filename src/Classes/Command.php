<?php
namespace App\Classes;

use App\Classes\AbstractCommand;

class Command extends AbstractCommand{
 
	
	public function get_firstPartValues()
	{
		return $this->fistPartValues;
	}
	
	public function get_secondPartValues()
	{
		return $this->secondPartValues;
	}
	
	public function get_exitCommand()
	{
	
	}
	
	
	
	public function set_firstPart($firstPart)
	{
		$this->firstPart = $firstPart;
	}
    public function get_firstPart()
    {
    	return $this->firstPart;
    }
	
	public function set_secondPart($secondPart)
	{
		$this->secondPart = $secondPart;
	}
	public function get_secondPart()
	{
		return $this->secondPart;
	}
	
	public function set_firstBlock($firstBlock)
	{
		$this->firstBlock = $firstBlock;
	}
	public function get_firstBlock()
	{
		return $this->firstBlock;
	}
	
	public function set_secondBlock($secondBlock)
	{
		$this->secondBlock = $secondBlock;
	}
	public function get_secondBlock()
	{
		return $this->secondBlock;
	}
	
}