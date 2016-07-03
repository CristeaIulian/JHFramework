<?php

/**
 * Index Controller
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application/Controllers
 * @version 1.0.1
*/

namespace Application\Controllers;

/**
 * Index Controller Class
 * 
*/
class IndexController extends BaseController {

	/**
	 * @var string $layout Application View Layout
	*/
	protected $layout = 'LayoutBasic';

	/**
	 * Datagrid Listing page
	 * 
	 * @return null 
	*/
	public function Index() {
		$this->redirect((!is_null($this->session->login)) ? 'Dashboard' : 'Login');
	}

	/**
	 * Updates the number of Items displayed per page.
	 * 
	 * @return null 
	*/
	public function UpdateItemsPerPage() {

		$recordsPerPage = $this->session->recordsPerPage;

		$recordsPerPage[htmlentities($this->get['section'])] 	= (int)$this->get['itemsPerPage'];
		$this->session->recordsPerPage 							= $recordsPerPage;

		$this->redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Filters data from Datagrid according to selected filters.
	 * 
	 * @return null 
	*/
	public function Filter() {

		$sectionFilter = $this->session->filter;

		$sectionFilter[$this->post['section']] = [];

		foreach ($this->post['data'] as $key => $filter) {
			if (!empty($filter['value'])) {
				$sectionFilter[$this->post['section']][substr($filter['name'], 7)] = $filter['value'];
			}
		}

		$this->session->filter = $sectionFilter;

		$this->renderJson([
			'status' => 'success',
			'message' => 'set',
		]);
	}
}