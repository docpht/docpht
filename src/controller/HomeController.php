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

namespace Instant\Controller;

use Instant\Core\Controller\BaseController;

class HomeController extends BaseController
{
    
	public function __construct()
	{
		parent::__construct();
	}
    
	public function index()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Doc PHT']);
		$this->view->show('Home.php');
		$this->view->show('partial/footer.php');
	}

}