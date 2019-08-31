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

class CreatePageForm extends MakeupForm
{
    

    public function create()
    {
        
        $languages = $this->doc->listCodeLanguages();
        $options = $this->doc->getOptions();

        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $form->addGroup(T::trans('Create new page'));

        $getTopic = $this->pageModel->getUniqTopics();

        $form->addText('topic', T::trans('Topic'))
        	->setHtmlAttribute('placeholder', T::trans('Enter topic'))
            ->setAttribute('list', 'topicList')
            ->setAttribute('autocomplete', 'off')
            ->setRequired(T::trans('Enter topic'));
        	
        $dataList = Html::el('datalist id="topicList"');
        
        if (is_array($getTopic)) {
            foreach ($getTopic as $value) {
                $dataList->create('option value="'.str_replace('-',' ',$value).'"');
            }
            echo $dataList;
        }
        
        $form->addText('description', T::trans('Description'))
        	->setHtmlAttribute('placeholder', T::trans('Enter description'))
        	->setRequired(T::trans('Enter description'));
        	
        $form->addText('mainfilename', T::trans('Page name'))
        	->setHtmlAttribute('placeholder', T::trans('Enter page name'))
            ->setRequired(T::trans('Enter page name'));
        
        $form->addSelect('options',T::trans('Options:'), $options)
        	->setPrompt(T::trans('Select an option'))
        	->setHtmlAttribute('data-live-search','true')
        	->setRequired(T::trans('Select an option'));
        	
        $form->addSelect('language', T::trans('Language:'), $languages)
        	->setPrompt(T::trans('Select an option'))
        	->setDefaultValue('Markup')
        	->setHtmlAttribute('data-live-search','true');
        
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
        
        $form->addSubmit('submit', T::trans('Create'));
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
        
        	if (isset($values['topic']) && isset($values['mainfilename'])) {
                
                $id = $this->pageModel->create($values['topic'],$values['mainfilename']);
                
        	    if(isset($id)) {
            	    $this->pageModel->addPageData($id, $this->doc->valuesToArray(array('options' => 'title', 'option_content' => $values['mainfilename'])));
            	    $this->pageModel->addPageData($id, $this->doc->valuesToArray(array('options' => 'description', 'option_content' => $values['description'])));
            	    $file = $values['file'];
                    $file_path = $this->doc->upload($file, $this->pageModel->getPhpPath($id));
            	    $this->pageModel->addPageData($id, $this->doc->valuesToArray($values, $file_path));
            	    
            	    $this->doc->buildPhpPage($id);
        
                    header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
        			exit;
        	    } else {
                    $this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL.'page/create');
        	    }
        	}
        }
        return $form;
    }
}

