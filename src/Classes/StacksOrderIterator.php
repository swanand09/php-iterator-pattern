<?php
namespace App\Classes;

use Iterator;
use App\Classes\StackCollection;

class StacksOrderIterator implements \Iterator
{

    /**
    * @var StackCollection
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
        count($this->collection->getStacks()) - 1 : 0;
    }
    
    public function current()
    {
        return $this->collection->getStacks()[$this->position];
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
        return isset($this->collection->getStacks()[$this->position]);
    }
    
    public function set_position($position)
    {
        $this->position = $position;
    }
}
