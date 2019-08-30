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

class ModifySectionForm extends MakeupForm
{

    public function create()
    {
        $id = $_SESSION['page_id'];
        $uPath = $this->pageModel->getPhpPath($id);
        $languages = $this->doc->listCodeLanguages();
        $options = $this->doc->getOptions();

        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $page = $this->pageModel->getPageData($id);

        if(isset($_GET['id'])) {
            $rowIndex = $_GET['id'];
        }

        $form->addGroup(T::trans('Modify section'));
        
        if ($page[$rowIndex]['key'] != 'addButton') {
            
            $form->addSelect('options', T::trans('Options:'), $options)
            	->setPrompt(T::trans('Select an option'))
            	->setHtmlAttribute('data-live-search','true')
            	->setDefaultValue($page[$rowIndex]['key'])
            	->setRequired(T::trans('Select an option'));
            	
            
            $form->addSelect('language', T::trans('Language:'), $languages)
            	->setPrompt(T::trans('Select an option'))
            	->setHtmlAttribute('data-live-search','true')
            	->setRequired(T::trans('Select an option'));
            
            if ($page[$rowIndex]['key'] == 'codeInline' || $page[$rowIndex]['key'] == 'codeFile') {
                $form['language']->setDefaultValue($page[$rowIndex]['v2']); 
            } else {
                $form['language']->setDefaultValue('Markup');
            }
            
            $form->addUpload('file', 'File:')
                ->setRequired(false)
                ->addRule(Form::MIME_TYPE, 'File must be JPEG, PNG, GIF or Plain Text.', ['image/jpeg','image/gif','image/png','text/plain'])
        		->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 10 mb.', 10 * 1024 * 1024 /* size in MB */);
            	
            $form->addTextArea('option_content', T::trans('Option Content'))
                ->setHtmlAttribute('data-parent', 'options')
                ->setAttribute('data-autoresize'); 
            	
            if ($page[$rowIndex]['key'] == 'image') {
                $form['option_content']->setDefaultValue($page[$rowIndex]['v2']); 
            } else {
                $form['option_content']->setDefaultValue($page[$rowIndex]['v1']);
            }
            
            if ($page[$rowIndex]['key'] == 'imageURL' || $page[$rowIndex]['key'] == 'linkButton') { 
                $name = $page[$rowIndex]['v2']; 
            } else { 
                $name = ''; 
            }
            
            if ($page[$rowIndex]['key'] == 'linkButton') { 
                ($page[$rowIndex]['v3']) ? $trg = true : $trg = false;
            } else { 
                $trg = false; 
            }
                
                $form->addTextArea('names', T::trans('Name'))
                    ->setHtmlAttribute('data-parent', 'options'.$rowIndex)
                    ->setAttribute('data-autoresize')
                	->setDefaultValue($name);
                	
                $form->addCheckbox('trgs', T::trans('Open in New Window?'))
                    ->setHtmlAttribute('data-parent', 'options')
                    ->setAttribute('data-autoresize')
                	->setDefaultValue($trg);
        	
        } 

        $form->addProtection(T::trans('Security token has expired, please submit the form again'));
      
        $form->addSubmit('submit', T::trans('Modify'));

        if ($form->isSuccess()) {
            $values = $form->getValues();
            
            if ($page[$rowIndex]['key'] == 'image' || $page[$rowIndex]['key'] == 'codeFile' || $page[$rowIndex]['key'] == 'markdownFile') { unlink('data/' . $page[$rowIndex]['v1']); }
            $this->doc->removeOldFile($page[$rowIndex]['key'], $values['options'], 'data/' . $page[$rowIndex]['v1']);
        
        	if (!empty($values)) {
        	    
                $file = $values['file'];
                $file_path = $this->doc->upload($file, $this->pageModel->getPhpPath($id));
        		
        	    if(isset($id)) {
            	    $this->pageModel->modifyPageData($id, $rowIndex, $this->doc->valuesToArray($values, $file_path));
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