<?php

/**
 * Date Service allows you to convert dates from a type to another
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

/**
 * Date Service Class is used to convert dates from a type to another
 * 
*/
class DateService {

	/**
	 * Converts a bigint like 20160302120304 to a unix datetime format
	 * 
	 * @param string $date Date in a bigint format like 20160302120304.
	 * @return string Unix datetime format or empty if the $date argument is empty.
	*/
	public static function bigInt2UnixDatetime($date) {

		if (empty($date)) {
			return '';
		}

		return substr($date, 0, 4) . '-' . substr($date, 4, 2) . '-' . substr($date, 6, 2) . ' ' . substr($date, 8, 2) . ':' . substr($date, 10, 2) . ':' . substr($date, 12, 2);
	}

	/**
	 * Converts a unix datetime to a bigint like 20160302120304
	 * 
	 * @param string $date Date in unix datetime format.
	 * @return int Datetime in a Bigint format like 20160302120304 or empty if the $date argument is empty.
	*/
	public static function unixDatetime2bigInt($date) {

		if (empty($date)) {
			return '';
		}

		return str_replace(array('-', ':', ' '), array('', '', ''), $date);
	}
}