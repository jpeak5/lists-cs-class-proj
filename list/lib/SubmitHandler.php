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