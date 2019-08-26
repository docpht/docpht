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
                'IP_address' => $this->ipAnonymizer($_SERVER['REMOTE_ADDR']),
                'Access_date' => date(DATAFORMAT, time()),
                'User_agent' => $_SERVER ['HTTP_USER_AGENT'],
                'Severity' => T::trans('Authorized access'),
                'Alert' => false
            );
        } else {
            $data[] = array(
                'Username' => $username,
                'IP_address' => $_SERVER['REMOTE_ADDR'],
                'Access_date' => date(DATAFORMAT, time()),
                'User_agent' => $_SERVER ['HTTP_USER_AGENT'],
                'Severity' => T::trans('Attempt to access'),
                'Alert' => true
            );
        }
            
        return $this->disconnect(self::ACCESSLOG, $data);
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
