<?php
require_once("config.php");
require_once(SPYC);

global $logger;

if(isset($_POST['submit'])){
	SubmitHandler::process($_POST);
}


$now=time();
$now = array(
			'date'=>strftime("%m/%d/%g",$now),
			'time'=>strftime("%H:%M",$now)
);


$header = "<html><head>";
$header.="<script type=\"text/javascript\" src=\"lib/js".DS."util.js\"></script>";
$header.="<script src=\"http://code.jquery.com/jquery-latest.js\"></script>";
$header.="</head>";
$header.="<body>";
echo $header;


$page = "";
$page.="<button type=\"button\" onclick=\"toggleForm()\">Display Date</button>";

$formInput = FORMS_PATH.DS."formInput.yaml";
$form = new Form("index.php", $formInput, "shopping");

$page.=$form->toString();

$logger->log(0,"index.php::buildPage()", "presenting form defined in {$formInput}");

$data = "<textarea rows=\"20\" cols=\"40\">";
$data.= file_get_contents(YAML);
$data.= "</textarea>";

$page.=$data;
echo $page;





//NEXT STEPS...
//	instantiate ListItem from POST array, write it out to file, after checking first to know whether it already exists
//		check length of file for too much length.



$closure=  "<body/></html>";


echo $closure;