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
		$controller = strtolower(explode('\\',get_class($this))[2]);
		$loader = new \Twig_Loader_Filesystem('../app/views/'.$controller.'/');
		$twig = new \Twig_Environment($loader);
		$content_for_layout = $twig->render($filename.'.php',$data);
		if($this->layout==false){
			echo $content_for_layout;
		} else {
			require(ROOT.'app/views/layout/'.$this->layout.'.php');
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
	public function getParam($param) {
		return $_GET[$param];
	}
}
?>	