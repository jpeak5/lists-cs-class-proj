<?php
//require_once('config.php');

class Form{

	public $inputs = array();
	public $action;
	public $now = array();
	public $formid;

	/*
	 * $action will be the target for the form and its processing
	 * $inputFile contains the fields that should make up the form
	 * $id is a somewhat arbitrary string formid attr of the form element
	 */
	function __construct($action, $inputFile, $id){
		//add another param, inputFile.yaml in order to abstract this that much further...same class can be used for other types of forms
		global $logger;
		$this->now=time();
		$this->now = array(
			'date'=>strftime("%m/%d/%g",$this->now),
			'time'=>strftime("%H:%M",$this->now)
		);

		$this->action = $action;
		$this->formid = $id;
		$logger->log(0,"Form::__construct", "action set to ".$this->action);
		$this->inputs=R::instantiateFromYAML("Input", $inputFile);

		//krumo($this->inputs);

		foreach($this->inputs as $input){



			//handle cases where the input field is a datetime field
			//				$logger->log(0,"Form::toString()", "property = {$property}, value =".$value);
			if(($input->type=="date" || $input->type=="time"||$input->type=="datetime")){
				//krumo($input);
				if($input->type=="date"){
					$input->value = $this->now['date'];
					$input->placeholder = $this->now['date'];
				}elseif($input->type=="time"){
					$input->value = $this->now['time'];
				}elseif($input->type=="datetime"){
					$input->value = $this->now['date']." @ ".$this->now['time'];
					$input->placeholder = $this->now['date']." @ ".$this->now['time'];
				}

			}//end handle date-time cases


		}
		//krumo($this->inputs);
	}


	/*
	 * $action will be the target for the form and its processing
	 * $inputFile contains the fields that should make up the form
	 * $id is a somewhat arbitrary string formid attr of the form element
	 * $object - the presence of this var indicates that we are going to edit some pre-existing object and so
	 * we need to preload the form fields with the existent values
	 */
	public static function editForm($action, $inputFile, $id, $object){
//		krumo($object);
		$form = new self($action, $inputFile, $id);
		foreach($object as $key => $value){
			foreach($form->inputs as $input){
				if($input->name == $key){
					$input->value = $value;
					$input->placeholder = $value;
				}
			}
		}
		return $form;
	}

	public function toString(){
		global $logger;
		$form="";

		$form.="<form method=\"post\" action=\"{$this->action}\" id=\"{$this->formid}\">";

		$form.="<ul>";
		$form.="<input type=\"hidden\" name=\"formid\" value=\"{$this->formid}\"/>";


		$i=0;
		foreach($this->inputs as $input){

			//let only 3 fields across before newline
			if($input->type=="submit"||$i%3==0){
				$form.="<br/>";
			}

			$form.="<input ";
			$isDatetime = null;
			foreach($input as $property=>$value){
				$form.= !empty($value)  ? $property."=\"".$value."\" " :"";
				//			$form.="onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\"";
				if($property == 'name' && $value == 'timestamp'){
					$form.=" class=\"timestamp\" ";
				}
			}
			$form.="/>";
			//			$form.= "</li>";
			$i++;
		}
		$form.="</form>";

		$logger->log(0,"Form::toString()", "leaving toString, action set to ".$this->action);

		return $form;
	}
}
