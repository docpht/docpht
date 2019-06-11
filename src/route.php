<?php

use DocPHT\Controller\FormPageController;
use DocPHT\Controller\ErrorPageController;
use DocPHT\Controller\LoginController;

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

$route->get('/', 'DocPHT\Controller\HomeController@index');

$route->get_post('/login', 'DocPHT\Controller\LoginController@login');

if (isset($_SESSION['Active'])) {

    $route->get('/logout', 'DocPHT\Controller\LoginController@logout');
    
    $route->group('/admin', function()
    {
        // /admin/
        $this->get('/', 'DocPHT\Controller\AdminController@settings');

        // /admin/update-password
        $this->get_post('/update-password', 'DocPHT\Controller\AdminController@updatePassword');

        if (isset($_SESSION['Active']) && $_SESSION['Username'] == ADMIN) {
             // /admin/remove-user
            $this->get_post('/remove-user', 'DocPHT\Controller\AdminController@removeUser');

            // /admin/add-user
            $this->get_post('/add-user', 'DocPHT\Controller\AdminController@addUser');

            // /admin/create-home
            $this->get_post('/create-home', 'DocPHT\Controller\AdminController@createHome');
        }
        
        // /admin/translations
        $this->get_post('/translations', 'DocPHT\Controller\AdminController@translations');

        // Anything else
        $this->any('/*', function(){
            $error = new ErrorPageController();
            $error->getPage();
        });
    });
} else {
    $route->any('/admin', function(){
        $login = new LoginController();
        $login->login();
    });
    
    $route->any('/admin/*', function(){
        $login = new LoginController();
        $login->login();
    });
}

// /page
$route->group('/page', function()
{
    // /page/topic/filename
    $this->get_post('/{topic}/{filename}', function($topic, $filename){
        $page = 'pages/'.$topic.'/'.$filename.'.php';
        if (file_exists($page)) {
            $page = new FormPageController();
            $page->getPage($topic, $filename);
        } else {
            $error = new ErrorPageController();
            $error->getPage();
        }
    });

    if (isset($_SESSION['Active'])) {
        // /page/create
        $this->get_post('/create', 'DocPHT\Controller\FormPageController@getCreatePageForm');
        // /page/add-section
        $this->get_post('/add-section', 'DocPHT\Controller\FormPageController@getAddSectionForm');
    } else {
        $this->any('/page/*', function(){
            $login = new LoginController();
            $login->login();
        });
    }
    
    // Anything else
    $this->any('/*', function(){
        $error = new ErrorPageController();
        $error->getPage();
    });
});

// Anything else
$route->any('/*', function(){
    $error = new ErrorPageController();
    $error->getPage();
});