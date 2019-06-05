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

use DocPHT\Core\Translator\T;
use Nette\Forms\Form;
use Nette\Utils\Html;

class TranslationsForm extends MakeupForm
{

	public function create()
	{
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $form->addGroup(T::trans('Update translations for: ') . $_SESSION['Username']);
            
        $translations = json_decode(file_get_contents(realpath('src/translations/code-translations.json')), true);
        $form->addSelect('translations',T::trans('Language:'), $translations)
        	->setPrompt(T::trans('Select an option'))
        	->setHtmlAttribute('data-live-search','true')
        	->setDefaultValue($this->adminModel->getUserTrans($_SESSION['Username']))
        	->setRequired(T::trans('Select an option'));
            error_log($this->adminModel->getUserTrans($_SESSION['Username']),0);
        
        $form->addSubmit('submit', T::trans('Update user translation'));
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
            if (isset($_SESSION['Username']) && isset($values['translations'])) {
                $this->adminModel->updateTrans($_SESSION['Username'], $values['translations']);
				$good = T::trans('Successful language change.');
				header('Location:'.BASE_URL.'admin/?good='.utf8_encode(urlencode($good)));
				exit;
            } else {
				$bad = T::trans('Sorry something didn\'t work!');
				header('Location:'.BASE_URL.'admin/?bad='.utf8_encode(urlencode($bad)));
				exit;
            }
            
        }        
		return $form;
	}
}
