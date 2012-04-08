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
$header.="<script src=\"http://code.jquery.com/jquery-latest.js\"></script>";
$header.="</head>";
$header.="<body>";



$page = "";


$formInput = FORMS_PATH.DS."formInput.yaml";
$form = new Form("index.php", $formInput, "shopping");

$toggle ="<button id=\"toggle\" class=\"shopping\" type=\"button\" >TODOs</button>";


$page.=$toggle;
$page.="<div id=\"mutableForm\">";
$page.=$form->toString();
$page.="</div>";

$script = "<script>";
$script.="/* attach a submit handler to the form */";
$script.="$(\"#toggle\").click(function(event){";
$script.="console.log(\"beginning the script\");";
$script.="/* stop form from submitting normally */";
$script.="event.preventDefault();";
                
$script.="/* get some values from elements on the page: */";
$script.="var \$currentState = $(this),"; 
$script.="state = \$currentState.attr(\"class\"),"; 
$script.="url = \"form.php\";";
$script.="console.log(\"currentState= \"+\$currentState.attr(\"class\"));";
                
$script.="/* Send the data using post and put the results in a div */";
$script.="$.post(url, {";
$script.="form: state";
$script.="}, function(data){";
$script.="var content = $(data);";
$script.="$(\"#mutableForm\").empty().html(content);";
$script.="if(\$currentState.attr(\"class\")==\"shopping\"){";
$script.="\$currentState.attr(\"class\", \"todo\");";
$script.="\$currentState.html(\"TODOs\");";
$script.="}else{";
$script.="\$currentState.attr(\"class\", \"shopping\");";
$script.="\$currentState.html(\"Shopping\");";
$script.="}";
					
$script.="});";
				
$script.="});";
$script.="</script>";

$page.=$script;

$logger->log(0,"index.php::buildPage()", "presenting form defined in {$formInput}");

$data = "<textarea rows=\"20\" cols=\"40\">";
$data.= file_get_contents(YAML);
$data.= "</textarea>";


$shoppingList = Lists::parseGroceryList(Lists::getList("shopping"));
echo "\$shoppingList\n";
krumo($shoppingList);
$list = "<div id=\"list\">";
$i=0;
foreach($shoppingList as $key=>$store){
	echo "\$store";
	krumo($store);
	
	$list.="<h2>".$key."</h2>";
	foreach($store as $item){
		$list.="<li>{$item["item"]}</li>";
	}
} 

$page.=$list; 

$page.=$data;






//NEXT STEPS...
//	instantiate ListItem from POST array, write it out to file, after checking first to know whether it already exists
//		check length of file for too much length.



$closure=  "<body/></html>";


echo $header.$page.$closure;