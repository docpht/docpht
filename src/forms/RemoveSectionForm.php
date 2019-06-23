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

class RemoveSectionForm extends MakeupForm
{

    public function create()
    {

        $id = $_SESSION['page_id'];
        
        if(isset($_GET['id'])) {
            $rowIndex = intval($_GET['id']);
        }
        
        if ($this->pageModel->getPageData($id)[$rowIndex]['key'] == 'image' || $this->pageModel->getPageData($id)[$rowIndex]['key'] == 'codeFile' || $this->pageModel->getPageData($id)[$rowIndex]['key'] == 'markdownFile') { 
            unlink('data/' . $this->pageModel->getPageData($id)[$rowIndex]['v1']); 
        } 
        
        $this->pageModel->removePageData($id, $rowIndex);
        
        if(isset($id)) {
            $this->doc->buildPhpPage($id);
            header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
            exit;
        } else {
    		$this->msg->error(T::trans('Sorry something didn\'t work!'));
        }
    }
}