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

$jsonArray = $db->getPageData($id);

$index = 0;

function makeBootstrap4(Form $form)
{
	$renderer = $form->getRenderer();
	$renderer->wrappers['controls']['container'] = null;
	$renderer->wrappers['pair']['container'] = 'div class="form-group"';
	$renderer->wrappers['pair']['.error'] = 'has-danger';
	$renderer->wrappers['control']['container'] = 'div class=col';
	$renderer->wrappers['label']['container'] = 'div class="col col-form-label font-weight-bold"';
	$renderer->wrappers['control']['description'] = 'span class=form-text';
	$renderer->wrappers['control']['errorcontainer'] = 'span class=form-error';

	foreach ($form->getControls() as $control) {
		$type = $control->getOption('type');
		if ($type === 'button') {
			$control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-secondary btn-block' : 'btn btn-primary');
			$usedPrimary = true;

		} elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
			$control->getControlPrototype()->addClass('form-control selectpicker');

		} elseif ($type === 'file') {
			$control->getControlPrototype()->addClass('form-control-file');

		} elseif (in_array($type, ['checkbox', 'radio'], true)) {
			if ($control instanceof Nette\Forms\Controls\Checkbox) {
				$control->getLabelPrototype()->addClass('form-check-label');
			} else {
				$control->getItemLabelPrototype()->addClass('form-check-label');
			}
			$control->getControlPrototype()->addClass('form-check-input');
			$control->getSeparatorPrototype()->setName('div')->addClass('form-check');
		}
	}
}

$languages = json_decode(file_get_contents(realpath('data/doc-pht/code-array.json')), true);

$form = new Form;
$form->onRender[] = 'makeBootstrap4';

$form->addGroup(T::trans('Update the current page'));

$options = [
    'title' => T::trans('Add title'),
    'description' => T::trans('Add description'),
	'pathAdd'  => T::trans('Add path'),
	'codeInline' => T::trans('Add code inline'),
	'codeFile' => T::trans('Add code from file'),
	'blockquote' => T::trans('Add blockquote'),
	'image' => T::trans('Add image from file'),
	'imageURL' => T::trans('Add image from url'),
	'markdown' => T::trans('Add markdown'),
	'linkButton' => T::trans('Add link button')
];

foreach ($jsonArray as $fields) {
    
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

$success = '';

if ($form->isSuccess()) {
    $values = $form->getValues();
    
    for ($x=0; $x < $index; $x++) {
        
        $mapped = array(
                    'options'       => (isset($values['options'.$x])) ? $values['options'.$x] : '',
                    'option_content'=> (isset($values['option_content'.$x])) ? $values['option_content'.$x] : '',
                    'language'      => (isset($values['language'.$x])) ? $values['language'.$x] : '',
                    'names'         => (isset($values['names'.$x])) ? $values['names'.$x] : '',
                    'trgs'          => (isset($values['trgs'.$x])) ? $values['trgs'.$x] : '',
                    'file'          => ($values['file'.$x]->hasFile()) ? $values['file'.$x] : $jsonArray[$x]['v1']
                    );
    
        
        if (($jsonArray[$x]['key'] == 'image' || $jsonArray[$x]['key'] == 'codeFile') && $values['file'.$x]->hasFile()) { unlink('data/' . $jsonArray[$x]['v1']); }
        
        if(($mapped['options'] == 'image' || $mapped['options'] == 'codeFile') && $values['file'.$x]->hasFile()) {
            $file = $mapped['file'];
            $file_path = $docBuilder->upload($file, $db->getPhpPath($id));
        } else {
            unset($mapped['file']);
            $file_path = ($mapped['options'] != 'addButton') ? 'data/'.$jsonArray[$x]['v1'] : '';
        }
        
        if (isset($jsonArray[$x]['v1'])) {
            $docBuilder->removeOldFile($jsonArray[$x]['key'], $mapped['options'], 'data/' . $jsonArray[$x]['v1']);
        }
    
    		$folder = substr(pathinfo($aPath, PATHINFO_DIRNAME ), 4);
    		$filename = pathinfo($aPath, PATHINFO_FILENAME );
    		
    	    if(isset($id)) {
        	    $db->modifyPageData($id, $x, $docBuilder->valuesToArray($mapped, $file_path));
        	    $docBuilder->buildPhpPage($id);
    	    }
    }
    header('location:index.php?p='.$db->getFilename($id).'&f='.$db->getTopic($id));
    exit;
} 

echo '<div class="container-fluid"><div class="card"><div class="card-body">';
echo $form;
echo '</div></div></div>';