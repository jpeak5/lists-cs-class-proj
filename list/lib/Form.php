<?php
require_once('config.php');
class Form{

	public $date = strftime("%m/%d/%g",time());


	public $inputs = array();

	public function __contruct(){
		$now=time();
		$now = array(
			'date'=>strftime("%m/%d/%g",$now),
			'time'=>strftime("%H:%M",$now)
		);
		init($now);

	}

	private function init($now){
		$inputs=array(
			array(
				"type"=>"text",
				"name"=>"title",
				"value"=>"Title...",
				"maxlength"=>"16",
				"size"=>"16",
				"onfocus"=>null
			),
			array(
				"type"=>"text",
				"name"=>"description",
				"value"=>"Description...",
				"maxlength"=>"16",
				"size"=>"16",
				"onfocus"=>null
			),
			array(
				"type"=>"text",
				"name"=>"date",
				"value"=>$now["date"],
				"maxlength"=>"10",
				"size"=>"10",
				"onfocus"=>null
			),
			array(
				"type"=>"text",
				"name"=>"time",
				"value"=>$now["time"],
				"maxlength"=>"10",
				"size"=>"10",
				"onfocus"=>null
			)
		);
	}

	public static function toString($counter, $action){


		$form.="<form method=\"post\" action=\"{$action}\">";

		$form.="<ul>";

		$form.="<li>";

		$form.="<input type=\"text\" name=\"title\" value=\"Title...\" maxlength=\"16\" size=\"16\" onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\">";

		$form.="</li>";

		$form.="<li>";
		$form.="<input type=\"text\" name=\"description\" value=\"Description...\" onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\">";
		$form.="</li>";

		$form.="<li>";
		$now = time();
		$date = strftime("%m/%d/%g",$now);
		$time = strftime("%H:%M",$now);
		$form.="Due <input type=\"date\" name=\"date\" size=\"10\" maxlength=\"10\" value=\"{$date}\" onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\">";
		$form.="<input type=\"text\" name=\"time\" size=\"8\" maxlength=\"8\" value=\"{$time}\" onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\">";
		$form.="</li>";

		$form.="<li>";
		$form.="<input type=\"text\" name=\"hours\" value=\"Duration HH\" size=\"10\" maxlength=\"3\" onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\">";
		$form.="<input type=\"text\" name=\"minutes\" size=\"10\" maxlength=\"3\"  value=\"Duration MM\" onfocus=\"if(this.value==this.defaultValue)this.value='';\" onblur=\"if(this.value=='')this.value=this.defaultValue;\">";
		$form.="</li>";

		$form.="<br/>";

		$form.="<li>";

		$form.="<input type=\"hidden\" name=\"counter\" value=\"{$counter}\"/>";
		$form.="<input type=\"submit\" name=\"increment\" value=\"Next Task\">";
		$form.="<input type=\"submit\" name=\"submit\" value=\"submit\">";

		$form.="</li>";

		$form.="</ul>";

		$form.="</form>";

		//debug file contents
		//		$form.="<textarea rows=\"20\" cols=\"30\" readonly=\"readonly\">".File::readFromFile(YAML)."</textarea>";

		$form.="</section>";

		return $form;
	}
}
