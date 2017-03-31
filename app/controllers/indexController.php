<?php
namespace app\controllers;

class Index extends \lib\Controller {
	
	public function index() {
		$model = $this->loadModel('app\models\Index');
		$model->setTable('user');
		// $model->Create(array('login' => 'Goat','nom' => 'bonjour' , 'mdp' => '123'));
		// $model->Read(['login' => 'Goat','mdp' => '123']);
		// $model->Update(['login' => 'Goat'],['login' => 'Text']);
		// $model->Delete(["login" => "text"]);
		$var = ["users" => ["BONJOUR","ELLE"]];	
		$var = $model->get();
		$this->render('index',$var);
	}
}