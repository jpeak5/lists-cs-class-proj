<?PHP
require_once(LIB_PATH.DS."constants.php");

class Database{

	private $connection;
	private $magic_quotes_active;
	private $my_sql_real_escape_string_exists;
	
	
	
	//get user input date, transform to db-appropriate format: "YYYY-MM-DD"
	public static function dbDatePrep($date){
	if($date == ""){
	$date = "0000-00-00";
	}
	$strDate = strftime('%F', strtotime($date));
	return $strDate;
	}
	
	public function insert_id(){
		return mysql_insert_id($this->connection);
	}
	
	public function num_rows($result_set){
		return mysql_num_rows($result_set);
	}
	
	public function affected_rows(){
		return mysql_affected_rows($this->connection);
	}
	
	function __construct(){
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->my_sql_real_escape_string_exists = function_exists("my_sql_real_escape_string");

		}


	public function open_connection(){

		//1. create a db connection (AKA handle)
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$this->connection){
			die("DB connection Failed: " . mysql_error());
			}
		
		else{	
			//2. Select a database to use
			$db_select = mysql_select_db(DB_NAME,$this->connection);
			if (!$db_select) {
				die("database selection failed: " . mysql_error());
				}
			}
	}

	public function close_connection(){
			
			//5. Close the connection
			
			if (isset($this->connection)){
			mysql_close($this->connection);
			}
	
	
	}
	
	public function escape_value($value){
		if($this->my_sql_real_escape_string_exists){
			if($this->magic_quotes_active){$value = stripslashes($value);
				}
				$value = mysql_real_escape_string($value);
			}
			else {
				if(!$this->magic_quotes_active){$value = addslashes($value);}
			}
			return $value;
		
		}
  
	
	public function executeQuery($query){
		$result = mysql_query($query, $this->connection);
		//TODO: why does this get executed many times when creating a new JOB object?
// 		echo $query;
		$this->confirm_query($result);
		return $result;
		}

	private function confirm_query($result){
		if (!$result) {
		  die("Database query failed: ".mysql_error());				
		  }
		}	

	public function fetch_array($result){
	$array = mysql_fetch_array($result);
	return $array;
	}					
	
	public function getScalar($query){
		$result = $this->executeQuery($query);
		$array = $this->fetch_array($result);
		return $array[0];
	}

}
$database = new Database();

?>