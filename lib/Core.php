<?php
namespace lib;

Class Core {
	public static function run() {
		session_start();
		spl_autoload_register(array(__CLASS__, 'autoload'));
		define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']."../"));
		define('ROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']."../"));
		require(ROOT.'lib/Model.php');
		require(ROOT.'lib/Controller.php');
		$params = explode('/',$_GET['p']);
		$controller = !empty($params[0]) ? $params[0] : 'index';
		$action = isset($params[1]) ? $params[1] : 'index';
		if (!file_exists(ROOT.'app/controllers/'.$controller.'Controller.php')){
			// require_once('error404.php');
			echo "404";
		}
		else{
			if(file_exists(ROOT.'app/controllers/' . $controller . 'Controller.php')){
				require(ROOT.'app/controllers/'.$controller.'Controller.php');
				$name = 'app\controllers\\' . $controller;
				$controller = new $name;
			}
		}
		if (method_exists($controller, $action)){
			unset($params[0]);
			unset($params[1]);
			call_user_func_array(array($controller,$action),$params);
		} else {
			// require_once('error404.php') ;
		}

	}
	static function loadConfig() {
		$config = parse_ini_file(ROOT."public/config.ini");
		return $config;
	}
	static function autoload($class){
		$class = explode("\\",$class);
		$class = end($class);
		if(file_exists('../app/controllers/' . $class . 'Controller.php')){
			require_once('../app/controllers/' . $class . 'Controller.php');
		}
		elseif(file_exists('../app/models/' . $class . 'Model.php')){
			require_once('../app/models/' . $class . 'Model.php');
		} 
	}
}
?>