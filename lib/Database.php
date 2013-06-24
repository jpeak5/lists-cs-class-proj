<?PHP

require_once(LIB_PATH . DS . "constants.php");
require_once('Logger.php');

class Database {

    private $connection;
    private $magic_quotes_active;
    private $my_sql_real_escape_string_exists;

    //get user input date, transform to db-appropriate format: "YYYY-MM-DD"
    public static function dbDatePrep($date) {
        if ($date == "") {
            $date = "0000-00-00";
        }
        $strDate = strftime('%F', strtotime($date));
        return $strDate;
    }

    public function insert_id() {
        return mysql_insert_id($this->connection);
    }

    public function num_rows($result_set) {
        return mysql_num_rows($result_set);
    }

    public function affected_rows() {
        return mysql_affected_rows($this->connection);
    }

    function __construct() {
        global $logger;
        $this->open_connection();
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->my_sql_real_escape_string_exists = function_exists("my_sql_real_escape_string");
        $logger->log(0, get_called_class() . "->__contruct()", "opening connection...");
        assert(get_class($logger)=='logger');
        assert(is_object($logger));
    }

    public function open_connection() {
        global $logger;

        //1. create a db connection (AKA handle)
//        $logger->log(0, get_called_class() . "->open_connection()", "trying connection..." . DB_SERVER . ":" . DB_NAME);
//        $logger->log(0, get_called_class() . "->open_connection()", "trying connection...");
        $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        if (!$this->connection) {
            $logger->log(10, get_called_class() . "->open_connection()", "mysql_connect() failed");
            die("DB connection Failed: " . mysql_error());
        } else {
            //2. Select a database to use
            $db_select = mysql_select_db(DB_NAME, $this->connection);
            if (!$db_select) {
                $logger->log(10, get_called_class() . "->open_connection()", "mysql_select_db() failed");
                die("database selection failed: " . mysql_error());
            }
            $logger->log(0, get_called_class()           . "->open_connection()", "connect success!!");
        }
    }

    public function close_connection() {

        //5. Close the connection

        if (isset($this->connection)) {
            $logger->log(0, get_called_class() . "->close_connection()", "calling mysql_close()");
            mysql_close($this->connection);
        }
    }

    public function escape_value($value) {
        if ($this->my_sql_real_escape_string_exists) {
            if ($this->magic_quotes_active) {
                $value = stripslashes($value);
            }
            $value = mysql_real_escape_string($value);
        } else {
            if (!$this->magic_quotes_active) {
                $value = addslashes($value);
            }
        }
        return $value;
    }

    public function executeQuery($query) {
        global $logger;
        $result = mysql_query($query, $this->connection);
        $logger->log(0, get_called_class() . "->execute_query(\"{$query}\")", "calling mysql_close()");
        $this->confirm_query($result);
        $logger->log(0, get_called_class() . "->execute_query(\"{$query}\")", "returning db result");
        return $result;
    }

    private function confirm_query($result) {
        global $logger;
        if (!$result) {
            $err = mysql_error();
            $logger->log(15, get_called_class() . "->confirm_query(\$result)","ERROR!!!: {$err}");
            die("Database query failed: " . mysql_error());
        }
    }

    public function fetch_array($result) {
        $array = mysql_fetch_array($result);
        return $array;
    }

    public function getScalar($query) {
        $result = $this->executeQuery($query);
        $array = $this->fetch_array($result);
        return $array[0];
    }

}

$database = new Database();
?>