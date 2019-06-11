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
    include 'start/config.php';
} elseif (file_exists($autoload)) {
require $autoload;

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

require 'src/config/config.php';

Debugger::enable(Debugger::DEVELOPMENT); // IMPORTANT not to use in production

$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/src');
$loader->setTempDirectory(__DIR__ . '/temp');
$loader->register();

$app            = System\App::instance();
$app->request   = System\Request::instance();
$app->route     = System\Route::instance($app->request);

$route = $app->route;

include 'src/route.php';

$route->end();
} else {
    include 'start/composer.php';
}