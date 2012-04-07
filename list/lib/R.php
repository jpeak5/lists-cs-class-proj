<?php
require_once("config.php");
class R {

	public static function instantiateFromYAML($class,$src){
		global $logger;
		
		$yaml = Spyc::YAMLLoad($src);
		$objects = array();
		
		foreach($yaml as $inputs){
			foreach($inputs as $input){
				$logger->log(0,"instantiateFromYAML","creating new instance of {$class}");

				//Instantiate the reflection object
				$reflect = new ReflectionClass($class);
				$in = $reflect->newInstance();

				//Now get all the properties from class A in to $properties array
				$properties = $reflect->getProperties();

				//Now go through the $properties array and populate each property
				foreach($properties as $property)
				{
					if(array_key_exists($property->getName(),$input)){

						$in->{$property->getName()}=$input[$property->getName()];

						$logger->log(0,"instantiateFromYAML","adding property - ".$property->getName().":   ".$input[$property->getName()]);
					}
				}
				$objects[]=$in;
			}
		}
//		print_r($objects);
		return $objects;
	}

}
?>