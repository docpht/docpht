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

use DocPHT\Form\AddUserForm;
use DocPHT\Model\AdminModel;
use Instant\Core\Views\View;
use DocPHT\Core\Translator\T;
use DocPHT\Form\VersionForms;
use DocPHT\Form\AddSectionForm;
use DocPHT\Form\CreatePageForm;
use DocPHT\Form\DeletePageForm;
use DocPHT\Form\RemoveUserForm;
use DocPHT\Form\UpdatePageForm;
use DocPHT\Form\SortSectionForm;
use DocPHT\Form\TranslationsForm;
use DocPHT\Form\InsertSectionForm;
use DocPHT\Form\ModifySectionForm;
use DocPHT\Form\RemoveSectionForm;
use DocPHT\Form\VersionSelectForm;
use DocPHT\Form\UpdatePasswordForm;
use Plasticbrain\FlashMessages\FlashMessages;
use DocPHT\Form\SearchForm;
use DocPHT\Form\PublishPageForm;

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
	protected $version;
	protected $search;
	protected $publishPageForm;
	
	public function __construct()
	{
		$this->view = new View();
		$this->updatePasswordForm = new UpdatePasswordForm();
		$this->removeUserForm = new RemoveUserForm();
		$this->addUserForm = new AddUserForm();
		$this->translationsForm = new TranslationsForm();
		$this->createPageForm = new CreatePageForm();
		$this->adminModel = new AdminModel();
		$this->addSectionPageForm = new AddSectionForm();
		$this->updatePageForm = new UpdatePageForm();
		$this->deletePageForm = new DeletePageForm();
		$this->insertSectionForm = new InsertSectionForm();
		$this->modifySectionForm = new ModifySectionForm();
		$this->removeSectionForm = new RemoveSectionForm();
		$this->sortSectionForm = new SortSectionForm();
		$this->msg = new FlashMessages();
		$this->versionForms = new VersionForms();
		$this->version = new VersionSelectForm;
		$this->search = new SearchForm();
		$this->publishPageForm = new PublishPageForm();
	}

	public function search()
	{
		$results = $this->search->create();
		if (isset($results)) {
			$this->view->show('partial/head.php', ['PageTitle' => T::trans('Search')]);
			$this->view->show('search_results.php', ['results' => $results]);
			$this->view->show('partial/footer.php');
		} else {
			$this->msg->info(T::trans('Search term did not produce results'),$_SERVER['HTTP_REFERER']);
		}
	}

}