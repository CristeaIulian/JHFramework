<?php

/**
 * Filter Services Filters the Datagrid
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

/**
 * Filter Services Class Filters the Datagrid
 * 
*/
class FilterService {

	/**
	 * Builds the row with necessary columns that will be displayed in the top of the datagrid.
	 *
	 * @param string $section Typically the controller name that you use. This is require to distinguish the filters between pages
	 * @param array $filters Filters list that you want to be displayed.
	 * @todo try to use array_map instead of the foreach below: foreach ($filters as $filter) {
	 * @return string The HTML with the filters row.
	*/
	public static function getTableRowFilters($section, $filters) {

		$session = new SessionService;

		$result = '<tr><th></th>';

		foreach ($filters as $filter) {
			$result .= (empty($filter)) ? '<th></th>' : '<th><input type="text" name="filter_' . $filter . '" value="' . ((isset($session->filter[$section][$filter])) ? $session->filter[$section][$filter] : '') . '" class="form-control filterField" class="form-control filterField" /></th>';
		}

		$result .= '</tr>';

		return $result;
	}
}
