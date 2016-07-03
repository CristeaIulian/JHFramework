<?php

if (php_sapi_name() !== 'cli' && isset($_SERVER['REQUEST_URI'])) {

	list($controllerName, $actionName) = \Core\Router::parsePath();

	// check if it is Module {
	// $Modules = array();
	// foreach (scandir('Controllers') as $ctrl) {
	// 	if (!in_array($ctrl, array('.', '..')) && is_dir('Controllers' . DIRECTORY_SEPARATOR . $ctrl)){
	// 		$Modules[] = $ctrl;
	// 	}
	// }

	// foreach ($Modules as $Module) {
	// 	if (substr($Router->controller, 0, strlen($Module)) == $Module && $Router->controller != $Module . 'Controller'){
	// 		$controllerName = '\Controllers\\'.$Module.'\\'.substr($Router->controller, 6);
	// 	}
	// }
	// check if it is Module }

	// otherwise is simple controller {
	// if (!isset($controllerName)) {
		$controllerName = '\Application\\Controllers\\'.$controllerName;
	// }
	// otherwise is simple controller }


	define('CONTROLLER_NAME', 		$controllerName);
	define('CONTROLLER_SHORT_NAME', substr(basename($controllerName), 0, -10));
	define('ACTION_NAME', 			$actionName);

	$callMethod 	= new $controllerName;
	$callMethod->{$actionName}();

} else {
	die('Not implemented');
}
