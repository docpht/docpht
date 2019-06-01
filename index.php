<?php ini_set('display_errors', 1);

use Tracy\Debugger;

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

if (!file_exists('src/config/config.php')) {
    echo '<p>Set the configuration file in the config/ folder, delete the extension example, and set your data.</p>';
} elseif (file_exists($autoload)) {
require $autoload;
require 'src/config/config.php';

Debugger::enable(Debugger::DEVELOPMENT); // IMPORTANT not to use in production

$app            = System\App::instance();
$app->request   = System\Request::instance();
$app->route     = System\Route::instance($app->request);

$route = $app->route;

include 'src/route.php';

$route->end();
} else {
    echo '<p>Install composer dependencies, run: <code style="background: #eee;padding: 5px;color: #9c3eb9;">composer install</code></p>';
}