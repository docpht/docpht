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

class SortSectionForm extends MakeupForm
{

    public function create()
    {
        $id = $_SESSION['page_id'];
        $data = $this->pageModel->getPageData($id);
        
        if(isset($_GET['o']) && isset($_GET['n'])) {
            $rowIndex = intval($_GET['o']);
            $newIndex = intval($_GET['n']);
        }
        
        if (is_integer($newIndex) && $newIndex < count($data)) {
        
            $moveData = $data[$rowIndex];
            array_splice($data, $rowIndex, 1);
            array_splice($data, $newIndex, 0, array($moveData));
            $this->pageModel->putPageData($id, $data);
        
            if (!empty($data)) {
                $this->doc->buildPhpPage($id);
                header('location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        		exit;
            }
        } else {
            header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
            exit;
        }
    }
}