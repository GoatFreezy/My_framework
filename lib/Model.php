<?php
namespace lib;

abstract class Model {
	private static $table;
	protected static $_pdo = null;
	private static $database;
	private static $host;
	private static $user;
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
	public function setTable($table) {
		$this->table = $table;
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
	public function getTable() {
		return $this->table;
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
	public function Create($data) {
		if (is_array($data)) {
			$values = [];
			$sql = "INSERT INTO ".$this->table.'(';
			$i = 1;
			$max = count($data);
			foreach ($data as $key => $value) {
				if ($i < $max) 
					$sql .= $key.',';
				else 
					$sql .= $key;
				$i++;
			}
			$sql .= ') VALUES (';
			$i = 1;
			foreach ($data as $key => $value) {
				if ($i < $max) 
					$sql .= '?,';
				else 
					$sql .= '?';
				$i++;
				array_push($values,$value);
			}
			$sql .= ')'; 
			$stmt = self::$_pdo->prepare($sql);
			$stmt->execute($values);
		}
	}
	public function Read($data) {
		if (is_array($data)) {
			$sql = "SELECT * FROM ".$this->table.' WHERE ';
			$i = 1;
			$values = [];
			$max = count($data);
			foreach ($data as $key => $value) {
				if ($i < $max) 
					$sql .= $key.' = ? AND ';
				else 
					$sql .= $key.' = ?';
				$i++;
				array_push($values,$value);
			}
			$stmt = self::$_pdo->prepare($sql);
			$stmt->execute($values);
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}	
	}
	public function Update($where,$data) {
		if (is_array($data)) {
			$i = 1;
			$values = [];
			$max = count($data);
			$sql = "UPDATE ".$this->table." SET ";
			foreach ($data as $key => $value) {
				if ($i < $max) 
					$sql .= $key.' = ? AND ';
				else 
					$sql .= $key.' = ?';
				$i++;
				array_push($values,$value);
			}
			$sql .= ' WHERE ';
			$i = 1;
			foreach ($where as $key => $value) {
				if ($i < $max)
					$sql .= $key.' = ? AND';
				else 
					$sql .= $key.' = ?';
				$i++;
				array_push($values,$value);
			}
			$stmt = self::$_pdo->prepare($sql);
			$stmt->execute($values);
		}
	}
	public function Delete($data) {
		$sql = "DELETE FROM ".$this->table." WHERE ";
		$i = 1;
		$max = count($data);
		$values = [];
		foreach ($data as $key => $value) {
			if ($i < $max)
				$sql .= $key.' = ? AND';
			else 
				$sql .= $key.' = ?';
			$i++;
			array_push($values,$value);
		}
		$stmt = self::$_pdo->prepare($sql);
		$stmt->execute($values);
		var_dump($stmt->errorInfo());
	}
}
?>