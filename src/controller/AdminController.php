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

//use DocPHT\Model\Admin;
use Nette\Forms\Form;
use Nette\Utils\Html;
use Instant\Core\Controller\BaseController;


class AdminController extends BaseController
{
	private $modelAdmin;
    
	public function __construct()
	{
		parent::__construct();
		//$this->modelAdmin = new Admin();
	}
			
	public function settings()
	{
		//$data = $this->modelAdmin->getData();
		$this->view->show('partial/head.php',['PageTitle' => 'Admin']);
		$this->view->show('admin/settings.php');
		$this->view->show('partial/footer.php');
	}

	public function makeBootstrap4(Form $form)
	{
		$renderer = $form->getRenderer();
		$renderer->wrappers['controls']['container'] = null;
		$renderer->wrappers['pair']['container'] = 'div class="form-group"';
		$renderer->wrappers['pair']['.error'] = 'has-danger';
		$renderer->wrappers['control']['container'] = 'div class=col';
		$renderer->wrappers['label']['container'] = 'div class="col col-form-label font-weight-bold"';
		$renderer->wrappers['control']['description'] = 'span class=form-text';
		$renderer->wrappers['control']['errorcontainer'] = 'span class=form-error';

		foreach ($form->getControls() as $control) {
			$type = $control->getOption('type');
			if ($type === 'button') {
				$control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-secondary btn-block' : 'btn btn-primary');
				$usedPrimary = true;

			} elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
				$control->getControlPrototype()->addClass('form-control selectpicker');

			} elseif ($type === 'file') {
				$control->getControlPrototype()->addClass('form-control-file');

			} elseif (in_array($type, ['checkbox', 'radio'], true)) {
				if ($control instanceof Nette\Forms\Controls\Checkbox) {
					$control->getLabelPrototype()->addClass('form-check-label');
				} else {
					$control->getItemLabelPrototype()->addClass('form-check-label');
				}
				$control->getControlPrototype()->addClass('form-check-input');
				$control->getSeparatorPrototype()->setName('div')->addClass('form-check');
			}
		}
	}

	public function updatePassword()
	{

		$form = new Form;
		$form->onRender[] = [$this, 'makeBootstrap4'];

		$form->addGroup('Personal data')
			->setOption('description', 'We value');

		$form->addText('name', 'Your name:')
			->setRequired('Enter your name');

		$form->addSubmit('submit', 'Send');

		$form->setDefaults([
			'name' => 'Vale',
		]);

		if ($form->isSuccess()) {
			echo '<h2>Form was submitted and successfully validated</h2>';
			var_dump($form->getValues());
		}

		$this->view->show('partial/head.php', ['PageTitle' => 'Update Password']);
        $this->view->show('admin/update_password.php', ['form' => $form]);
		$this->view->show('partial/footer.php');
	}

	public function removeUser()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Remove User']);
		$this->view->show('admin/remove_user.php');
		$this->view->show('partial/footer.php');
	}
		
	public function addUser()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Add user']);
		$this->view->show('admin/add_user.php');
		$this->view->show('partial/footer.php');
	}

	public function createHome()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Create Home']);
		$this->view->show('admin/create_home.php');
		$this->view->show('partial/footer.php');
	}

	public function translations()
	{
		$this->view->show('partial/head.php', ['PageTitle' => 'Translations']);
		$this->view->show('admin/translations.php');
		$this->view->show('partial/footer.php');
	}

}