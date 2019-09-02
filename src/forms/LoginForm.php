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
 * 
 */

namespace DocPHT\Form;

use Nette\Forms\Form;
use Nette\Utils\Html;
use DocPHT\Core\Translator\T;
use DocPHT\Controller\LoginController;

class LoginForm extends MakeupForm
{

	public function create()
	{
		$form = new Form;
		$form->onRender[] = [$this, 'bootstrap4'];

		$form->addEmail('Username', T::trans('Email'))
			->setHtmlAttribute('placeholder', T::trans('Email'))
			->setRequired(T::trans('Enter email'));
            
		$form->addPassword('Password', T::trans('Password'))
		    ->setHtmlAttribute('placeholder', T::trans('Password'))
		    ->setHtmlAttribute('autocomplete','off')
		    ->setRequired(T::trans('Enter password'));
        
        $form->addProtection(T::trans('Security token has expired, please submit the form again'));

		$form->addSubmit('submit',T::trans('Login'));

		if ($form->isSuccess()) {
		    $values = $form->getValues();

		    $login = new LoginController();
		    $validateLogin = $login->checkLogin($values['Username'],$values['Password']);

		    if ($validateLogin === true) {
			    header("Location:".BASE_URL);
			    exit;
		    } else {
			    $this->msg->error(T::trans('Warning! The data entered is incorrect.'),BASE_URL.'login');
		    }
		}
		
		return $form;
	}
}
