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


use DocPHT\Core\Translator\T;
use Instant\Core\Controller\BaseController;


class AdminController extends BaseController
{

	public function settings()
	{
		$this->view->show('partial/head.php',['PageTitle' => T::trans('Admin')]);
		$this->view->show('admin/settings.php');
		$this->view->show('partial/footer.php');
	}

	public function updatePassword()
	{
		$form = $this->updatePasswordForm->create();
		
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Update Password')]);
		$this->view->show('admin/update_password.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

	public function updateEmail()
	{
		$form = $this->updateEmailForm->create();
		
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Update Email')]);
		$this->view->show('admin/update_email.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

	public function removeUser()
	{
		$form = $this->removeUserForm->create();
		
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Remove User')]);
		$this->view->show('admin/remove_user.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}
		
	public function addUser()
	{
		$form = $this->addUserForm->create();

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Add user')]);
		$this->view->show('admin/add_user.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

	public function createHome()
	{
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Create Home')]);
		$this->view->show('admin/create_home.php');
		$this->view->show('partial/footer.php');
	}

	public function backup()
	{
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Backups')]);
		$this->view->show('admin/backups.php');
		$this->view->show('partial/footer.php');
	}

	public function saveBackup()
	{
		$form = $this->backupsForms->save();
	}

	public function restoreOptions()
	{
		$form = $this->backupsForms->restoreOptions();
		
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Restore options')]);
		$this->view->show('admin/restore_options.php', ['form' => $form]);
		$this->view->show('partial/footer.php');

	}

	public function importBackup()
	{
		$form = $this->backupsForms->import();
		
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Import a backup')]);
		$this->view->show('admin/import_backup.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
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

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Translations')]);
		$this->view->show('admin/translations.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

	public function uploadLogo()
	{
		$logoForm = $this->uploadlogo->logo();
		$favForm = $this->uploadlogo->favicon();
		
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Add logo')]);
		$this->view->show('admin/upload_logo.php', [
			'logoForm' => $logoForm,
			'favForm' =>  $favForm
		]);
		$this->view->show('partial/footer.php');
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

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Last login')]);
		$this->view->show('admin/last_login.php', ['userList' => $userList]);
		$this->view->show('partial/footer.php');
	}


}