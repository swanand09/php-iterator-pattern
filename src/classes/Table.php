<?php
namespace App\Classes;
use App\Classes\AbstractTable;

class Table extends AbTable{

    const maxBlocks  = 25;

    private $numBlocks;

    private $listBlocks;

    public function __construct()
    {
        
    }
}