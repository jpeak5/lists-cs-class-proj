<?php
require_once('config.php');

class SubmitHandler {


	public static function process($post){
		global $logger;
		
		//make sure the form has been submitted legally
		//store the formid as type for later use
		if(isset($post['formid'])&&isset($post['submit'])){
			$logger->log(0, "SubmitHandler::process()", "Processing new {$post['formid']} form...");
			
			$type = $post['formid'];
			unset($post['formid']);
			unset($post['submit']);
		}else die("Fatal error: formid or submit were not defined");
		
		//TODO:: there is  need for form-specific input handling/validation
		//ie make certain fields UPPER, or check that dates don't collide
		
		//some form validation/format manipulation
		//these are fields we want to ucfirst
		if(isset($post['store'])){
			$post['store'] = ucwords($post['store']);
			$logger->log(0,"SubmitHandler::process()", "setting 'item' to UPPER" );
		}if(isset($post['who'])){
			$post['who'] = ucwords($post['who']);
		}
		
		$result= call_user_func($type.'::save', $post);
		


	}

}
?>