<?php
namespace app\models;

use lib\Model;

Class Index extends Model {
	public function get() {
		$stmt = self::$_pdo->prepare("SELECT * FROM user");
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}
?>