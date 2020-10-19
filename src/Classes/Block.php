<?php
namespace App\Classes;
use App\Classes\AbstractBlock;

class Block extends AbstractBlock {

    private $actualPosition;
    private $initialPosition;
    private $name;
    
    private $stackCollection;
    
    //order in the current stack
    private $order;




    function __construct()
    {

    }
	
    public function set_stackCollection($stackCollection){
    	$this->stackCollection = $stackCollection;
    }
	public function get_stackCollection(){
		return $this->stackCollection;
	}
    
    
    public function set_initialPosition($initialPosition){
    	
    	$this->initialPosition = $initialPosition;
    }
	public function get_initialPosition($position){
  
		return $this->initialPosition;
	}
	
	public function set_name($name){
  
		$this->name = $name;
	}
	public function get_name(){
  
		return $this->name;
	}
	
	public function set_actualPosition($actualPosition){
		
		$this->actualPosition = $actualPosition;
	}
	public function get_actualPosition(){
		
		return $this->actualPosition;
	}
}