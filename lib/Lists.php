<?php
require_once("config.php");
require_once(SPYC);

class Lists {

	public static function getYAML(){
		$data = SPYC::YAMLLoad(YAML);

		//if the file is empty, initialize it with the root element
		if(!array_key_exists(YAML_ROOT, $data)){
			$data = array(YAML_ROOT=>array());
			self::saveYAML($data);
		}
		return $data;
	}

	public static function getLists(){
		$data = Lists::getYAML();

		return $data[YAML_ROOT];

	}

	public static function getList($string){
		$lists = Lists::getLists();
		if(empty($lists)){
			echo "list is empty";
			$lists[] = $string;
		}


		elseif(array_key_exists($string, $lists)){
			$list=call_user_func($string.'::instantiate',$lists[$string]);
			return $list;
		}else{
			return false;
		}
	}


	public static function saveYAML($data){

		//convert the newly appended data to YAML and store in a var for writing
		$data = Spyc::YAMLDump($data, false, false);
		//write out the file
		if($handle = fopen(OUTPUT_PATH.DS."output.yaml", "w")){
			fwrite($handle, $data);
			fclose($handle);
			return true;
		}else{
			return false;
		}
	}



	public static function parseGroceryList($shopping_entries){
		$stores=array();
		if(!empty($shopping_entries)){
			foreach($shopping_entries as $entry){
				$storeName = $entry->store;

				if(empty($stores[$storeName])){
					$stores[$storeName]=array();
				}
				$stores[$storeName][]=$entry;


			}

			return $stores;
		}
		else return false;
	}

	public static function parseTodoList($todo_entries){
		$doers=array();

		if(!empty($todo_entries)){
			foreach($todo_entries as $entry){
				$doerName = $entry->who;

				if(empty($doers[$doerName])){
					$doers[$doerName]=array();
				}
				$doers[$doerName][]=$entry;
			}

			return $doers;
		}else return false;
	}


	public static function getItem(){

	}


}