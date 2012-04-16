<?php
require_once('config.php');
//http://www.zacharyfox.com/blog/php/simple-model-crud-with-php-5-3

/**
 * Base class for all models
 *
 * @author Zachary Fox
 */
abstract class ListItem
{
	/**
	 * Pass properties to construct
	 *
	 * @param mixed[] $properties The object properties
	 *
	 * @throws Exception
	 */
	protected function __construct(Array $properties)
	{
		$reflect = new ReflectionObject($this);
		foreach ($reflect->getProperties() as $property) {
			//if (!array_key_exists($property->name, $properties)) {
			//throw new Exception("Unable to create object. Missing property: {$property->name}");
			//}

			$this->{$property->name} = $properties[$property->name];
		}
	}

	/**
	 * Get all class properties
	 *
	 * @return string[]
	 */
	protected static function getFields()
	{
		static $fields = array();
		$called_class  = get_called_class();

		if (!array_key_exists($called_class, $fields)) {
			$reflection_class = new ReflectionClass($called_class);

			$properties = array();

			foreach ($reflection_class->getProperties() as $property) {
				$properties[] = $property->name;
			}

			$fields[$called_class] = $properties;
		}

		return $fields[$called_class];
	}

	public static function instantiate($array){
		//echo "//echoing from instantiate?///???";
		////krumo($array);
		$listItems = array();
		if(!empty($array)){
			foreach($array as $object){
				$listItems[] = new static($object);
			}
			return $listItems;
		}else return false;
	}

	public static function delete($id){
		$yaml = Lists::getYAML();
		$haystack = $yaml[YAML_ROOT][get_called_class()];
		if(empty($haystack)){
			//echo "list is empty";
			return false;
		}
		for($i = 0; $i<count($haystack);$i++){

			//				////krumo($list[$i]);
			if($haystack[$i]['id'] == $id){
				unset($haystack[$i]);
				$yaml[YAML_ROOT][get_called_class()] = $haystack;
				//echo"about to save some new YAML<br/>";
				////krumo($yaml);
				Lists::saveYAML($yaml);
				return true;
			}
		}
		//echo ("item with id = {$id} not found in current ".get_called_class()." list<br/>");
		return false;
	}



	public static function save($array){
		

		if(!strlen($array['id'])>0){
			$array['id'] = sha1($array['item']);
		}

		$record = new static($array);
		//echo "check now for correct instantiation";
		////krumo($record);
		if(!self::itemExists($record->id)){
			//echo "we area going to create a new record";
			return static::create($record) ? true : false;
		}
		else{
			return static::update($record) ? true : false;
		}

	}

	public static function create($record){


		//echo "<br/>now entering the file->save portion of create()<br/>";
		$yaml = Lists::getYAML();
		$yaml[YAML_ROOT][get_called_class()][] = (array)$record;
		////krumo($yaml);
		Lists::saveYAML($yaml);
		//echo "about to return true from create()";
		return true;

	}

	public static function update($object){
		$yaml = Lists::getYAML();
		$list = $yaml[YAML_ROOT][get_called_class()];

		for($i = 0; $i<count($list);$i++){

			//krumo($list[$i]);
			//krumo($object);

			if($list[$i]['id'] == $object->id){

				$list[$i] = (array)$object;

				$yaml[YAML_ROOT][get_called_class()] = $list;
				//					////krumo($yaml);
				Lists::saveYAML($yaml);
				return true;
			}
		}
		//echo ("{$key} = {$value} not found in current ".get_called_class()." list");
		return false;
	}





	public static function itemExists($id){
		$items = self::getAll();
		if(empty($items)){
			//echo "returning false from itemExists() in ListItem";
			return false;
		}
		foreach($items as $item){
			if($item->id == $id){
				return true;
			}
		}return false;
	}

	public static function findById($id){
		$items = self::getAll();
		if(empty($items)){
			echo "returning false from itemExists() in ListItem";
			return false;
		}
		foreach($items as $item){
			if($item->id == $id){
				return $item;
			}
		}return false;
	}

	public static function getAll(){
		$list = Lists::getList(get_called_class());
		return !empty($list) ? $list : false;
	}

}