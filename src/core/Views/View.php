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

class View 
{
	public function show($file, $data = null)
	{
		if (is_array($data))
		{
			extract($data);
		}
		include 'src/views/'.$file;
	}
}