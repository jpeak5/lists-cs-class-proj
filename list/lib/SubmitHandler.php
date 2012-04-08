<?php
require_once('config.php');

class SubmitHandler {

	public static function process($post){
		global $logger;
		if(isset($post['formid'])&&isset($post['submit'])){
			$logger->log(0, "SubmitHandler::process()", "Processing new {$post['formid']} form...");
			
			$type = $post['formid'];
			unset($post['formid']);
			unset($post['submit']);
		}
		
		//TODO:: there is  need for form-specific input handling/validation
		//ie make certain fields UPPER, or check that dates don't collide
		
		if(isset($post['store'])){
			$post['store'] = ucwords($post['store']);
			$logger->log(0,"SubmitHandler::process()", "setting 'item' to UPPER" );
		}if(isset($post['who'])){
			$post['who'] = ucwords($post['who']);
		}
		
		$currentYAML = Spyc::YAMLLoad("output".DS."output.yaml");
		
		if(!array_key_exists(YAML_ROOT, $currentYAML)){
			$currentYAML = array(YAML_ROOT=>array());
		}

		$currentYAML[YAML_ROOT][$type][] = $post;

		$newYAML = Spyc::YAMLDump($currentYAML, false, false);

		if($handle = fopen(OUTPUT_PATH.DS."output.yaml", "w")){
			fwrite($handle, $newYAML);
			fclose($handle);
			return true;
		}else{
			return false;
		}


	}

}
?>