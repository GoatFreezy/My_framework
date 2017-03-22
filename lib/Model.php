<?php
namespace lib;
class Model {
	protected $table;
	protected static $_pdo = null;
	function __construct() {
		$user = "root";
		$password = "";
		$database = "bet";
		$host = "localhost";

		if (self::$_pdo === null) {
			self::$_pdo = new PDO("mysql:dbname=".$database.";host=".$host,$user,$password);
		}
	}
	public function getUser($login) {
		$query = self::$_pdo->prepare("SELECT * FROM user WHERE login = ?");
		$query->execute(array($login));
		return $query->fetch(PDO::FETCH_ASSOC);
	}
}
?>