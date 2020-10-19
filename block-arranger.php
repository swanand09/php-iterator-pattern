<?php
use App\Classes\Block;
use App\Classes\BlockCollection;
 
//verify integer value 
// verify maximum of blocks allowed to set

// output table
// position and block number

// Enter your command  




// Enter number of blocks
printText("Enter number of blocks: ");

handleUserInput();

function printText($text){
	
	echo $text;
	echo PHP_EOL;
}

function handleUserInput($command=false){
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    $num=0;
    $commandText = '';
    if($command) {
	    $num = (int)trim($line);
    }else{
	    $commandText = trim($line)
    }
    
    if(!empty($commandText)){
        //validate command
	    // execute command
    }else {
	
	    if ($num > 0) {
		    printText("You have $num blocks");
		    generateBlocks($num);
		    printText("Please place a command");
		    handleUserInput(true);
	    } else {
		    printText("Wrong value! Please input a number greater than 0!");
		    handleUserInput();
	    }
    }
}

function generateBlocks($num) {
	$blockCollection = new BlockCollection();
	for($i=1;$i<=$num;$i++){
		$block = new Block();
		$block->set_name($i);
		$block->set_initialPosition($i);
		$block->set_actualPosition($i);
		$blockCollection->addBlock($block);
	}
}