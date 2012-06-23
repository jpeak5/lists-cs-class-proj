<?php
require_once('config.php');
require_once(SPYC);

global $logger;

print_r($_POST);
if(isset($_POST['form'])){
	$logger->log(0,"form.php", "\$post is set proceeding to process request");
	
	
	if($_POST['form']=="ShoppingList"){
	$form = new Form("index.php", FORMS_PATH.DS."todoInputs.yaml", "TodoList");
	}elseif($_POST['form']=="TodoList"){
		$form = new Form("index.php", FORMS_PATH.DS."formInput.yaml", "ShoppingList");
	}

	$page=$form->toString();
	echo $page;
	$logger->log(0,"form.php", "presenting form defined in {$formInput}");

}elseif(isset($_POST['ShoppingList']) || isset($_POST['TodoList'])){
	//then we'll edit the id passed as its value
	
}else{
	$logger->log(0,"form.php", "\$post is not set, redirecting to index.php");
	header("Location: index.php");
}
