<?php

/**
 * Application View Engine
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Core
 * @version 1.0.1
*/

namespace Core;

/**
 * Application View Engine Class
 * 
*/
class view {

    /**
     * @var string $path Folder from where you can load the Views.
    */
	public $path 		= 'Application/Views/';
	
    /**
     * @var string $extension Desired Views Extension.
    */
	public $extension 	= 'php';

    /**
     * View Loader
     * 
     * @param string $filename View Filename that you want to load
     * @param string|int|float|array|object $data Data passed to the View. If its array or object it will be splitted in multiple variables and passed, otherwise it will be passed directly.
     * @todo Use Exception instead die.
     * @return string|null Parsed HTML content of the view. If the view cannot be found it will halt with an error message.
    */
	public function load($filename, $data) {

		if (file_exists(dirname(__FILE__) . '/../' . $this->path . $filename . '.' . $this->extension)) {

			ob_start();

			switch (gettype($data)) {
			 	case 'array':
			 		extract($data);
			 		break;
			 	case 'object':
			 		foreach ($data as $key => $value) {
			 			$$key = $value;
			 		}
			 		break;
			 	default:
			 		die('Cannot handle ' . gettype($data));
			 		break;
			 }

			$view = include(dirname(__FILE__) . '/../' . $this->path . $filename . '.' . $this->extension);

			return ob_get_clean();

		} else {
			die('View ' . $filename . ' not found');
		}
	}
}