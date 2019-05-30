<?php

/**
 * This file is part of the DocPHT MVC micro-framework project.
 * 
 * @package     DocPHT MVC micro-framework
 * @author      Valentino Pesce 
 * @link        https://github.com/kenlog
 * @copyright   2019 (c) Valentino Pesce <valentino@iltuobrand.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$route->get('/', 'DocPHT\Controller\HomeController@index');

$route->group('/admin', function()
{
    // /admin/
    $this->get('/', 'DocPHT\Controller\AdminController@settings');

    // /admin/update-password
    $this->get('/update-password', 'DocPHT\Controller\AdminController@updatePassword');

    // /admin/remove-user
    $this->get('/remove-user', 'DocPHT\Controller\AdminController@removeUser');

    // /admin/add-user
    $this->get('/add-user', 'DocPHT\Controller\AdminController@addUser');

    // Anything else
    $this->any('/*', function(){
        pre("Page ( {$this->app->request->path} ) Not Found", 6);
    });
});

// Anything else
$route->any('/*', function(){
    pre("Page ( {$this->app->request->path} ) Not Found", 6);
});