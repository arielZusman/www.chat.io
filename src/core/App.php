<?php 

/**
*  Simple controller
*  used to delegate action based on url like string 
*  $app->action('class/method/param1/param2')
*/
class App
{
	
	protected 	$controller,
				$method,
				$params;

	public function action($action)
	{
		$action = explode('/', rtrim($action, '/'));

		//class name
		if (file_exists($action[0] . '.php')) {
			$this->controller = $action[0];
			unset($action[0]);


			require_once $this->controller . '.php';

			$this->controller = new $this->controller;

		// method
			If(isset($action[1])){
				if(method_exists($this->controller, $action[1])){
					$this->method = $action[1];
					unset($action[1]);
				}
			}

			$this->params = $action ? array_values($action) : [];

			call_user_func_array([$this->controller, $this->method], $this->params);

		}
	}
}