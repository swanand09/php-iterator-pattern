<?php
use App\Classes\Block;

 
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


// Enter number of blocks
echo "Enter number of blocks: ";

handleUserInput();

function handleUserInput(){
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    $num = (int)trim($line);        
    
    if($num > 0){
        echo "$num blocks";
        echo PHP_EOL;
        exit;
    }else{
        echo "Wrong value! Please input a number greater than 0!";
        echo PHP_EOL;
        handleUserInput();
    }
}
/*
$blocks = generateBlocks($num);
foreach ($blocks as $block) {
    echo "$block()->get_name()";
    echo " : ";
    echo "$block()->get_position()";
    // print stack list
    echo PHP_EOL;

}
*/