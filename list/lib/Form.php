<?php
require_once('config.php');

class Form{

	public $inputs = array();
	public $action;

	function __construct($action, $inputFile){
		//add another param, inputFile.yaml in order to abstract this that much further...same class can be used for other types of forms
		global $logger;
		$now=time();
		$now = array(
			'date'=>strftime("%m/%d/%g",$now),
			'time'=>strftime("%H:%M",$now)
		);
		$this->action = $action;
		$logger->log(0,"Form::__construct", "action set to ".$this->action);
		$this->inputs=R::instantiateFromYAML("Input", $inputFile);
		//		print_r($this->inputs);

	}


	public function toString(){
		global $logger;
		$form="";

		$form.="<form method=\"post\" action=\"{$this->action}\">";

		$form.="<ul>";

		foreach($this->inputs as $input){
//			$form.= "<li>";
			$form.="<input ";
			foreach($input as $property=>$value){
			$form.= !empty($value)  ? $property."=\"".$value."\" " :"";
			$form.="onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\"";
		}
			$form.="/><br/>";
//			$form.= "</li>";
		}

		$form.="</form>";

		$logger->log(0,"Form::toString()", "leaving toString, action set to ".$this->action);

		return $form;
	}
}
