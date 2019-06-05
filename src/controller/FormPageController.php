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

use Instant\Core\Controller\BaseController;
use DocPHT\Form\CreatePageForm;

class FormPageController extends BaseController
{
	private $createPage;
	
	public function __construct()
	{
		parent::__construct();
		$this->createPage = new CreatePageForm();
	}
    
	public function getCreatePageForm()
	{
		$form = $this->createPage->create();

		$this->view->show('partial/head.php', ['PageTitle' => 'Doc PHT']);
		$this->view->show('form-page/create_page.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

}