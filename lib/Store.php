<?php

require_once 'config.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Store
 *
 * @author jpeak5
 */
Class Store extends dbObject {

    //put your code here
    
    static $table_name = "Stores";
    static $db_fields = array('id', 'name', 'address_id');
    public $name;
    public $id;
    public $address_id;
    
    
    public function __construct() {
        global $logger;
        $logger->log(0, get_called_class()."->__construct()", "construct");
    }

}

?>
