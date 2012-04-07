<?php
require_once('config.php');

class Form{

	public $inputs = array();
	public $action;
	public $now = array();

	function __construct($action, $inputFile){
		//add another param, inputFile.yaml in order to abstract this that much further...same class can be used for other types of forms
		global $logger;
		$this->now=time();
		$this->now = array(
			'date'=>strftime("%m/%d/%g",$this->now),
			'time'=>strftime("%H:%M",$this->now)
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
			$isDatetime = null;
			foreach($input as $property=>$value){
				if($property=='type'&& ($value == 'date'||$value=='time')){
					$isDatetime = $value;
				}
				//handle cases where the input field is a datetime field
				$logger->log(0,"Form::toString()", "property = {$property}, value =".$value);
				if($property == 'placeholder' && ((array_key_exists('type', $input)) && ($input->type=="date" || $input->type=="time"||$input->type=="hidden"))){
					if($input->type=="date"){
						$value = $this->now['date'];
					}elseif($input->type=="time"){
						$value = $this->now['time'];
					}else{
						if($value == 'date'){
							$value = $this->now['date'];
						}else{
							$value = $this->now['time'];
						}
					}
					$logger->log(0,"Form::toString()", "setting attribute {$property} to ".$value);
				}
					
				$form.= !empty($value)  ? $property."=\"".$value."\" " :"";
				//			$form.="onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\"";
			}
			$form.="/><br/>";
			//			$form.= "</li>";

		}

		$form.="</form>";

		$logger->log(0,"Form::toString()", "leaving toString, action set to ".$this->action);

		return $form;
	}
}
