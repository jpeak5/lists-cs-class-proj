<?php

require_once('config.php');

if(isset($_GET['item'])){
	//then this is a shopping list deletion
	$listType = "shopping";
	$listKey = 'item';
	$needle=$_GET['item'];
}elseif(isset($_GET['todo'])){
	//then this is a todo list deletion
	$listType = "todo";
	$listKey = 'todo';
	$needle=$_GET['todo'];
}

	$items= Lists::getList($listType);

//	krumo($items);
	echo "looking for {$needle}";
	$items=(array_values($items));
//	krumo($items);

	for($i=0;$i<count($items);$i++){

		$test = $items[$i];
		if($test[$listKey]==$needle){
			unset($items[$i]);
			break;
		}
	}

	$currentYAML = Spyc::YAMLLoad("output".DS."output.yaml");
	echo "getting current YAML<br/>";
//	krumo($currentYAML);


	$currentYAML[YAML_ROOT][$listType] = $items;

//	krumo($currentYAML);
	$newYAML = Spyc::YAMLDump($currentYAML, false, false);

	if($handle = fopen(OUTPUT_PATH.DS."output.yaml", "w")){
		fwrite($handle, $newYAML);
		fclose($handle);

	}else{
		return false;
	}





header('Location: index.php');


