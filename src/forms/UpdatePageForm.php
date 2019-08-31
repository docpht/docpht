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

class UpdatePageForm extends MakeupForm
{

    public function create()
    {

        $id = $_SESSION['page_id'];
        $languages = $this->doc->listCodeLanguages();
        $options = $this->doc->getOptions();

        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $page = $this->pageModel->getPageData($id);

        $index = 0;
        
        $form->addGroup(T::trans('Update page'));
        
        foreach ($page as $fields) {
            
                $form->addSelect('options'.$index, T::trans('Options:'), $options)
                	->setPrompt(T::trans('Select an option'))
                	->setHtmlAttribute('data-live-search','true')
                	->setDefaultValue($fields['key'])
                	->setRequired(T::trans('Select an option'));
                	
                if ($fields['key'] == 'codeInline' || $fields['key'] == 'codeFile') { 
                    $lang = $fields['v2']; 
                } else { 
                    $lang = 'Markup'; 
                }
                
                $form->addSelect('language'.$index, T::trans('Language:'), $languages)
                	->setPrompt(T::trans('Select an option'))
                	->setHtmlAttribute('data-live-search','true')
                	->setDefaultValue($lang)
                	->setRequired(T::trans('Select an option'));
                
                $form->addUpload('file'.$index, 'File:')
                    ->setRequired(false)
                    ->addRule(Form::MIME_TYPE, 'File must be JPEG, PNG, GIF or Plain Text.', ['image/jpeg','image/gif','image/png','text/plain'])
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 10 mb.', 10 * 1024 * 1024 /* size in MB */);
                	
                if (isset($fields['v1']) && $fields['key'] != 'image') { $oc = $fields['v1']; } else { $oc = $fields['v2']; }
                
                $form->addTextArea('option_content'.$index, T::trans('Option Content'))
                    ->setHtmlAttribute('data-parent', 'options'.$index)
                    ->setAttribute('data-autoresize')
                	->setDefaultValue($oc); 
                	
                if ($fields['key'] == 'image') {
                    $form['option_content'.$index]->setDefaultValue($fields['v2']); 
                } else {
                    $form['option_content'.$index]->setDefaultValue($fields['v1']);
                }
                
                if ($fields['key'] == 'imageURL' || $fields['key'] == 'linkButton') { 
                    $name = $fields['v2']; 
                } else { 
                    $name = $fields['v1']; 
                }
                
                if ($fields['key'] == 'linkButton') { 
                    ($fields['v3']) ? $trg = true : $trg = false; 
                } else { 
                    $trg = false; 
                }
            
                $form->addTextArea('names'.$index, T::trans('Name'))
                    ->setHtmlAttribute('data-parent', 'options'.$index)
                    ->setAttribute('data-autoresize')
                	->setDefaultValue($name);
                	
                $form->addCheckbox('trgs'.$index, T::trans('Open in New Window?'))
                    ->setHtmlAttribute('data-parent', 'options'.$index)
                    ->setAttribute('data-autoresize')
                	->setDefaultValue($trg);
            
        $index++;
        	
        }
        
        $form->addProtection(T::trans('Security token has expired, please submit the form again'));
      
        $form->addSubmit('submit', T::trans('Update'));
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
            
            for ($x=0; $x < $index; $x++) {
                
                $mapped = array(
                            'options'       => (isset($values['options'.$x])) ? $values['options'.$x] : '',
                            'option_content'=> (isset($values['option_content'.$x])) ? $values['option_content'.$x] : '',
                            'language'      => (isset($values['language'.$x])) ? $values['language'.$x] : '',
                            'names'         => (isset($values['names'.$x])) ? $values['names'.$x] : '',
                            'trgs'          => (isset($values['trgs'.$x])) ? $values['trgs'.$x] : '',
                            'file'          => ($values['file'.$x]->hasFile()) ? $values['file'.$x] : $page[$x]['v1']
                            );
            
                
                if (($page[$x]['key'] == 'image' || $page[$x]['key'] == 'codeFile' || $page[$x]['key'] == 'markdownFile') && $values['file'.$x]->hasFile()) { unlink('data/' . $page[$x]['v1']); }
                
                if(($mapped['options'] == 'image' || $mapped['options'] == 'codeFile' || $mapped['options'] == 'markdownFile') && $values['file'.$x]->hasFile()) {
                    $file = $mapped['file'];
                    $file_path = $this->doc->upload($file, $this->pageModel->getPhpPath($id));
                } else {
                    unset($mapped['file']);
                    $file_path = ($mapped['options'] != 'addButton') ? 'data/'.$page[$x]['v1'] : '';
                }
                
                if (isset($page[$x]['v1'])) {
                    $this->doc->removeOldFile($page[$x]['key'], $mapped['options'], 'data/' . $page[$x]['v1']);
                }
        
            	    if(isset($id)) {
                	    $this->pageModel->modifyPageData($id, $x, $this->doc->valuesToArray($mapped, $file_path));
                	    $this->doc->buildPhpPage($id);
            	    }
            }
            header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
            exit;
        } elseif (!isset($id)) {
            $this->msg->error(T::trans('Sorry something didn\'t work!'));
        }

        return $form;
    }
}