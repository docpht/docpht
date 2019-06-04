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

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../lib/functions.php';
require __DIR__.'/../lib/Model.php';

    $db = new DocData;
    $docBuilder = new DocBuilder();

    $aPath = $_SESSION['update_path'];
    $id = $db->getId($aPath);
    $data = $db->getPageData($id);

    foreach ($data as $fields) {
        if ($fields['key'] == 'image' || $fields['key'] == 'codeFile') { (file_exists('data/' . $fields['v1'])) ? unlink('data/' . $fields['v1']) : NULL; }
    }


    (file_exists($db->getPhpPath($id))) ? unlink($db->getPhpPath($id)) : NULL;
    (file_exists($db->getJsonPath($id))) ? unlink($db->getJsonPath($id)) : NULL;

    if (isset($_SESSION['Active']) && isset($_SESSION['update_path'])) {
    $aPath = $_SESSION['update_path'];
        if ($_SESSION['update_path'] == 'data/doc-pht/home.php') {
            $zippedVersionPath = 'data/doc-pht/';
            $filePattern = 'home_*.zip';
        } else {
        	$zippedVersionPath = 'data' . substr(pathinfo($aPath, PATHINFO_DIRNAME ), 3) . '/';
            $filePattern = pathinfo($aPath, PATHINFO_FILENAME ) . '_*.zip';
        }
    }
    
    $dir = 'src/'.substr(pathinfo($aPath, PATHINFO_DIRNAME), 4);
    $indatadir = 'data/'.substr(pathinfo($aPath, PATHINFO_DIRNAME), 4);
    
    foreach (glob($zippedVersionPath . $filePattern) as $file) {
        (file_exists($file)) ? unlink($file) : NULL;
    }
    
    if (folderEmpty($dir)) {
        rmdir($dir);
    }
    
    if (folderEmpty($indatadir)) {
        rmdir($indatadir);
    }

    function folderEmpty($dir) {
        if (!is_readable($dir)) return NULL; 
        return (count(scandir($dir)) == 2);
    }
    
    
    if (!file_exists($aPath)) {
        $db->remove($id);
        header("Location: index.php");
    }
