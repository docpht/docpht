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

class AddUserForm extends MakeupForm
{

    public function create()
    {
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $form->addGroup(T::trans('Add user'))
            ->setOption('description', T::trans('Enter a new username and password for the account.'));

        $form->addText('username', T::trans('Enter Username:'))
            ->setHtmlAttribute('placeholder', T::trans('Enter username'))
            ->setHtmlAttribute('autocomplete','off')
            ->setRequired(T::trans('Enter username'));
            
        $form->addPassword('password', T::trans('Enter password:'))
            ->setHtmlAttribute('placeholder', T::trans('Enter password'))
            ->setHtmlAttribute('autocomplete','off')
            ->setAttribute('onmousedown',"this.type='text'")
            ->setAttribute('onmouseup',"this.type='password'")
            ->setAttribute('onmousemove',"this.type='password'")
            ->setOption('description', Html::el('small')->setAttribute('class','text-muted')->setText(T::trans('Click on the asterisks to show the password')))
            ->addRule(Form::MIN_LENGTH, T::trans('The password must be at least 6 characters long'), 6)
            ->setRequired(T::trans('Enter password'));
            
        $form->addPassword('confirmpassword', T::trans('Confirm password:'))
            ->setHtmlAttribute('placeholder', T::trans('Confirm password'))
            ->setHtmlAttribute('autocomplete','off')
            ->setAttribute('onmousedown',"this.type='text'")
            ->setAttribute('onmouseup',"this.type='password'")
            ->setAttribute('onmousemove',"this.type='password'")
            ->setOption('description', Html::el('small')->setAttribute('class','text-muted')->setText(T::trans('Click on the asterisks to show the password')))
            ->addRule($form::EQUAL, T::trans('Passwords do not match!'), $form['password'])
            ->setRequired(T::trans('Confirm password'));

        $translations = json_decode(file_get_contents(realpath('src/translations/code-translations.json')), true);
        $form->addSelect('translations',T::trans('Language:'), $translations)
            ->setPrompt(T::trans('Select an option'))
            ->setHtmlAttribute('data-live-search','true')
            ->setRequired(T::trans('Select an option'));

        $form->addSubmit('submit',T::trans('Add new user'));

        if ($form->isSuccess()) {
            $values = $form->getValues();
            if (in_array($values['username'], $this->adminModel->getUsernames())) {
                $bad = T::trans('This username %username% is in use!', ['%username%' => $values['username']]);
                header('Location:'.BASE_URL.'admin/?bad='.utf8_encode(urlencode($bad)));
				exit;
            } elseif (isset($values['username']) && isset($values['password']) && $values['password'] == $values['confirmpassword']) {
                $this->adminModel->create($values);
                $this->msg->success(T::trans('User created successfully.'),BASE_URL.'admin');
            } else {
                $this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL.'admin');
            }
            $form->setValues([], TRUE);
        }

        $renderer = $form->getRenderer();
        $renderer->wrappers['pair']['.error'] = 'has-error';

        return $form;
    }
}
