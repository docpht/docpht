<?php

/**
 * This file is part of the Instant MVC micro-framework project.
 * 
 * @package     Instant MVC micro-framework
 * @author      Valentino Pesce 
 * @link        https://github.com/kenlog
 * @copyright   2019 (c) Valentino Pesce <valentino@iltuobrand.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instant\Core\Controller;

use DocPHT\Form\SearchForm;
use DocPHT\Model\PageModel;
use DocPHT\Model\SearchModel;
use DocPHT\Model\HomePageModel;
use DocPHT\Model\VersionModel;
use DocPHT\Model\BackupsModel;
use DocPHT\Model\AdminModel;
use DocPHT\Form\AddUserForm;
use Instant\Core\Views\View;
use DocPHT\Core\Translator\T;
use DocPHT\Form\VersionForms;
use DocPHT\Form\BackupsForms;
use DocPHT\Form\AddSectionForm;
use DocPHT\Form\CreatePageForm;
use DocPHT\Form\DeletePageForm;
use DocPHT\Form\RemoveUserForm;
use DocPHT\Form\UpdatePageForm;
use DocPHT\Form\PublishPageForm;
use DocPHT\Form\HomePageForm;
use DocPHT\Form\SortSectionForm;
use DocPHT\Form\TranslationsForm;
use DocPHT\Form\InsertSectionForm;
use DocPHT\Form\ModifySectionForm;
use DocPHT\Form\RemoveSectionForm;
use DocPHT\Form\VersionSelectForm;
use DocPHT\Form\UpdatePasswordForm;
use Plasticbrain\FlashMessages\FlashMessages;
use DocPHT\Form\UploadLogoForm;

class BaseController
{
	protected $view;
	protected $removeUserForm;
	protected $updatePasswordForm;
	protected $translationsForm;
	protected $addUserForm;
	protected $createPageForm;
	protected $adminModel;
	protected $addSectionPageForm;
	protected $updatePageForm;
	protected $deletePageForm;
	protected $insertSectionForm;
	protected $modifySectionForm;
	protected $removeSectionForm;
	protected $sortSectionForm;
	protected $msg;
	protected $versionForms;
	protected $backupsForms;
	protected $version;
	protected $search;
	protected $publishPageForm;
	protected $homePageForm;
	protected $pageModel;
	protected $searchModel;
	protected $homePageModel;
	protected $backupsModel;
	protected $versionModel;
	protected $uploadlogo;
	
	public function __construct()
	{
		$this->view = new View();
		$this->updatePasswordForm = new UpdatePasswordForm();
		$this->removeUserForm = new RemoveUserForm();
		$this->addUserForm = new AddUserForm();
		$this->translationsForm = new TranslationsForm();
		$this->createPageForm = new CreatePageForm();
		$this->addSectionPageForm = new AddSectionForm();
		$this->updatePageForm = new UpdatePageForm();
		$this->deletePageForm = new DeletePageForm();
		$this->insertSectionForm = new InsertSectionForm();
		$this->modifySectionForm = new ModifySectionForm();
		$this->removeSectionForm = new RemoveSectionForm();
		$this->sortSectionForm = new SortSectionForm();
		$this->msg = new FlashMessages();
		$this->versionForms = new VersionForms();
		$this->backupsForms = new BackupsForms();
		$this->version = new VersionSelectForm;
		$this->search = new SearchForm();
		$this->publishPageForm = new PublishPageForm();
		$this->homePageForm = new HomePageForm();
		$this->adminModel = new AdminModel();
		$this->pageModel = new PageModel();
		$this->searchModel = new SearchModel();
		$this->homePageModel = new HomePageModel();
		$this->backupsModel = new BackupsModel();
		$this->versionModel = new VersionModel();
		$this->uploadlogo = new UploadLogoForm();
	}

	public function search()
	{
	    $this->searchModel->feed();
		$results = $this->search->create();
		if (isset($results)) {
			$this->view->show('partial/head.php', ['PageTitle' => T::trans('Search')]);
			$this->view->show('search_results.php', ['results' => $results]);
			$this->view->show('partial/footer.php');
		} else {
			$this->msg->info(T::trans('Search term did not produce results'),$_SERVER['HTTP_REFERER']);
		}
	}

	public function switchTheme()
    {
		if (isset($_COOKIE["theme"]) && $_COOKIE["theme"] == 'dark') {
			setcookie("theme", "light");			
		} else {
			setcookie("theme", "dark");
		}
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit;
    }

}