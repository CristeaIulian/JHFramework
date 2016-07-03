<?php

/**
 * Email Template Model.
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Models
 * @version 1.0.1
*/

namespace Application\Models;

use Core\DBModel;

/**
 * Email Template Model Class.
 * 
*/
class EmailTemplateModel extends DBModel {

	/**
	 * @var string $table The working table name.
	*/
	protected $table = 'email_templates';

	/**
	 * Gets a specific email template by a label.
	 * 
	 * @param string $label The Label for which you want to get the email template.
	 *
	 * @return object Email Template Record
	*/
	public function get_template($label) {

		$this->db->columns('subject, body');
		$this->db->where("label = '" . $label . "'");
		return $this->db->getRow();
	}
}