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
use DocPHT\Model\AdminModel;

class UpdatePasswordForm extends MakeupForm
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

		$form->addGroup('Update Password for: ' . $_SESSION['Username'])
			->setOption('description', 'Enter a new password for the account.');

		$form->addPassword('oldpassword', 'Confirm current password:')
			->setHtmlAttribute('placeholder', 'Enter current password')
			->setHtmlAttribute('autocomplete','off')
			->setAttribute('onmousedown',"this.type='text'")
			->setAttribute('onmouseup',"this.type='password'")
			->setAttribute('onmousemove',"this.type='password'")
			->setOption('description', Html::el('small')->setAttribute('class','text-muted')->setText('Click on the asterisks to show the password'))
			->setRequired('Enter password');
			
		$form->addPassword('newpassword', 'Enter new password:')
			->setHtmlAttribute('placeholder', 'Enter new password')
			->setHtmlAttribute('autocomplete','off')
			->setAttribute('onmousedown',"this.type='text'")
			->setAttribute('onmouseup',"this.type='password'")
			->setAttribute('onmousemove',"this.type='password'")
			->setOption('description', Html::el('small')->setAttribute('class','text-muted')->setText('Click on the asterisks to show the password'))
			->addRule(Form::MIN_LENGTH, 'The password must be at least 6 characters long', 6)
			->setRequired('Confirm password');
			
		$form->addPassword('confirmpassword', 'Confirm new password:')
			->setHtmlAttribute('placeholder', 'Confirm password')
			->setHtmlAttribute('autocomplete','off')
			->setAttribute('onmousedown',"this.type='text'")
			->setAttribute('onmouseup',"this.type='password'")
			->setAttribute('onmousemove',"this.type='password'")
			->setOption('description', Html::el('small')->setAttribute('class','text-muted')->setText('Click on the asterisks to show the password'))
			->addRule($form::EQUAL, 'Passwords do not match!', $form['newpassword'])
			->setRequired('Confirm password');

		$form->addSubmit('submit','Update user password');

		if ($form->isSuccess()) {
			$values = $form->getValues();
			if (isset($_SESSION['Username']) && isset($values['newpassword']) && $values['newpassword'] == $values['confirmpassword'] && $this->adminModel->verifyPassword($_SESSION['Username'], $values['oldpassword'])) {
				$this->adminModel->updatePassword($_SESSION['Username'], $values['newpassword']);
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
