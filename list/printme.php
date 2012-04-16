<?php
require_once("config.php");
require_once(SPYC);

global $logger;


$header = "<html><head>";
$header.="<script src=\"http://code.jquery.com/jquery-latest.js\"></script>";
$header.="<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheets/main.css\">";
$header.="</head>";
$header.="<body>";

$intro="<section id=\"intro\">";


$intro.="<div id=\"mutableForm\">";

$intro.="</div>";

$intro.="</section>";// id=\"intro\">";

//----------------------intro done

$content = "<div id=\"content\">";
$content.="<div id=\"content_left\">";
$content.="<a href=\"index.php\">edit</a>";


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
		$listBody.="<li class=\"litem\"><strong>{$item["item"]}</strong>&nbsp;(\${$item["price-estimate"]})";
//		$listBody.="<div class=\"deleteme\">&nbsp;<a href=\"delete.php?item=".urlencode($item["item"])."\">delete</a></div></li>";
		$storeTotal+=isset($item["price-estimate"]) ? $item["price-estimate"]: 0;
		$listBody.=(strlen($item["description"])>0)?"&nbsp;-".$item["description"]:"";
		
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
	
	$doerTotal = 0;
	$listHead="";
	$listHead.="<span class=\"heading\"><strong>".$doer;
	$listBody="<ul>";
	foreach($todos as $todo){
		$listBody.="<li><strong>{$todo["todo"]}</strong> &nbsp;({$todo["duration-estimate"]})</li>";
//		$listBody.="<div class=\"deleteme\">&nbsp;<a href=\"delete.php?todo=".urlencode($todo["todo"])."\">delete</a></div></li>";
		$doerTotal+=isset($todo["duration-estimate"]) ? $todo["duration-estimate"]: 0;
		$listBody.=(strlen($todo["description"])>0)?"&nbsp;-".$todo["description"]:"";
	}
	$listHead.="</strong><span class=\"workAggregate\">&nbsp;&nbsp;(".$doerTotal.")</span></span>";
	$listBody.="</ul>";
	$list.=$listHead.$listBody;
} 
$list.="</div>";

$content.=$list."</div>"; 
$content.= "</div>";// id=\"content\">";

//NEXT STEPS...
//	instantiate ListItem from POST array, write it out to file, after checking first to know whether it already exists
//		check length of file for too much length.



$closure=  "<body/></html>";


echo $header.$intro.$content.$closure;