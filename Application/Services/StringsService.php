<?php

/**
 * String Service Prepare strings and formats them
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

/**
 * String Service Class Prepare strings and formats them
 * 
*/
class StringsService {

	/**
	 * Escape strings in a recursive manner.
	 *
	 * @param array $var The variable used to be escaped.
	 * @return string The formated escaped strings array.
	*/
	public static final function escapeRecursive($var) {

		foreach ($var as $field => $value) {
			if (is_string($value)) {
				$var[$field] = addslashes(stripslashes($value)); // stripslashes - to avoid multiple slashes
			} else if (is_array($value)) {
				$var[$field] = self::escapeRecursive($value);
			}
		}

		return $var;
	}

	/**
	 * Shortens a string by a given length.
	 *
	 * @param string $string The string you want to shorten.
	 * @param array $strMaxLen Maximum length of resulting string.
	 * @return string The shorten string.
	*/
	public static final function shorten($string, $strMaxLen = 300) {

		if (strlen($string) < $strMaxLen) { 
			return $string;
		}

		return mb_substr($string, 0, $strMaxLen) . ' ...';
	}
}