<?php
/**
 *dbObject class is a class from which database-based objects derive 
 */
require_once('config.php');
Class  dbObject{
        
        /**
         *
         * @var int
         */
	
        protected static $errors;

	//common database class vars
	public static 	$table_name;
	protected static 	$db_fields = array();






	//COMMON DATABASE METHODS
	protected static function attributes(){
                global $logger;
                $logger->log(0,get_called_class()."::attributes()", "got here!");
		$attributes = array();
		foreach(static::$db_fields as $field){
                    $logger->log(0,get_called_class()."::attributes()", "foreach db_fields...field = {$field}");
			if(property_exists(get_called_class(), $field)){
                            $logger->log(0,get_called_class()."::attributes()", "assigning value ".$attributes[$field]." to field  {$field}");
				$attributes[$field] = $field;
			}
		}

		return $attributes;
	}

	protected static function sanitized_attributes(){
		global $database;
		$clean_attributes = array();
		//doen't alter actual attribute value
		foreach($this->attributes() as $key => $value){
			$clean_attributes[$key] = $database->escape_value($value);
		}
		return $clean_attributes;
	}




	protected static function create(){
		global $database;
		global $logger;
		$attributes = $this->sanitized_attributes();

		$sql = "INSERT INTO `".static::$table_name."` (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		// 		echo $sql."<hr />";
		if($database->executeQuery($sql)){

			$logger->log(0,"dbObject", "new dbObject created- ".$this->filename." Name: ".$this->filename." vid: ".$this->vid);
			return true;            
		}else{
			$logger->log(20,"VIDEO", "database INSERT operation failed");
			return false;
		}
	}

	protected static function updateDiff(){
		if($this==Video::findByVID($this->vid)){
			//this is a no modification update
			return false;
		}else{
			return true;
		}
	}

	protected static function update(){
		global $database;
		global $logger;
		if(!$this->updateDiff()){
			$logger->log(0,"VIDEO", "UPDATE(".$this->vid.") no change in current record, aborting update proc and returning TRUE");
			return true;
		}
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value){
			$attribute_pairs[] = "{$key} ='{$value}'";

		}


		$sql = "UPDATE `".static::$table_name."` SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE `vid` = ".$database->escape_value($this->vid);
			
		//echo $sql."<hr />";
		$database->executeQuery($sql);
			
		if($database->affected_rows()==1){
			$logger->log(0,"VIDEO", "successful update for vid= ".$this->vid);
			return true;
		}else{
			$logger->log(15,"VIDEO", "failed to update vid= ".$this->vid);
			return false;
		}
	}

	protected static function delete(){
		global $database;
		global $logger;
		$sql = "DELETE FROM `".static::$table_name."` WHERE";
		$sql .= " `vid` = ".$database->escape_value($this->vid). " LIMIT 1";
		//echo $sql."<hr />";
		$database->executeQuery($sql);
			
		if($database->affected_rows()==1){
			$logger->log(0,"VIDEO", "DELETE(".$this->vid.") query = ".$sql);
			return true;
		}else{
			return false;
		}
	}

	public static function findByID($vid){
		global $logger;
                $logger->log(0, get_called_class()."::findByID({$vid})", "beginning routine");
                
		$query = "SELECT * FROM `".static::$table_name."` WHERE id = '{$vid}'";
                $logger->log(0, get_called_class()."::findByID({$vid})", "Query: {$query}");
                
		$result_array = static::findBySQL($query);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	protected static function findAll(){
		
		$query = "SELECT * FROM `".static::$table_name."`";
		$result = static::findBySQL($query);
		return $result;
	}


	protected static function instantiate($record){
		global $logger;
		$object = new static;
                $i=0;
		foreach($record as $attribute=>$value){
                    $logger->log(0, get_called_class()."::instantiate()", "instantiating object {$i}");
			if(property_exists($object,$attribute)){
                            $logger->log(0, get_called_class()."::instantiate()", "calling has_attribute({$attribute})");
				$object->$attribute = $value;
                                $logger->log(0, get_called_class()."::instantiate()", "assigning \$object->attribute ".$attribute." \$value {$value}");
                                $i++;
			}
		}
		return $object;
	}

//	protected static function has_attribute($attribute){
//            global $logger;
//		$object_vars = static::attributes();
//                $logger->log(0, get_called_class()."::has_attribute()", "checking for attribute {$attribute}");
//		return array_key_exists($attribute, $object_vars);
//	}


	protected static function findBySQL($sql=""){
		global $database;
                global $logger;
                $logger->log(0, get_called_class()."::findBySQL(\"{$sql}\")", "preparing to execute query");
                $logger->log(0, get_called_class()."::findBySQL(\"{$sql}\")", "Database = ".DB_SERVER);
		$result=$database->executeQuery($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result)){
                    $logger->log(0, get_called_class()."::findBySQL(\"{$sql}\")", "instantiating object");
			$object_array[] = static::instantiate($row);
		}
		return $object_array;
	}



}//end class
?>