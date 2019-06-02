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

use DocPHT\Overrides\Controller\BaseController;

class HomeController extends BaseController
{
    
	public function __construct()
	{
		parent::__construct();
	}
    
	public function index()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Doc PHT']);
		$this->view->show('home.php');
		$this->view->show('partial/footer.php');
	}

}