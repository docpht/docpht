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

use DocPHT\Core\Translator\T;
use DocPHT\Form\AddUserForm;
use DocPHT\Form\RemoveUserForm;
use DocPHT\Form\TranslationsForm;
use DocPHT\Form\UpdatePasswordForm;
use Instant\Core\Views\View;

class BaseController
{
	public $view;
	public $removeUserForm;
	public $updatePasswordForm;
	public $translationsForm;
	public $addUserForm;
	
	public function __construct()
	{
		$this->view = new View();
		$this->updatePasswordForm = new UpdatePasswordForm();
		$this->removeUserForm = new RemoveUserForm();
		$this->addUserForm = new AddUserForm();
		$this->translationsForm = new TranslationsForm();
	}

}