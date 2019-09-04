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

namespace DocPHT\Core\Session;

class Session
{
    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', 1); // XSS attack protection
            ini_set('session.use_strict_mode', 1); // Prevents an attack that forces users to use a known session ID
            // Set an additional entropy
            ini_set('session.entropy_file', '/dev/urandom');
            ini_set('session.entropy_length', '256');
            session_name('ID'); 
            session_start();
        }
    }

    public function sessionExpiration()
    {
        $expireAfter = 30; // session life time expressed in minutes

        if(isset($_SESSION['last_action'])){

            $secondsInactive = time() - $_SESSION['last_action'];
            
            $expireAfterSeconds = $expireAfter * 60;
            
            if($secondsInactive >= $expireAfterSeconds){
                session_unset();
                session_destroy();
            }
        }

        $_SESSION['last_action'] = time();
    }

    public function preventStealingSession()
    {
        // Interesting stuff 
        // Prevent malicious users from stealing sessions
        if (isset($_SESSION['PREV_USERAGENT'])) {
            if ($_SERVER['HTTP_USER_AGENT'] != $_SESSION['PREV_USERAGENT']) {
                session_unset();
                session_destroy();
            }
        }
    }
}