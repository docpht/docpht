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

namespace DocPHT\Core;

class Error 
{
    public $messages = [
        1 => 'Error 1',
    ];

    public $messageCode;

    public function getMessage()
    {
		if(isset($_GET['msg'])){
			$this->messageCode = $_GET['msg'];
		}
		    $key = intval($this->messageCode);
		if(array_key_exists($key, $this->messages)){
			return $this->messages[$key];
		}
		return FALSE;
	}
}