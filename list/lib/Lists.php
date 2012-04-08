<?php
require_once("config.php");
require_once(SPYC);

class Lists {

	public static function getList($string){
		$data = SPYC::YAMLLoad(YAML);
		if(array_key_exists($string, $data[YAML_ROOT])){
			$list=$data[YAML_ROOT][$string];
			return $list;
		}
		return false;
	}


	public static function parseGroceryList($shopping_entries){
		$stores=array();

		foreach($shopping_entries as $entry){
			$storeName = $entry["store"];
			
			if(empty($stores[$storeName])){
				$stores[$storeName]=array();
			}
				$stores[$storeName][]=$entry;


		}

		return $stores;
	}
	
	public static function parseTodoList($todo_entries){
		$doers=array();


		foreach($todo_entries as $entry){
			$doerName = $entry["who"];
		
			if(empty($doers[$doerName])){
				$doers[$doerName]=array();
			}
				$doers[$doerName][]=$entry;
		}

		return $doers;
	}

}