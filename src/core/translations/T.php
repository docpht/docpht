<?php

namespace DocPHT\Core\Translator;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class T{
 
    public static function trans($string, $array = null) 
    {

        if (isset($_SESSION['Active'])) {
			$users = json_decode(file_get_contents(realpath('src/config/users.json')), true);
			$usernames = [];
			foreach ($users as $user) { array_push($usernames,$user['Username']); }
			$currentUser = array_search($_SESSION['Username'],$usernames);
			$userLanguage = $users[$currentUser]['Language'];
	
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