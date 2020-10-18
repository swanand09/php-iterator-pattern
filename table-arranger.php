<?php
use App\Classes\Block;
// Enter number of blocks
 
//verify integer value 
// verify maximum of blocks allowed to set

// output table
// position and block number

// Enter your command  

function generateBlocks($num) {
    for ($i = 1; $i <= $num; $i++) {
        $block = new Block();
        $block->set_name($i);        
        yield $block;
    }
}

$blocks = generateBlocks();
foreach ($blocks as $block) {
    echo "$block()->get_name()";
    echo " : ";
    echo "$block()->get_position()";
    // print stack list
    echo PHP_EOL;

}
