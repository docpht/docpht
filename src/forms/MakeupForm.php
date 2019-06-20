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
use DocPHT\Lib\DocBuilder;
use DocPHT\Model\PageModel;
use DocPHT\Model\VersionModel;
use DocPHT\Model\BackupsModel;
use DocPHT\Model\HomePageModel;
use DocPHT\Model\AdminModel;
use DocPHT\Core\Translator\T;
use Plasticbrain\FlashMessages\FlashMessages;

class MakeupForm
{
    protected $pageModel;
    protected $homePageModel;
    protected $adminModel;
    protected $versionModel;
    protected $backupsModel;
	protected $doc;
	protected $msg;
    
	public function __construct()
	{
		$this->pageModel = new PageModel();
		$this->homePageModel = new HomePageModel();
		$this->adminModel = new AdminModel();
		$this->versionModel = new VersionModel();
		$this->backupsModel = new BackupsModel();
		$this->doc = new DocBuilder();
		$this->msg = new FlashMessages();
	}
	
    public function bootstrap4(Form $form)
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
				if ($control instanceof \Nette\Forms\Controls\Checkbox) {
					$control->getLabelPrototype()->addClass('form-check-label');
				} else {
					$control->getItemLabelPrototype()->addClass('form-check-label');
				}
				$control->getControlPrototype()->addClass('form-check-input');
				$control->getSeparatorPrototype()->setName('div')->addClass('form-check');
			}
		}
    }
}
