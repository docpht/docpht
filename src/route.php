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

$route->get('/', 'Instant\Controller\HomeController@index');

$route->group('/admin', function()
{
    // /admin/
    $this->get('/', 'Instant\Controller\AdminController@settings');

    // /admin/update-password
    $this->get('/update-password', 'Instant\Controller\AdminController@updatePassword');

    // /admin/remove-user
    $this->get('/remove-user', 'Instant\Controller\AdminController@removeUser');

    // /admin/add-user
    $this->get('/add-user', 'Instant\Controller\AdminController@addUser');

    // Anything else
    $this->any('/*', function(){
        pre("Page ( {$this->app->request->path} ) Not Found", 6);
    });
});

// Anything else
$route->any('/*', function(){
    pre("Page ( {$this->app->request->path} ) Not Found", 6);
});