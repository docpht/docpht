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

//use Instant\Model\Admin;
use Instant\Core\Controller\BaseController;

class AdminController extends BaseController
{
	private $modelAdmin;
    
	public function __construct()
	{
		parent::__construct();
		//$this->modelAdmin = new Admin();
	}
			
	public function settings()
	{
		//$data = $this->modelAdmin->getData();
		$this->view->show('partial/head.php',['PageTitle' => 'Admin']);
		$this->view->show('admin/settings.php');
		$this->view->show('partial/footer.php');
	}

	public function updatePassword()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Update Password']);
        $this->view->show('admin/update_password.php');
		$this->view->show('partial/footer.php');
	}

	public function removeUser()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Remove User']);
		$this->view->show('admin/remove_user.php');
		$this->view->show('partial/footer.php');
	}
		
	public function addUser()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Add user']);
		$this->view->show('admin/add_user.php');
		$this->view->show('partial/footer.php');
	}

}