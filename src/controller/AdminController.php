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

namespace DocPHT\Controller;

use Instant\Core\Controller\BaseController;

class AdminController extends BaseController
{

	public function settings()
	{
		$newAppVersion = $this->newAppVersion->check();
		$this->view->load('Admin','admin/settings.php', ['newAppVersion' => $newAppVersion]);
	}

	public function updatePassword()
	{
		$form = $this->updatePasswordForm->create();
		$this->view->load('Update Password','admin/update_password.php', ['form' => $form]);
	}

	public function updateEmail()
	{
		$form = $this->updateEmailForm->create();
		$this->view->load('Update Email','admin/update_email.php', ['form' => $form]);
	}

	public function removeUser()
	{
		$form = $this->removeUserForm->create();
		$this->view->load('Remove User','admin/remove_user.php', ['form' => $form]);
	}
		
	public function addUser()
	{
		$form = $this->addUserForm->create();
		$this->view->load('Add user','admin/add_user.php', ['form' => $form]);
	}

	public function backup()
	{
		$this->view->load('Backups','admin/backups.php');
	}

	public function saveBackup()
	{
		$form = $this->backupsForms->save();
	}

	public function restoreOptions()
	{
		$form = $this->backupsForms->restoreOptions();
		$this->view->load('Restore options','admin/restore_options.php', ['form' => $form]);

	}

	public function importBackup()
	{
		$form = $this->backupsForms->import();
		$this->view->load('Import a backup','admin/import_backup.php', ['form' => $form]);
	}

	public function exportBackup()
	{
		$form = $this->backupsForms->export();
	}

	public function deleteBackup()
	{
		$form = $this->backupsForms->delete();
	}

	public function translations()
	{
		$form = $this->translationsForm->create();
		$this->view->load('Translations','admin/translations.php', ['form' => $form]);
	}

	public function uploadLogo()
	{
		$logoForm = $this->uploadlogo->logo();
		$favForm = $this->uploadlogo->favicon();
		
		$this->view->load('Add logo','admin/upload_logo.php', [
			'logoForm' => $logoForm,
			'favForm' =>  $favForm
		]);
	}

	public function removeLogo()
	{
		unlink('data/logo.png');
		header('Location:'.BASE_URL.'admin');
		exit;
	}

	public function removeFav()
	{
		unlink('data/favicon.png');
		header('Location:'.BASE_URL.'admin');
		exit;
	}

	public function lastLogin()
	{
		$userList = $this->accessLogModel->getUserList();
		$this->view->load('Last logins','admin/last_login.php', ['userList' => $userList]);
	}

}
