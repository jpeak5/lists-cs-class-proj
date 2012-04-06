<?php
require_once('config.php');

class Form{

	public $inputs = array();
	public $action;
	
	function __construct($action){
		global $logger;
		$now=time();
		$now = array(
			'date'=>strftime("%m/%d/%g",$now),
			'time'=>strftime("%H:%M",$now)
		);
		$this->action = $action;
		$logger->log(0,"Form::__construct", "action set to ".$this->action);
		$this->init($now);

	}

	private function init($now){
		$this->inputs=array(
		array(
				"type"=>"text",
				"name"=>"item",
				"value"=>"Item...",
				"maxlength"=>"16",
				"size"=>"16"
				),
				array(
				"type"=>"text",
				"name"=>"store",
				"value"=>"Store...",
				"maxlength"=>"16",
				"size"=>"16"
				),
				array(
				"type"=>"text",
				"name"=>"shopper",
				"value"=>"shopper",
				"maxlength"=>"16",
				"size"=>"16"
				),
				array(
				"type"=>"text",
				"name"=>"description",
				"value"=>"Description (optional)...",
				"maxlength"=>"16",
				"size"=>"16"
				),
				array(
				"type"=>"text",
				"name"=>"date-added",
				"value"=>$now["date"],
				"maxlength"=>"10",
				"size"=>"10"
				),
				array(
				"type"=>"text",
				"name"=>"time-added",
				"value"=>$now["time"],
				"maxlength"=>"10",
				"size"=>"10"
				),
				array(
				"type"=>"text",
				"name"=>"date-needed",
				"value"=>$now["date"],
				"maxlength"=>"10",
				"size"=>"10"
				),
				array(
				"type"=>"text",
				"name"=>"time-needed",
				"value"=>$now["time"],
				"maxlength"=>"10",
				"size"=>"10"
				),
				array(
				"type"=>"submit",
				"name"=>"submit",
				"value"=>"Submit",
				"maxlength"=>"nul",
				"size"=>"null"
				)
				);
//				echo print_r($this->inputs);
	}

	public function toString(){
		global $logger;
		$form="";

		$form.="<form method=\"post\" action=\"{$this->action}\">";

		$form.="<ul>";

		foreach($this->inputs as $item){

			$form.="<li>";

			$form.="<input type=\"{$item['type']}\" name=\"{$item['name']}\" value=\"{$item['value']}\" maxlength=\"{$item['maxlength']}\" size=\"{$item['size']}\" onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\">";

			$form.="</li>";
		}

		$form.="</form>";
		
		$logger->log(0,"Form::toString()", "leaving toString, action set to ".$this->action);
		
		return $form;
	}
}
