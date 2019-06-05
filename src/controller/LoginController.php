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

                    $result = password_verify($_POST['Password'], $user['Password']);

                if( ($_POST['Username'] == $user['Username']) && ($result === true) ) {

                        $_SESSION['Username'] = $user['Username'];

                        $_SESSION['Active'] = true;

                        if (isset($_SESSION['url'])) {
                            header("Location:/?BackURL=".$_SESSION['url']);
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
}