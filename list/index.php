<?php
require_once("config.php");
require_once(SPYC);

$now=time();
$now = array(
			'date'=>strftime("%m/%d/%g",$now),
			'time'=>strftime("%H:%M",$now)
);

function buildPage(){
	global $logger;
	$formInput = "formInput.yaml";
	$form = new Form("index.php", $formInput);
	echo $form->toString();
	$logger->log(0,"index.php::buildPage()", "presenting form defined in {$formInput}");

}

echo "<html><head/><body>";

buildPage();


//NEXT STEPS...
//	instantiate ListItem from POST array, write it out to file, after checking first to know whether it already exists
//		check length of file for too much length.
 


echo "<body/></html>";