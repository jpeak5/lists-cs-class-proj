<?php
require_once('config.php');
class Logger{

	public function log($severity, $component, $message=""){
		
		switch($severity){
			case 0:
				$severity = "DEBUG";
				break;
			case 5:
				$severity = "NOTICE";
				break;
			case 10:
				$severity = "WARN";
				break;
			case 15:
				$severity = "ERROR";
				break;
			case 20:
				$severity = "FATAL";
				break;
		}

		$time = (strftime('%F %T', time()));

		//formulate the information into a string
		$entry = $time." | ".$severity." | [".$component."] | ".$message."\n";

		if(($handle = fopen(LOG_FILE, "a+"))!==false){
                    assert($handle !==false);
			//write the info
			fwrite($handle, $entry);
			//close the file
			fclose($handle);
			return true;
		}
		else{
                    die("couldn't open the file!");
		}
	}

}
$logger=new Logger();
?>