<?php ini_set('display_errors', 1);

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

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__ . DS);
$baseUrl = (isset($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"] : "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"];
define('BASE_URL',$baseUrl);

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