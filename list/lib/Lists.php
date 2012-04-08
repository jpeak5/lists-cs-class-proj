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

		echo "from Lists.php\n";
		krumo($shopping_entries);
		echo "<hr/>";
		$i=0;
		foreach($shopping_entries as $entry){
			$storeName = $entry["store"];
			echo "\$storeName = {$storeName}\n";
			
			if(empty($stores[$storeName])){
				$stores[$storeName]=array();
				echo "\$stores-loop[$i]\n";
				krumo($stores);
				$i++;
			}
				$stores[$storeName][]=$entry;


		}
		echo "\$stores\n";
		krumo($stores);
		echo "<hr/>";
		return $stores;
	}

}