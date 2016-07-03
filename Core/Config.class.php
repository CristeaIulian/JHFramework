<?php

/**
 * Application Configuration File
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Core
 * @version 1.0.1
*/

namespace Core;

use Core\Application;

/**
 * Application Configuration File Class
 * 
*/
class Config {

    /**
     * @var array $_config The configuration data of the Application.
    */
	private static $_config = null;

    /**
     * Loads data into $_config array from Configuration File.
     * 
     * @param string $key View Filename that you want to load
     * @todo Use Exception instead die.
     * @throws \Exception Key $key does not exist.
     * @return string Desired value for specified $key.
    */
	public static function get($key) {
		
		if (is_null(self::$_config)){
			self::$_config = require_once(dirname(__FILE__) . '/../Config/Config.' . Application::environment() . '.php');
		}

		if (isset(self::$_config[$key])) {
			return self::$_config[$key];
		} else {
			throw new \Exception("Key $key does not exist.", 1);
		}
	}
}