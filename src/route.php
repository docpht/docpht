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

$route->get('/', 'DocPHT\Controller\HomeController@index');

$route->get_post('/login', 'DocPHT\Controller\LoginController@index');

if (isset($_SESSION['Active'])) {
    $route->get('/logout', 'DocPHT\Controller\LoginController@logout');
    
    $route->group('/admin', function()
    {
        // /admin/
        $this->get('/', 'DocPHT\Controller\AdminController@settings');

        // /admin/update-password
        $this->get_post('/update-password', 'DocPHT\Controller\AdminController@updatePassword');

        if (isset($_SESSION['Active']) && $_SESSION['Username'] == ADMIN) {
            error_log($_SESSION['Username'],0);error_log(ADMIN,0);
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
            pre("Page ( {$this->app->request->path} ) Not Found", 6);
        });
    });
}

// Anything else
$route->any('/*', function(){
    pre("Page ( {$this->app->request->path} ) Not Found", 6);
});