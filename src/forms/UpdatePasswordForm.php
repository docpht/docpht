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
		$form = new Form;
		$form->onRender[] = [$this, 'bootstrap4'];

		$form->addGroup('Personal data')
			->setOption('description', 'Test');

		$form->addText('name', 'Your name:')
			->setRequired('Enter your name');

		$form->addSubmit('submit', 'Send');

		$form->onSuccess[] = array($this, 'doSubmitForm');

		return $form;
	}
	
	public function doSubmitForm($form)
	{
		$values = $form->getValues();

		if ($form->isSuccess()) {
            # code...
		} else {
            # code...
		}
	}
}
