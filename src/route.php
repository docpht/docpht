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

/* // /hello
$route->get('/hello', 'Instant\Controller\HelloWorldController@index');

$route->group('/admin', function()
{
    // /admin/
    $this->get('/', 'Instant\Controller\AdminController@admin');

    // /admin/settings
    $this->get('/settings', 'Instant\Controller\AdminController@settings');

    // Nested group
    $this->group('/users', function()
    {
        // /admin/users
        $this->get('/', 'Instant\Controller\AdminController@users');

        // /admin/users/add
        $this->get('/add', 'Instant\Controller\AdminController@addUser');
    });

    // Anything else
    $this->any('/*', function(){
        pre("Page ( {$this->app->request->path} ) Not Found", 6);
    });
});

// /person
$route->get('/person', 'Instant\Controller\PersonController@getJsonPerson');

$route->get('pages/{title}?',
function($title){
    if($title){
        $page = new PageController();
        $page->getPage($title);
    }else{
        $page = new PageController();
        $page->getListPages('pages');
    }
}); */

// Anything else
$route->any('/*', function(){
    pre("Page ( {$this->app->request->path} ) Not Found", 6);
});