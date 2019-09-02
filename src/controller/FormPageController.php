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

class FormPageController extends BaseController
{

	public function getCreatePageForm()
	{
		$form = $this->createPageForm->create();
		$this->view->load('Create new page','form-page/create_page.php', ['form' => $form]);
	}

	public function getPage($topic, $filename)
	{	
		$this->view->show('partial/head.php', ['PageTitle' => $topic .' '. $filename]);
		$page = require_once('pages/'.$topic.'/'.$filename.'.php');

		$pages = $this->pageModel->connect();
		$id = $_SESSION['page_id'];
		foreach ($pages as $value) {
		    if ($value['pages']['id'] === $id) {
			$published = $value['pages']['published'];
		    }
		}

		if ($published === 1) {
			$this->view->show('page/page.php', ['values' => $values]);
		} elseif($published === 0 && isset($_SESSION['Active'])) {
		    $this->view->show('page/page.php', ['values' => $values]);
		} else {
			header('Location:'.BASE_URL.'login');
			exit;
		}

			$this->view->show('partial/footer.php');
		}

	public function getAddSectionForm()
	{
		$form = $this->addSectionPageForm->create();
		$this->view->load('Add section','form-page/add_section.php', ['form' => $form]);
	}

	public function getUpdatePageForm()
	{
		$form = $this->updatePageForm->create();
		$this->view->load('Update page','form-page/update_page.php', ['form' => $form]);
	}
	
	public function getInsertSectionForm()
	{
		$form = $this->insertSectionForm->create();
		$this->view->load('Insert section','form-page/insert_section.php', ['form' => $form]);
	}
	
	public function getModifySectionForm()
	{
		$form = $this->modifySectionForm->create();
		$this->view->load('Modify section','form-page/modify_section.php', ['form' => $form]);
	}
	
	public function getRemoveSectionForm()
	{
		$form = $this->removeSectionForm->create();
	}
	
	public function getSortSectionForm()
	{
		$form = $this->sortSectionForm->create();
	}
	
	public function getDeletePageForm()
	{
		$form = $this->deletePageForm->delete();
	}
	
	public function getImportVersionForm()
	{
		$form = $this->versionForms->import();
		$this->view->load('Import version','form-page/import_version.php', ['form' => $form]);
	}
	
	public function getExportVersionForm()
	{
		$form = $this->versionForms->export();
	}
	
	public function getRestoreVersionForm()
	{
		$form = $this->versionForms->restore();
	}
	
	public function getDeleteVersionForm()
	{
		$form = $this->versionForms->delete();
	}
	
	public function getSaveVersionForm()
	{
		$form = $this->versionForms->save();
	}

	public function getPublish()
	{
		$this->publishPageForm->publish();
	}

	public function setHome()
	{
		$this->homePageForm->set();
	}

}
