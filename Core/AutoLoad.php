<?php

// set_include_path(get_include_path() . PATH_SEPARATOR . BASEPATH . 'controllers/View');

spl_autoload_register(function($className){

	$clsArray = explode('\\', $className);

	if (count($clsArray) != 2 && count($clsArray) != 3){
		throw new Exception('Invalid class specification: ' . $className, 1);
	}

	switch ($clsArray[0]){
		case 'Application':
			switch ($clsArray[1]){
				case 'Controllers':
				case 'Models':
				case 'ModelsAR':
				case 'Services':
				case 'Actions':
					$classFile = $className . '.php';
				break;
				default:
					throw new Exception('Unkown subclass specifier ' . $clsArray[1], 1);
				break;
			}
		break;
		case 'Core':
			if (isset($clsArray[1])) {
				$classFile = $className . '.class.php';
			} else {
				$classFile = $className . '.class.php';
			}

			
			
		break;
		default:
			throw new Exception('Unkown class specifier ' . $clsArray[0], 1);
		break;
	}
// echo dirname(__FILE__)  . '/../' . $classFile;
	if (file_exists(dirname(__FILE__)  . '/../' . $classFile)){
		require(dirname(__FILE__)  . '/../' . $classFile);
	} else {
		throw new Exception('Class '.$className.' not exists.', 1);
	}
});