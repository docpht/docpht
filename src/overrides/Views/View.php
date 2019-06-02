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

namespace DocPHT\Overrides\Views;

class View
{
	public function show($file, $data = null)
	{
		if (is_array($data))
		{
			extract($data);
		}

		if (isset($_SESSION['Active'])) {
			$users = json_decode(file_get_contents(realpath('src/config/users.json')), true);
			$usernames = [];
			foreach ($users as $user) { array_push($usernames,$user['Username']); }
			$currentUser = array_search($_SESSION['Username'],$usernames);
			$userLanguage = $users[$currentUser]['Language'];
	
			if (isset($userLanguage)) {
				if (file_exists('src/translations/'.$userLanguage.'.php')) {
					include 'src/translations/'.$userLanguage.'.php';
				} else {
					include 'src/translations/'.LANGUAGE.'.php';
				} 
			} 
		} elseif (file_exists('src/translations/'.LANGUAGE.'.php')) {
			include 'src/translations/'.LANGUAGE.'.php';
		} else {
			echo "Make sure that the constants.php file is present in the config folder and that the language code is entered.";
			exit;
		}
		
		include 'src/views/'.$file;
	}
}