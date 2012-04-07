<?php
require_once('config.php');
require_once(SPYC);

global $logger;

print_r($_POST);
if(isset($_POST['form'])){
	$logger->log(0,"form.php", "\$post is set proceeding to process request");
	
	
	if($_POST['form']=="shopping"){
	$form = new Form("index.php", FORMS_PATH.DS."formInput.yaml", "shopping");
	}elseif($_POST['form']=="todo"){
		$form = new Form("index.php", FORMS_PATH.DS."todoInputs.yaml", "todo");
	}

	$page=$form->toString();
	echo $page;
	$logger->log(0,"index.php::buildPage()", "presenting form defined in {$formInput}");

}else{
	$logger->log(0,"form.php", "\$post is not set, redirecting to index.php");
	header("Location: index.php");
}

