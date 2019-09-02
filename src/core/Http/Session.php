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
            session_name('DOCPHT_SID'); 
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
        if (isset($_SESSION['MAC'])) {
            if ($_SESSION['MAC'] !== $this->getClientMac()) {
                session_unset();
                session_destroy();
            }
        } elseif (isset($_SERVER['HTTP_USER_AGENT']) && isset($_SESSION['UserAgent'])) {
            if ($_SERVER['HTTP_USER_AGENT'] !== $_SESSION['UserAgent']) {
                session_unset();
                session_destroy();
            }
        }
        
    }

    public function getClientMac()
    {
        if(function_exists('shell_exec')) {
            $macAddr = false;
            $arp =`arp -n`;
            $lines = explode("\n", $arp);
        
            foreach($lines as $line){
                $cols = preg_split('/\s+/', trim($line));
        
                if ($cols[0] == $this->getClientIP()){
                    $macAddr = $cols[2];
                }
            }
        
            return $macAddr;
        }
    }

    public function getClientIP()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $clientIP = $_SERVER['HTTP_CLIENT_IP'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
            $clientIP = $_SERVER['HTTP_X_FORWARDED'];
        } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $clientIP = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_FORWARDED'])) {
            $clientIP = $_SERVER['HTTP_FORWARDED'];
        } else if(isset($_SERVER['REMOTE_ADDR'])) {
            $clientIP = $_SERVER['REMOTE_ADDR'];
        }

        return $clientIP;
    }
    
}