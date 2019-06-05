<?php

/**
 * This file is part of the DocPHT project.
 * 
 * @author Valentino Pesce
 * @copyright (c) Valentino Pesce <valentino@iltuobrand.it>
 * @copyright (c) Craig Crosby <creecros@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DocPHT\Controller;

use DocPHT\Core\Translator\T;
use DocPHT\Form\CreatePageForm;
use Instant\Core\Controller\BaseController;

class FormPageController extends BaseController
{
	private $createPageForm;
	
	public function __construct()
	{
		parent::__construct();
		$this->createPageForm = new CreatePageForm();
	}
    
	public function getCreatePageForm()
	{
		$form = $this->createPageForm->create();

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Create new')]);
		$this->view->show('form-page/create_page.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

}