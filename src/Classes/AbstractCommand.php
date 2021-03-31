<?php
namespace App\Classes;

abstract class AbstractCommand
{
    protected $firstPart;
    protected $secondPart;
    protected $firstBlock;
    protected $secondBlock;
    protected $fistPartValues = ['move','pile'];
    protected $secondPartValues = ['over','onto'];
    protected $exitCommand = 'quit';
}
