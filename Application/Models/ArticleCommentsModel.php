<?php

/**
 * Article Comments Model.
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
 * Article Comments Model Class.
 * 
*/
class ArticleCommentsModel extends DBModel {

	/**
	 * @var string $table The working table name.
	*/
	protected $table = 'articles_comments';

	/**
	 * Gets comments of an article.
	 * 
	 * @param int $article_id The article ID for which you want to get comments.
	 *
	 * @return array Comments of the requested article.
	*/
	public function getArticleComments($article_id) {

		$this->db->columns('id, name, email, body, date_added');

		$this->db->where('article_id = ' . $article_id);

		$this->db->order('date_added DESC');

		return $this->db->getRows();
	}

	/**
	 * Delete data from working table based on specified PK ID.
	 * 
	 * @param int $id The PK ID that you want to delete.
	 *
	 * @return null
	*/
	public function delete($id) {

		$this->db->where('id = ' . $id);
		
		return $this->db->delete();
	}
}