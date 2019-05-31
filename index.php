<?php ini_set('display_errors', 1);

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

$autoload = 'vendor/autoload.php';

if (file_exists($autoload)) {
require $autoload;
require 'src/config/config.php';

$app            = System\App::instance();
$app->request   = System\Request::instance();
$app->route     = System\Route::instance($app->request);

$route = $app->route;

include 'src/route.php';

$route->end();
} else {
    echo '<p>Install composer dependencies, run: <code style="background: #eee;padding: 5px;color: #9c3eb9;">composer install</code></p>';
}