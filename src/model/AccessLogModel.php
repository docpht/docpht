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

namespace DocPHT\Model;

use Browser;
use DocPHT\Core\Translator\T;
use geertw\IpAnonymizer\IpAnonymizer;

class AccessLogModel
{
    const ACCESSLOG = 'data/accesslog.json';
    
    /**
     * connect
     *
     * @return array
     */
    public function connect()
    {
        if(!file_exists(self::ACCESSLOG))
        {
            file_put_contents(self::ACCESSLOG,[]);
        }

        return json_decode(file_get_contents(self::ACCESSLOG),true);
    }

    /**
     * create
     *
     * @return array
     */
    public function create($username)
    {
        $data = $this->connect();
        if (isset($_SESSION['Username'])) {
            $data[] = array(
                'Username' => $_SESSION['Username'],
                'IP_address' => $this->ipAnonymizer($this->getClientIP()),
                'Access_date' => date(DATAFORMAT, time()),
                'User_agent' => $this->getUserAgent(),
                'Severity' => 'Authorized access',
                'Alert' => false
            );
        } else {
            $data[] = array(
                'Username' => $username,
                'IP_address' => $this->getClientIP(),
                'Access_date' => date(DATAFORMAT, time()),
                'User_agent' => $this->getUserAgent(),
                'Severity' => 'Attempt to access',
                'Alert' => true
            );
        }
            
        return $this->disconnect(self::ACCESSLOG, $data);
    }

    /**
     * getUserAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        $userAgent = new Browser();
        return $userAgent->getBrowser() .'/'. $userAgent->getVersion() .'/'. $userAgent->getPlatform();
    }

    /**
     * getClientIP
     *
     *
     * @return string
     */
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

    /**
     * ipAnonymizer
     *
     * @param  string $ip
     *
     * @return string
     */
    public function ipAnonymizer(string $ip)
    {
        $ipAnonymizer = new IpAnonymizer();
        $ipAnonymizer->ipv4NetMask = "255.255.0.0";
        return $ipAnonymizer->anonymize($ip);
    }

    /**
     * getUserList
     *
     *
     * @return array
     */
    public function getUserList()
    {
        $data = $this->connect();

        return $data;
    }

    /**
     * disconnect
     *
     * @param  string $path
     * @param  array $data
     *
     * @return array
     */
    public function disconnect($path, $data)
    {
        return file_put_contents($path, json_encode($data));
    }
}
