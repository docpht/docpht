<?php declare(strict_types=1);

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

use Nette\Forms\Form;
use DocPHT\Core\Translator\T;

$db = new DocData;
$docBuilder = new DocBuilder();

$aPath = $_SESSION['update_path'];
$id = $db->getId($aPath);

if(isset($_GET['id'])) {
    $rowIndex = intval($_GET['id']);
}

if ($db->getPageData($id)[$rowIndex]['key'] == 'image' || $db->getPageData($id)[$rowIndex]['key'] == 'codeFile') { unlink('data/' . $db->getPageData($id)[$rowIndex]['v1']); }

$db->removePageData($id, $rowIndex);

if(isset($id)) {
    $docBuilder->buildPhpPage($id);
    header('location:index.php?p='.$db->getFilename($id).'&f='.$db->getTopic($id));
    exit;
} else {
    echo '<p class="text-center text-success">'.T::trans("Sorry something didn't work!").'</p>'; 
}