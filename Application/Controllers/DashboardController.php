<?php

/**
 * Dashboard Controller
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application/Controllers
 * @version 1.0.1
*/

namespace Application\Controllers;

/**
 * Dashboard Controller Class
 * 
*/
class DashboardController extends BaseController {

	/**
	 * Datagrid Listing page
	 * 
	 * @return null 
	*/
	public function Index() {
		$this->render('Dashboard', [
			'pageTitle' => '<i class="material-icons">home</i> Dashboard',
		]);
	}
}