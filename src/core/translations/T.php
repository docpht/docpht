<?php

namespace DocPHT\Core\Translator;

use DocPHT\Model\AdminModel;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class T
{
    public static function trans($string, $array = null) 
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
        
        if (isset($array)) {
            return $t->trans($string, $array);
        } else {
            return $t->trans($string);
        }

    }
}