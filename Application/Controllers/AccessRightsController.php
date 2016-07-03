<?php

/**
 * Access Rights Controller
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

use Application\Models\AccessRightsModel;

use Core\Config;

/**
 * Access Rights Controller Class
 * 
*/
class AccessRightsController extends BaseController {

	/**
	 * Datagrid Listing page
	 * 
	 * @return null 
	*/
	public function Index() {

		$AccessRightsModel = new AccessRightsModel();

		$this->render('AccessRights', [
			'pageTitle' 	=> '<i class="material-icons">security</i> Access Rights',
			'AccessRights' 	=> $AccessRightsModel->getAll(PagerService::getLimits(), $this->session->filter),
			'pager'			=> PagerService::getPager($AccessRightsModel->db->count()),
			'filters'		=> FilterService::getTableRowFilters('AccessRights', ['id', 'controller', 'action', 'users', 'ajax']),
		]);
	}

	/**
	 * Adds a new Access Right
	 * 
	 * @return null 
	*/
	public function AddExec() {

		$AccessRightsModel = new AccessRightsModel();
		$insertResponse 	= $AccessRightsModel->insert([]);

		$this->renderJson([
			'newId'		=> $AccessRightsModel->db->insertId(),
			'message' 	=> (in_array($insertResponse, [1])) ? 'Access right added successfully.' : 'Could not add Access Right.',
			'success' 	=> (in_array($insertResponse, [1])) ? true : false,
		]);
	}

	/**
	 * Updates a field with a received value
	 * 
	 * @return null 
	*/
	public function UpdateFieldExec() {

		$updateResponse = (new AccessRightsModel())->update($this->post, $this->post['id']);

		$this->renderJson([
			'message' => (in_array($updateResponse, [0, 1])) ? 'Record updated successfully.' : 'Could not update record.',
			'success' => (in_array($updateResponse, [0, 1])) ? true : false,
		]);
	}

	/**
	 * Deletes Access Right Controller Action
	 * 
	 * @return null 
	*/
	public function DeleteExec() {

		$deleteResponse = (new AccessRightsModel())->delete($this->get['id']);

		$this->renderJson([
			'message' => (in_array($deleteResponse, [0, 1])) ? 'Access Right deleted successfully.' : 'Could not delete Access Right.',
			'success' => (in_array($deleteResponse, [0, 1])) ? true : false,
		]);
	}
}