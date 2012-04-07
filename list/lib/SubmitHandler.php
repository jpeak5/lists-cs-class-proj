<?php
require_once('config.php');

class SubmitHandler {

	public static function process($post){
		global $logger;
		if(isset($post['formid'])){
			$logger->log(0, "SubmitHandler::process()", "Processing new {$post['formid']} form...");
			
		}
		
		//get rid of the submit handler
		//this is actually not necessary, since the objects which we will be creating from this will just ignor the weird stuff...
		if(end($post)=="Submit Query"){
			$logger->log(0, "SubmitHandler::process()", "\$last item in \$post array is ".array_pop($post));
		}
		$fileContents = Spyc::YAMLLoad("output".DS."output.yaml");
		
		print_r($fileContents);
		
		$type = $post['formid'];
		unset($post['formid']);
		
		$output[$type]=$post;

		array_push($fileContents, $output);
		echo "<hr/>";
		print_r($fileContents);
		
		$fileContents = Spyc::YAMLDump($fileContents, false, false); 

		if($handle = fopen(OUTPUT_PATH.DS."output.yaml", "a+")){
			fwrite($handle, $fileContents);
			fclose($handle);
			return true;
		}else{
			return false;
		}


	}

}
?>