<?php 
namespace lib;
abstract class Controller{
	protected $data = array();
	protected $layout = 'index';
	function __construct(){
		if (isset($_POST)){
			$this->data = $_POST;
		} else {
			$this->data = [];
		}
	}
	protected function setLayout($var) {
		$this->layout = $var;
	}
	public function render($filename, $data = []){
		if (is_null($data) || $data == '') {
			$data = [];
		}
		extract($data);
		ob_start();
		$controller = explode('\\',get_class($this))[2];
		require('../public/views/'.$controller.'/'.$filename.'.php');
		$content_for_layout = ob_get_clean();
		$content_for_layout = $this->templating($data,$content_for_layout);
		if($this->layout==false){
			echo $content_for_layout;
		} else {
			require('views/layout/'.$this->layout.'.php');
		}
	}
	function loadModel($name){
		$model = explode("\\",$name);
		require_once(ROOT.'app/models/'.(end($model)).'Model.php');
		return $this->$name = new $name();
	}
	public function templating($data,$content_for_layout){
		foreach ($data as $key => $value) {
			$regex = '/\{\{ (' . $key . ') \}\}/';
			$content_for_layout = preg_replace($regex,$value,$content_for_layout);
		}
		return $content_for_layout;
	}
}
?>	