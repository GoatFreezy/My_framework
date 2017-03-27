<?php
namespace lib;

abstract class Model {
	protected $table;
	protected static $_pdo = null;
	private static $database = null;
	private static $host = null;
	private static $user = null;
	private static $password;
	function __construct() {
		if (file_exists(ROOT."public/config.ini")) {
			$row = Core::loadConfig();
			self::$_pdo = new \PDO("mysql:dbname=".$row['dbname'].";host=".$row['host'],$row['user'],$row['password']);
		}
		else {
			self::$_pdo = new \PDO("mysql:dbname=".$this->database.";host=".$this->host,$this->user,$this->password);
		}
	}
	public function setDatabase($database) {
		$this->database = $database;
	}
	public function setHost($host) {
		$this->host = $host;
	}
	public function setUser($user) {
		$this->user = $user;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
	public function getDatabase() {
		return $this->database;
	}
	public function getHost() {
		return $this->host;
	}
	public function getUser() {
		return $this->user;
	}
	public function getPassword() {
		return $this->password;
	}	
}
?>