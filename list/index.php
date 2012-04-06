<?php
require_once("config.php");



function buildPage(){
	global $logger;
	$form = new Form("index.php");
	echo $form->toString();
	$logger->log(0,"index.php::buildPage()", "have just echoed form");
		
}

echo "<html><head/><body>";

buildPage();

echo "<body/></html>";