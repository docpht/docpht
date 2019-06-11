<?php

/**
 * This file is part of the Instant MVC micro-framework project.
 * 
 * @package     Instant MVC micro-framework
 * @author      Valentino Pesce 
 * @link        https://github.com/kenlog
 * @copyright   2019 (c) Valentino Pesce <valentino@iltuobrand.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instant\Core\Controller;

use DocPHT\Form\AddUserForm;
use DocPHT\Model\AdminModel;
use Instant\Core\Views\View;
use DocPHT\Form\CreatePageForm;
use DocPHT\Form\RemoveUserForm;
use DocPHT\Form\TranslationsForm;
use DocPHT\Form\UpdatePasswordForm;
use DocPHT\Form\AddSectionForm;
use DocPHT\Core\Error;

class BaseController
{
	protected $view;
	protected $removeUserForm;
	protected $updatePasswordForm;
	protected $translationsForm;
	protected $addUserForm;
	protected $createPageForm;
	protected $adminModel;
	protected $addSectionPageForm;
	protected $error;
	
	public function __construct()
	{
		$this->view = new View();
		$this->updatePasswordForm = new UpdatePasswordForm();
		$this->removeUserForm = new RemoveUserForm();
		$this->addUserForm = new AddUserForm();
		$this->translationsForm = new TranslationsForm();
		$this->createPageForm = new CreatePageForm();
		$this->adminModel = new AdminModel();
		$this->addSectionPageForm = new AddSectionForm();
		$this->error = new Error();
	}

}