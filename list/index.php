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
$header.="<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheets/main.css\">";
$header.="</head>";
$header.="<body>";

$formInput = FORMS_PATH.DS."formInput.yaml";
$form = new Form("index.php", $formInput, "shopping");



$intro="<section id=\"intro\">";
$intro .="<button id=\"toggle\" class=\"shopping\" type=\"button\" >switch to TODOs</button>";

$intro.="<div id=\"mutableForm\">";
$intro.=$form->toString();
$intro.="</div>";

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
$script.="\$currentState.html(\"switch to TODOs\");";
$script.="}else{";
$script.="\$currentState.attr(\"class\", \"shopping\");";
$script.="\$currentState.html(\"switch to Shopping\");";
$script.="}";
					
$script.="});";
				
$script.="});";
$script.="</script>";

$intro.=$script;

$intro.="</section>";// id=\"intro\">";

//----------------------intro done

$logger->log(0,"index.php::buildPage()", "presenting form defined in {$formInput}");

$content = "<div id=\"content\">";
$content.="<div id=\"content_left\">";


$shoppingList = Lists::parseGroceryList(Lists::getList("shopping"));
//echo "\$shoppingList\n";
//krumo($shoppingList);
$list = "<div id=\"grocery_list\">";
$list.="<h3>Shopping</h3>";

foreach($shoppingList as $store=>$items){
//	echo "\$store";
//	krumo($store);
	$storeTotal = 0;
	$listHead="";
	$listHead.="<span class=\"heading\"><strong>".$store;
	$listBody = "<ul>";
	foreach($items as $item){
		$listBody.="<li>{$item["item"]}</li>";
		$storeTotal+=isset($item["price-estimate"]) ? $item["price-estimate"]: 0;
	}
	$listHead.="</strong><span class=\"aggregate\">&nbsp;&nbsp;(\$".$storeTotal.")</span></span>";
	$listBody.="</ul>";
	$list.=$listHead.$listBody;
} 
$list.="</div>";

$content.=$list."</div>";

$content.="<div id=\"content_right\">";

$todoList = Lists::parseTodoList(Lists::getList("todo"));
$list= "<div id=\"todo_list\">";
$list.="<h3>TODOs</h3>";

foreach($todoList as $doer=>$todos){
//	echo "\$store";
//	krumo($store);
	
	$list.="<span class=\"heading\"><strong>".$doer."</strong></span>";
	foreach($todos as $todo){
		$list.="<li>{$todo["todo"]}</li>";
	}
	$list.="</ul>";
} 
$list.="</div>";

$content.=$list."</div>"; 
$content.= "</div>";// id=\"content\">";

//NEXT STEPS...
//	instantiate ListItem from POST array, write it out to file, after checking first to know whether it already exists
//		check length of file for too much length.



$closure=  "<body/></html>";


echo $header.$intro.$content.$closure;