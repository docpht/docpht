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

namespace DocPHT\Form;

use Nette\Forms\Form;
use Nette\Utils\Html;
use DocPHT\Core\Translator\T;

class DeletePageForm extends MakeupForm
{

    public function delete()
    {
        $id = $_SESSION['page_id'];
        $uPath = $this->pageModel->getPhpPath($id);
        $data = $this->pageModel->getPageData($id);
    
        foreach ($data as $fields) {
            if ($fields['key'] == 'image' || $fields['key'] == 'codeFile' || $fields['key'] == 'markdownFile') { (file_exists('data/' . $fields['v1'])) ? unlink('data/' . $fields['v1']) : NULL; }
        }
    
    
        (file_exists($this->pageModel->getPhpPath($id))) ? unlink($this->pageModel->getPhpPath($id)) : NULL;
        (file_exists($this->pageModel->getJsonPath($id))) ? unlink($this->pageModel->getJsonPath($id)) : NULL;
    
        if (isset($_SESSION['Active']) && isset($_SESSION['page_id'])) {
            if ($uPath == 'data/doc-pht/home.php') {
                $zippedVersionPath = 'data/doc-pht/';
                $filePattern = 'home_*.zip';
            } else {
            	$zippedVersionPath = 'data/' . substr(pathinfo($uPath, PATHINFO_DIRNAME ), 6) . '/';
                $filePattern = pathinfo($uPath, PATHINFO_FILENAME ) . '_*.zip';
            }
        }
        
        $dir = 'pages/'.substr(pathinfo($uPath, PATHINFO_DIRNAME), 6);
        $indatadir = 'data/'.substr(pathinfo($uPath, PATHINFO_DIRNAME), 6);
        
        foreach (glob($zippedVersionPath . $filePattern) as $file) {
            (file_exists($file)) ? unlink($file) : NULL;
        }
        
        if ($this->folderEmpty($dir)) {
            rmdir($dir);
        }
        
        if ($this->folderEmpty($indatadir)) {
            rmdir($indatadir);
        }
        
        if (!file_exists($uPath)) {
            $this->pageModel->remove($id);
            header("Location: " . BASE_URL);
        }
    }

    function folderEmpty($dir) {
        if (!is_readable($dir)) return NULL; 
        return (count(scandir($dir)) == 2);
    }

}
