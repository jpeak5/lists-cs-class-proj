<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Users'.DS.'jpeak5'.DS.'Sites'.DS.'shopList'.DS.'list');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'lib');
defined('OUTPUT_PATH') ? null : define('OUTPUT_PATH', SITE_ROOT.DS.'output');
defined('FORMS_PATH') ? null : define('FORMS_PATH', SITE_ROOT.DS.'forms');
defined('JS_PATH') ? null : define('JS_PATH', LIB_PATH.DS.'js');
defined('CSS_PATH') ? null : define('CSS_PATH', SITE_ROOT.DS.'stylesheets');
defined('YAML') ? null : define('YAML', OUTPUT_PATH.DS.'output.yaml');
defined('LOG_FILE') ? null : define('LOG_FILE', OUTPUT_PATH.DS.'log.txt');
defined('SPYC') ? null : define('SPYC', LIB_PATH.DS.'spyc-0.5'.DS.'spyc.php');
defined('YAML_ROOT') ? null : define('YAML_ROOT', "DEVOIRS");

require_once(LIB_PATH.DS."Logger.php");
//require_once(LIB_PATH.DS."HTML.php");
//require_once(LIB_PATH.DS."File.php");
//require_once(LIB_PATH.DS."SocketWriter.php");
//require_once(LIB_PATH.DS."Todo.php");
//require_once(LIB_PATH.DS."TodoForm.php");
//require_once(LIB_PATH.DS."Transmitter.php");
//require_once(LIB_PATH.DS."spyc.php");
require_once(LIB_PATH.DS."Form.php");
require_once(LIB_PATH.DS."Input.php");
require_once(LIB_PATH.DS."R.php");
require_once(LIB_PATH.DS."SubmitHandler.php");
require_once(LIB_PATH.DS."Lists.php");
require_once(LIB_PATH.DS."ListItem.php");
require_once(LIB_PATH.DS."ShoppingList.php");
require_once(LIB_PATH.DS."TodoList.php");
require_once(LIB_PATH.DS."krumo".DS."class.krumo.php");

//output folder needs to be writable by the web server!!!!!
