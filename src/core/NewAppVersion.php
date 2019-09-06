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

use Curl\Curl;

class NewAppVersion 
{
    public function check()
    {
        $curl = new Curl();
        $curl->get('https://docpht.com/releases/latest.php?token=eyJ0eXAiOiJKV1QiLCJhbGlLm9yZyIsW1wbGUuY', array());

        $appVersion = preg_replace("/[^0-9]/", "", APP_VERSION);

        if (!$curl->error) {
            foreach (json_decode($curl->response) as $key => $value) {
                if ($key === 'version') {
                    $latestVersion = preg_replace("/[^0-9]/", "", $value);
                    if ($latestVersion > $appVersion) {
                        return true;
                    } 

                    return false;
                }
            }
        }

        $curl->close();
    }
}

