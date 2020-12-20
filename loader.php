<?php
require('FILES/compiler.php');
if($output->connection->status){
	$handler->handleRequest($_SERVER, $_POST, $_GET, $output);
}else{
	$loader->SystemError("No Connection!");
}
?>