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

class UpdateEmailForm extends MakeupForm
{

	public function create()
	{
		$form = new Form;
		$form->onRender[] = [$this, 'bootstrap4'];

		$form->addGroup(T::trans('Update email'));

		$form->addEmail('newemail', T::trans('New email:'))
			->setHtmlAttribute('placeholder', T::trans('Enter new email'))
			->setRequired(T::trans('Enter new email'));
			
		$form->addProtection(T::trans('Security token has expired, please submit the form again'));
		
		$form->addSubmit('submit',T::trans('Update email'));

		if ($form->isSuccess()) {
            $values = $form->getValues();
			if (in_array($values['newemail'], $this->adminModel->getUsernames())) {
				$this->msg->error(T::trans('This email %newemail% is in use!', ['%newemail%' => $values['newemail']]),BASE_URL.'admin');
            } elseif (isset($_SESSION['Username']) && isset($values['newemail'])) {
				$this->adminModel->updateEmail($_SESSION['Username'], $values['newemail']);
				$this->msg->success(T::trans('Email updated successfully.'),BASE_URL.'admin');
			} else {
				$this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL.'admin');
			}
		}
		
		return $form;
	}
}
