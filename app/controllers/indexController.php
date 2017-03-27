<?php
namespace app\controllers;

class Index extends \lib\Controller {
	
	public function index() {
		$model = $this->loadModel('app\models\Index');
		$model->setDatabase('asd');
		$model->setPassword('base');
		$model->setHost('base');
		$model->setUser('base');
		$this->render('index',["login" => "BONJOUR"]);
	}
}