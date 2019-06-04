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
use DocPHT\Model\AdminModel;

class RemoveUserForm extends MakeupForm
{

	private $adminModel;
    
	public function __construct()
	{
		$this->adminModel = new AdminModel();
	}

	public function create()
	{
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $form->addGroup(T::trans('Remove a user'))
        	->setOption('description', T::trans('Select username for removal.'));
        
        $form->addSelect('user',T::trans('Remove a user:'), $this->adminModel->getUsernames())
        	->setPrompt(T::trans('Select a user'))
        	->setHtmlAttribute('data-live-search','true')
        	->setRequired(T::trans('Select a user'));
        
        $form->addSubmit('submit', T::trans('Remove user'))->setAttribute('onclick','return confirmationRemoval()');
        
        $success = '';
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
            if (isset($values['user'])) {
                $this->adminModel->removeUser($values['user']);
				$good = T::trans('User password updated successfully.');
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
