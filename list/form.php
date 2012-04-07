<?php
require_once('config.php');

global $logger;


if(isset($_POST[''])){
	$logger->log(0,"form.php", "\$post is set proceeding to process request");
	$formInput = FORMS_PATH.DS."formInput.yaml";
	$form = new Form("index.php", $formInput, "shopping");

	$page.=$form->toString();
	echo $page;
	$logger->log(0,"index.php::buildPage()", "presenting form defined in {$formInput}");

}else{
	$logger->log(0,"form.php", "\$post is not set, redirecting to index.php");
	header("Location: index.php");
}

