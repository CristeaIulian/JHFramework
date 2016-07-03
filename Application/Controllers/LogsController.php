<?php

/**
 * Logs Controller
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application/Controllers
 * @version 1.0.1
*/

namespace Application\Controllers;

use Application\Services\PagerService;
use Application\Services\FilterService;

use Application\Models\LogModel;

use Core\Config;

/**
 * Logs Controller Class
 * 
*/
class LogsController extends BaseController {

	/**
	 * Datagrid Listing page
	 * 
	 * @return null 
	*/
	public function Index() {

		$LogModel = new LogModel();

		$this->render('Logs', [
			'pageTitle' => '<i class="material-icons">assignment</i> Logs (latest 3 months)',
			'logs' 		=> $LogModel->getAll(PagerService::getLimits(), $this->session->filter),
			'pager'		=> PagerService::getPager($LogModel->db->count()),
			'filters'	=> FilterService::getTableRowFilters('Logs', ['t.id', 'name', 'action', 'details', 'date_added']),
		]);
	}

	/**
	 * Deletes Log Controller Action
	 * 
	 * @return null 
	*/
	public function DeleteExec() {

		$deleteResponse = (new LogModel())->delete($this->get['id']);

		$this->renderJson([
			'message' => (in_array($deleteResponse, [1])) ? 'Log deleted successfully.' : 'Could not delete log.',
			'success' => (in_array($deleteResponse, [1])) ? true : false,
		]);
	}
}