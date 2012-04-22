<?php

require_once('config.php');

//at the moment, we are doing this via GET and URL params,,, note that this could be alot nicer if it were ajax-fied and submitted via a post request
//the object itself could be serialized in to the POST array for cleaner code on both ends
$result = false;

if(isset($_GET['ShoppingList'])){
	//then this is a shopping list deletion
	$result = ShoppingList::delete($_GET['ShoppingList']);
}elseif(isset($_GET['TodoList'])){
	//then this is a todo list deletion
	$result = TodoList::delete($_GET['TodoList']);
}


if($result){
	header('Location: index.php');
}

?>
