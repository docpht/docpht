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

use Latte\Engine;
use Nette\Forms\Form;
use Nette\Utils\Html;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;
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
        
        $form->addProtection(T::trans('Security token has expired, please submit the form again'));

        $form->addSubmit('submit',T::trans('Send me the email to reset'));
        
        if ($form->isSuccess()) {
            $values = $form->getValues();
            $userExists = $this->adminModel->userExists($values['email']);
			if (isset($values['email']) && $userExists == true) {

                    $token = $this->adminModel->createTimedToken('1');
                    $this->adminModel->addToken($values['email'],$token);

                    $latte = new \Latte\Engine;
                    $params = [
                        'BASE_URL' => BASE_URL,
                        'title' => 'Lost password',
                        'token' =>  $token,
                        'content' => 'to reset the password. The link will be valid for one hour.'
                    ]; 

                    $mail = new Message;
                    $mail->setFrom('no-reply@'.DOMAIN_NAME.'')
                        ->addTo($values['email'])
                        ->setSubject('Reset password '.DOMAIN_NAME.' ')
                        ->setHtmlBody($latte->renderToString('src/views/email/recovery_password.latte', $params));
                    if (SMTPMAILER == true) {
                        $mailer = new \Nette\Mail\SmtpMailer([
                            'host' => SMTPHOST,
                            'port' => SMTPPORT,
                            'username' => SMTPUSERNAME,
                            'password' => SMTPPASSWORD,
                            'secure' => SMTPENCRYPT,
                        ]);
                        $mailer->send($mail);
                    } else {
                        $mailer = new SendmailMailer;
                        $mailer->send($mail);
                    }
                    
                    $this->msg->success('Email successfully sent to '.$values['email'].'',BASE_URL);

			} elseif ($userExists == false) {
				$this->msg->error(T::trans('This email address does not exist!'),BASE_URL);
			}
		}
		
		return $form;
    }
}
