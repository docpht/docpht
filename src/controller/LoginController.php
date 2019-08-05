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

class LoginController extends BaseController
{
    
	public function login()
	{
        $users = $this->adminModel->getUsers();

        if (isset($_SESSION['Username'])) {
            header("Location:".BASE_URL);
            exit;
        }

        $this->view->show('login.php');
        
        if(isset($_POST['Submit'])){

            foreach ($users as $user) {

                    $username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_EMAIL);
                    $password = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING);

                    $result = password_verify($password, $user['Password']);

                if( ($username == $user['Username']) && ($result === true) ) {

                        $_SESSION['Username'] = $username;

                        $_SESSION['Active'] = true;

                        if (isset($_SERVER['HTTP_REFERER'])) {
                            header("Location:".$_SERVER['HTTP_REFERER']);
                            exit;
                        } else {
                            header("Location:".BASE_URL);
                            exit;
                        }
                        exit;
                }  else {
                    $error = '<div class="container"><div class="alert alert-danger alert-dismissible mt-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    '.T::trans('Warning! The data entered is incorrect.').'
                             </div></div>';
                }
            }
            
            echo $error;
        } 
	}

    public function logout()
    { 
        session_destroy();
      
        header("Location:".BASE_URL);
        exit;
    }

    public function lostPassword()
	{
        $form = $this->lostPassword->sendEmail();
        
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Lost password')]);
		$this->view->show('lost_password.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
    }
    
    public function recoveryPassword($token)
	{
        $form = $this->recoveryPassword->create($token);
        
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Recovery password')]);
		$this->view->show('lost_password.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}
}