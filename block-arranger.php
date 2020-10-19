<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "vendor/autoload.php";
use App\Classes\Block;
use App\Classes\BlockCollection;

function printText($text){
	
	echo $text;
	echo PHP_EOL;
}


// Enter number of blocks
printText("Enter number of blocks: ");

handleUserInput();


function handleUserInput($command=false){
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    $num=0;
    $commandText = '';
    if(!$command) {
	    $num = (int)trim($line);
    }else{
	    $commandText = trim($line);
    }
    
    if(!empty($commandText)){
        //validate command
	    // execute command
    }else {
	
	    if ($num > 0) {
		    printText("You have $num blocks");
		    $collection =  generateBlocks($num);
		    
		    try {
			    foreach ($collection->getIterator() as $item) {
				    printText($item->get_name());
			    }
		    }catch (Exception $e){
		    	printText($e->getMessage());
		    	exit;
		    }
		    
		    
		    // printText("Please place a command");
		   // handleUserInput(true);
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
	return $blockCollection;
}