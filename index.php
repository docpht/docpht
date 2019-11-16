<?php // ini_set('display_errors', 1); // IMPORTANT not to use in production

use Tracy\Debugger;
use DocPHT\Core\Session\Session;

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

$constants = 'src/core/constants.php';

$configurationFile = 'src/config/config.php';

$installFolder = 'install';

if (file_exists($configurationFile) && file_exists($installFolder)) {
    $files = glob($installFolder.'/partial/*');
    foreach($files as $file){
        if(is_file($file)) {
            unlink($file);
        }
        if (is_dir_empty($installFolder.'/partial')) 
         rmdir($installFolder.'/partial');
    }
    $files = glob($installFolder.'/*');
    foreach($files as $file){
        if(is_file($file)) {
            unlink($file);
        }
        if (is_dir_empty($installFolder)) 
         rmdir($installFolder);
    }
    if (file_exists($installFolder.'/partial') && file_exists($installFolder)) {
        include 'install/error.php';
    } else {
        require $configurationFile;
        header('Location:'.BASE_URL.'login');
    }
} elseif (!file_exists($configurationFile) && !file_exists($installFolder)) {
    mkdir($installFolder, 0755, true);
    mkdir($installFolder.'/partial', 0755, true);
    $files = glob('temp/install/partial/*');
    foreach($files as $file){
        if(is_file($file)) {
            error_log($file,0);
            copy($file, $installFolder . "/partial/" . pathinfo($file,PATHINFO_BASENAME));
        }
    }
    $files = glob('temp/install/*');
    foreach($files as $file){
        if(is_file($file)) {
            copy($file, $installFolder . "/" . pathinfo($file,PATHINFO_BASENAME));
        }
    }    
    include 'install/config.php';
} elseif (!file_exists($configurationFile)) {
    include 'install/config.php';
} elseif (file_exists($autoload)) {
require $autoload;

$session = new Session();
$session->sessionExpiration();
$session->preventStealingSession();

require $constants;
require $configurationFile;

// Debugger::enable(Debugger::DEVELOPMENT); // IMPORTANT not to use in production

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
}

function is_dir_empty($dir) 
{
    if (!is_readable($dir)) return NULL; 
    return (count(scandir($dir)) == 2);
}
