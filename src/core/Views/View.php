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

namespace Instant\Core\Views;

use DocPHT\Model\PageModel;
use DocPHT\Model\AdminModel;
use DocPHT\Core\Translator\T;
use DocPHT\Model\BackupsModel;
use DocPHT\Model\HomePageModel;
use DocPHT\Form\VersionSelectForm;
use Plasticbrain\FlashMessages\FlashMessages;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class View 
{
	protected $pageModel;
	protected $backupsModel;
	protected $homePageModel;
	protected $version;
	protected $msg;

	public function __construct()
	{
		$this->pageModel = new PageModel();
		$this->adminModel = new AdminModel();
		$this->backupsModel = new BackupsModel();
		$this->homePageModel = new HomePageModel();
		$this->version = new VersionSelectForm();
		$this->msg = new FlashMessages();
	}

	public function show($file, $data = null)
	{
		if (isset($_SESSION['Active'])) {
			$adminModel = $this->adminModel;
            $userLanguage = $adminModel->getUserTrans($_SESSION['Username']);

			if (isset($userLanguage)) {
				$t = new Translator($userLanguage);
				$t->addLoader('array', new ArrayLoader());
				if (file_exists('src/translations/'.$userLanguage.'.php')) {
					include 'src/translations/'.$userLanguage.'.php';
				} else {
					include 'src/translations/'.LANGUAGE.'.php';
				} 
			} 
		} elseif (file_exists('src/translations/'.LANGUAGE.'.php')) {
			$t = new Translator(LANGUAGE);
			$t->addLoader('array', new ArrayLoader());
			include 'src/translations/'.LANGUAGE.'.php';
		} else {
			echo "Make sure that the config.php file is present in the config folder and that the language code is entered.";
			exit;
		}
		
		if (is_array($data))
		{
			extract($data);
		}
		$this->pageModel;
		$this->msg;
		$this->adminModel;
		include 'src/views/'.$file;
	}

	public function load(string $title, string $path, array $viewdata = null)
	{
		$data = ['PageTitle' => T::trans($title)];
		$this->show('partial/head.php',$data);
		$this->show($path, $viewdata);
		$this->show('partial/footer.php');
	}
}