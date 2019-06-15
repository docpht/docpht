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

class FormPageController extends BaseController
{

	public function getCreatePageForm()
	{
		$form = $this->createPageForm->create();

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Create new page')]);
		$this->view->show('form-page/create_page.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

	public function getPage($topic, $filename)
	{	
		$this->view->show('partial/head.php', ['PageTitle' => $topic .' '. $filename]);
		$page = require_once('pages/'.$topic.'/'.$filename.'.php');
		$this->view->show('page/page.php', ['values' => $values]);
		$this->view->show('partial/footer.php');
	}

	public function getAddSectionForm()
	{
		$form = $this->addSectionPageForm->create();

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Add section')]);
		$this->view->show('form-page/add_section.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

	public function getUpdatePageForm()
	{
		$form = $this->updatePageForm->create();

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Update page')]);
		$this->view->show('form-page/update_page.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}
	
	public function getInsertSectionForm()
	{
		$form = $this->insertSectionForm->create();

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Insert section')]);
		$this->view->show('form-page/insert_section.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}
	
	public function getModifySectionForm()
	{
		$form = $this->modifySectionForm->create();

		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Modify section')]);
		$this->view->show('form-page/modify_section.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
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
		
		$this->view->show('partial/head.php', ['PageTitle' => T::trans('Import version')]);
		$this->view->show('form-page/import_version.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
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

}