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

class InsertSectionForm extends MakeupForm
{

    public function create()
    {
        $id = $_SESSION['page_id'];
        $uPath = $this->pageModel->getPhpPath($id);
        $languages = $this->doc->listCodeLanguages();
        $options = $this->doc->getOptions();

        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        if(isset($_GET['id']) && isset($_GET['insert'])) {
            $rowIndex = $_GET['id'];
            $b_or_a = $_GET['insert'];
        }

        $form->addGroup(T::trans('Insert section'));
        
        $form->addSelect('options', T::trans('Options:'), $options)
        	->setPrompt(T::trans('Select an option'))
        	->setHtmlAttribute('data-live-search','true')
        	->setRequired(T::trans('Select an option'));
        	
        $form->addSelect('language', T::trans('Language:'), $languages)
            ->setPrompt(T::trans('Select an option'))
            ->setDefaultValue('Markup')
        	->setHtmlAttribute('data-live-search','true')
        	->setRequired(T::trans('Select an option'));
        
        $form->addUpload('file', 'File:')
            ->setRequired(false)
            ->addRule(Form::MIME_TYPE, 'File must be JPEG, PNG, GIF or Plain Text.', ['image/jpeg','image/gif','image/png','text/plain'])
        	->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 10 mb.', 10 * 1024 * 1024 /* size in MB */);
        	
        $form->addTextArea('option_content', T::trans('Option Content'))
        	->setHtmlAttribute('placeholder', T::trans('Enter content'))
        	->setHtmlAttribute('data-parent', 'options')
        	->setAttribute('data-autoresize'); 
        	
        $form->addTextArea('names', T::trans('Name'))
            ->setHtmlAttribute('data-parent', 'options')
            ->setAttribute('data-autoresize');
        
        $form->addCheckbox('trgs', T::trans('Open in New Window?'))
            ->setHtmlAttribute('data-parent', 'options')
            ->setAttribute('data-autoresize');

        $form->addProtection(T::trans('Security token has expired, please submit the form again'));
        
        $form->addSubmit('submit', T::trans('Insert'));

        if ($form->isSuccess()) {
            $values = $form->getValues();
            
        	if (isset($values['options']) && isset($values['option_content'])) {
        	    
                $file = $values['file'];
                $file_path = $this->doc->upload($file, $this->pageModel->getPhpPath($id));
        		
        	    if(isset($id)) {
            	    $this->pageModel->insertPageData($id, $rowIndex, $b_or_a, $this->doc->valuesToArray($values, $file_path));
            	    $this->doc->buildPhpPage($id);
                    header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        			exit;
        	    } else {
    				$this->msg->error(T::trans('Sorry something didn\'t work!'));
        	    }
        	}
        }
        return $form;
    }
}

