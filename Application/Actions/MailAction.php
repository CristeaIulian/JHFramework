<?php

/**
 * Email Actions is used to send email for specific cases
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Actions
 * @version 1.0.1
*/

namespace Application\Actions;

use Application\Models\EmailTemplateModel;

use Application\Services\MailService;

use Core\Config;

/**
 * Email Actions Class is used to send email for specific cases
 * 
*/
class MailAction
{

	/**
	 * Send an email with a New Account Template to the user. If all good returns true, otherwise it will return false.
	 * 
	 * @param string $email Email Address to who will send the New Account email.
	 * @param string $password The password chosen by user. It will appear in his email.
	 * @return bool True if email has been sent with success and false otherwise.
	*/
	public static function sendNewAccountEmail($email, $password)
	{
		$EmailTemplateModel 		= (new EmailTemplateModel())->get_template('new_account');

		$EmailTemplateModel->body 	= sprintf($EmailTemplateModel->body, $email, htmlentities($password), Config::get('path.web'));

		return MailService::send_smtp($EmailTemplateModel->subject, $email, $EmailTemplateModel->body);
	}

	/**
	 * Send an email with a Reset Password Template to the user. If all good returns true, otherwise it will return false.
	 *
	 * @param string $email Email Address to who will send the Password Reset email.
	 * @param string $code The generated code for user. It will appear in his email.
	 * @return bool True if email has been sent with success and false otherwise.
	*/
	public static function sendPasswordResetEmail($email, $code)
	{
		$EmailTemplateModel 		= (new EmailTemplateModel())->get_template('password_reset');

		$EmailTemplateModel->body 	= sprintf($EmailTemplateModel->body, Config::get('path.web'), $code);

		return MailService::send_smtp($EmailTemplateModel->subject, $email, $EmailTemplateModel->body);
	}
}