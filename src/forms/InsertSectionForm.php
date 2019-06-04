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

$db = new DocData;
$docBuilder = new DocBuilder();

$aPath = $_SESSION['update_path'];

if(isset($_GET['id']) && isset($_GET['insert'])) {
    $rowIndex = $_GET['id'];
    $b_or_a = $_GET['insert'];
}

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

$form->addGroup(T::trans('Create new notes'));

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

$form->addSubmit('submit', T::trans('Add'));

$success = '';

if ($form->isSuccess()) {
    $values = $form->getValues();
    
	if (isset($values['options']) && isset($values['option_content'])) {
	    
	    $id = $db->getId($aPath);
	    
        $file = $values['file'];
        $file_path = $docBuilder->upload($file, $db->getPhpPath($id));
        
		$folder = substr(pathinfo($aPath, PATHINFO_DIRNAME ), 4);
		$filename = pathinfo($aPath, PATHINFO_FILENAME );
		
	    if(isset($id)) {
    	    $db->insertPageData($id, $rowIndex, $b_or_a, $docBuilder->valuesToArray($values, $file_path));
    	    $docBuilder->buildPhpPage($id);
            header('location:index.php?p='.$db->getFilename($id).'&f='.$db->getTopic($id));
			exit;
	    } else {
	        echo '<p class="text-center text-success">'.T::trans("Sorry something didn't work!").'</p>'; 
	    }
	}
}

echo '<div class="container-fluid"><div class="card"><div class="card-body">';
echo $form;
echo '</div></div></div>';