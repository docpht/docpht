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

class UpdatePasswordForm extends MakeupForm
{
	public function create()
	{
		$users = json_decode(file_get_contents(realpath('src/config/users.json')), true);
		$usernames = [];

		foreach ($users as $user) { array_push($usernames,$user['Username']); }

		$key = array_search($_SESSION['Username'],$usernames);

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
			if (isset($_SESSION['Username']) && isset($values['newpassword']) && $values['newpassword'] == $values['confirmpassword'] && password_verify($values['oldpassword'], $users[$key]['Password'])) {
				$users[$key]['Password'] = password_hash($values['newpassword'], PASSWORD_DEFAULT);
				file_put_contents('src/config/users.json',json_encode($users));
				$good = 'User password updated successfully.';
				header('Location:'.BASE_URL.'admin/?good='.utf8_encode(urlencode($good)));
				exit;
			} else {
				/* $bad = 'The form was not sent!';
				header('Location:'.BASE_URL.'admin/?bad='.utf8_encode(urlencode($bad)));
				exit; */
				var_dump($values);
			}
		}
		
		return $form;
	}
}
