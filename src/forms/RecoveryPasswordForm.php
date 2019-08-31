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

class RecoveryPasswordForm extends MakeupForm
{

	public function create($token)
	{
		$form = new Form;
		$form->onRender[] = [$this, 'bootstrap4'];

		$form->addGroup(T::trans('Recovery Password: '))
			->setOption('description', T::trans('Enter a new password for the account.'));
			
		$form->addPassword('newpassword', T::trans('Enter new password:'))
			->setHtmlAttribute('placeholder', T::trans('Enter new password'))
			->setHtmlAttribute('autocomplete','off')
			->setAttribute('onmousedown',"this.type='text'")
			->setAttribute('onmouseup',"this.type='password'")
			->setAttribute('onmousemove',"this.type='password'")
			->setOption('description', Html::el('small')->setAttribute('class','text-muted')->setText(T::trans('Click on the asterisks to show the password')))
			->addRule(Form::MIN_LENGTH, T::trans('The password must be at least 6 characters long'), 6)
			->setRequired(T::trans('Confirm password'));
			
		$form->addPassword('confirmpassword', T::trans('Confirm new password:'))
			->setHtmlAttribute('placeholder', T::trans('Confirm password'))
			->setHtmlAttribute('autocomplete','off')
			->setAttribute('onmousedown',"this.type='text'")
			->setAttribute('onmouseup',"this.type='password'")
			->setAttribute('onmousemove',"this.type='password'")
			->setOption('description', Html::el('small')->setAttribute('class','text-muted')->setText(T::trans('Click on the asterisks to show the password')))
			->addRule($form::EQUAL, T::trans('Passwords do not match!'), $form['newpassword'])
			->setRequired(T::trans('Confirm password'));

		$form->addProtection(T::trans('Security token has expired, please submit the form again'));
		
		$form->addSubmit('submit',T::trans('Update user password'));

        $username = $this->adminModel->getUsernameFromToken($token);
        $tokenFromUsername = $this->adminModel->getTokenFromUsername($username);
        parse_str($token, $get);
        $expiry = $get['expiry'];

        if ($token != $tokenFromUsername) {
            $this->msg->error(T::trans('Invalid link!'),BASE_URL);
        } else {
                $currentTime = time();
                if ($expiry <= $currentTime) {
                    $this->msg->error(T::trans('Link expired!'),BASE_URL);
                } elseif ($form->isSuccess()) {
                    $values = $form->getValues();
                    
                if (isset($values['newpassword']) && $values['newpassword'] == $values['confirmpassword']) {
                        $this->adminModel->updatePassword($username, $values['newpassword']);
                        $this->msg->success(T::trans('User password updated successfully.'),BASE_URL);
                } else {
                        $this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL);
                    }
                } 
            } 

		return $form;
	}
}
