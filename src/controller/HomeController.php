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
use Instant\Core\Controller\BaseController;

class HomeController extends BaseController
{
    
	public function index()
	{
	    $home_page = $this->homePageModel->get();
	    
		$this->view->show('partial/head.php', ['PageTitle' => TITLE]);
        
		if($home_page !== false) {
		    $page = require_once($home_page);
		    $this->view->show('page/page.php', ['values' => $values]);
		} else {
		    $this->view->show('home.php');
		}
		$this->view->show('partial/footer.php');
	}

}