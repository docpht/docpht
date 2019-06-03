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

class RemoveUserForm extends MakeupForm
{
	public function create($adminModel)
	{
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $form->addGroup('Remove a user')
        	->setOption('description', 'Select username for removal.');
        
        $form->addSelect('user','Remove a user:', $adminModel->getUsernames())
        	->setPrompt('Select a user')
        	->setHtmlAttribute('data-live-search','true')
        	->setRequired('Select a user');
        	
        $form->addProtection('Security token has expired, please submit the form again');
        
        
        $form->addSubmit('submit', 'Remove user')->setAttribute('onclick','return confirmationRemoval()');
        
        $success = '';
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
            if (isset($values['user'])) {
                $adminModel->removeUser($values['user']);
				$good = 'User password updated successfully.';
				header('Location:'.BASE_URL.'admin/?good='.utf8_encode(urlencode($good)));
				exit;
            } else {
				$bad = 'Sorry something didn\'t work!';
				header('Location:'.BASE_URL.'admin/?bad='.utf8_encode(urlencode($bad)));
				exit;
            }
            
        }
		return $form;
	}
}
