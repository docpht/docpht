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

namespace Instant\Core\Helper;

class TextHelper 
{
    
    /**
     * textLimit
     *
     * @param  int $characterLength
     * @param  int $characterLimit
     * @param  string $string
     *
     * @return string
     */
    public static function textLimit(int $characterLength, int $characterLimit, string $string)
    {
        if (strlen($string) > $characterLength)
        $string = substr($string, 0, $characterLimit) . '...';
        return $string;
    }

    /**
     * HTML escaping
     *
     * @param  string   $value    Value to escape
     * @return string
     */
    public static function e($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
}
