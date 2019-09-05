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
        if (isset($_SESSION['Active'])) {
            header("Location:".BASE_URL);
            exit;
        }

        $form = $this->loginForm->create();
        $this->view->show('login/partial/head.php', ['PageTitle' => T::trans('Login')]);
        $this->view->show('login/login.php', ['form' => $form]);
        $this->view->show('login/partial/footer.php');
    }

    public function checkLogin(string $username, string $password)
    {
        $username = $this->usernameFilter($username);
        $password = $this->passwordFilter($password);
        
        $userExists = $this->adminModel->userExists($username);
        
        if ($userExists) {

            $users = $this->adminModel->getUsers();
            foreach ($users as $user) {

                $checkUser = $username === $user['Username'];
                $checkPassowrd = password_verify($password, $user['Password']);

                if ($checkUser && $checkPassowrd === true) {
                    session_regenerate_id(true);
                    $_SESSION['PREV_USERAGENT'] = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['Username'] = $username;
                    $_SESSION['Active'] = true;
                    $accesslog = $this->accessLogModel->create($username);
                    return true;
                } elseif($checkUser && $checkPassowrd === false) {
                    $accesslog = $this->accessLogModel->create($username);
                    return false;
                }
            }
        }
    }

    public function usernameFilter($username) 
    {
        $username = trim($username);
        $username = stripslashes($username);
        $username = strip_tags($username);
        $username = filter_var($username, FILTER_SANITIZE_EMAIL);
        $username = filter_var($username, FILTER_VALIDATE_EMAIL);
        return $username;
    }

    public function passwordFilter($password) 
    {
        $password = trim($password);
        $password = stripslashes($password);
        $password = strip_tags($password);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        return $password;
    }

    public function logout()
    { 
        session_unset();
        session_destroy();
      
        header("Location:".BASE_URL);
        exit;
    }

    public function lostPassword()
    {
        $form = $this->lostPassword->sendEmail();
        
        $this->view->show('login/partial/head.php', ['PageTitle' => T::trans('Lost password')]);
        $this->view->show('login/lost_password.php', ['form' => $form]);
        $this->view->show('login/partial/footer.php');
    }
    
    public function recoveryPassword($token)
    {
        $form = $this->recoveryPassword->create($token);
        $this->view->show('login/partial/head.php', ['PageTitle' => T::trans('Recovery password')]);
        $this->view->show('login/lost_password.php', ['form' => $form]);
        $this->view->show('login/partial/footer.php');
    }
}
