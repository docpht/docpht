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

use DocPHT\Core\Error;
use DocPHT\Model\PageModel;
use DocPHT\Model\AdminModel;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class View 
{
	protected $pageModel;

	public function __construct()
	{
		$this->pageModel = new PageModel();
		$this->error = new Error();
	}

	public function show($file, $data = null)
	{
		if (isset($_SESSION['Active'])) {
			$adminModel = new AdminModel();
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
		$this->error;
		include 'src/views/'.$file;
	}
}