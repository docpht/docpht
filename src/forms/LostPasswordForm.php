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
use Nette\Mail\Message;
use DocPHT\Core\Translator\T;
use Nette\Mail\SendmailMailer;

class LostPasswordForm extends MakeupForm
{
    public function sendEmail()
    {
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $form->addGroup(T::trans('Lost password'));

        $form->addEmail('email', 'Email:') 
            ->setHtmlAttribute('placeholder', 'Email')
            ->setRequired('Required');

        $form->addSubmit('submit',T::trans('Send me the email to reset the password'));
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
        
			if (isset($values['email'])) {
                $userExists = $this->adminModel->userExists($values['email']);
                if ($userExists == 1) {
                    $temporaryPassword = $this->adminModel->randomPassword();
                    $this->adminModel->updatePassword($values['email'], $temporaryPassword);
                    
                    $mail = new Message;
                    $mail->setFrom('no-reply@'.DOMAIN_NAME.'')
                        ->addReplyTo(ADMIN)
                        ->addBcc($values['email'])
                        ->setSubject('Reset password '.DOMAIN_NAME.' ')
                        ->setHtmlBody('Use this temporary password ('.$temporaryPassword.'), <a href="'.BASE_URL.'login">log in</a> and update your password.'); 
                    $mailer = new SendmailMailer;
                    $mailer->send($mail);
                    
                    $this->msg->success('Email successfully sent to '.$values['email'].'',BASE_URL);
                }
			} else {
				$this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL);
			}
		}
		
		return $form;
    }
}
