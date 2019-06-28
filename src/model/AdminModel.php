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

class AdminModel
{
    const USERS = 'data/users.json';
    
    /**
     * connect
     *
     *
     * @return array
     */
    public function connect()
    {
		if(!file_exists(self::USERS))
		{
		    file_put_contents(self::USERS,[]);
		} 
		
		return json_decode(file_get_contents(self::USERS),true);
    }

    /**
     * create
     *
     * @param  array $values
     *
     * @return array
     */
    public function create($values)
    {
        $data = $this->connect();
        $data[] = array(
            'Username' => $values['username'],
            'Password' => password_hash($values['password'], PASSWORD_DEFAULT),
            'Language' => $values['translations'],
            'Token'    => '',
            'Admin'    => $values['admin']
            );
            
        return $this->disconnect(self::USERS, $data);
    }
    
    /**
     * verifyPassword
     *
     * @param  string $username
     * @param  string $password
     *
     * @return boolean
     */
    public function verifyPassword($username, $password)
    {
        $data = $this->connect();
        $key = array_search($username, array_column($data, 'Username'));
        
        return password_verify($password, $data[$key]['Password']);
    }
    
    /**
     * updatePassword
     *
     * @param  string $username
     * @param  string $password
     * 
     * @return array
     */
    public function updatePassword($username, $password)
    {
        $data = $this->connect();
        $key = array_search($username, array_column($data, 'Username'));
        
        $data[$key]['Password'] = password_hash($password, PASSWORD_DEFAULT);
        
        return $this->disconnect(self::USERS, $data);
    }

    /**
     * updateEmail
     *
     * @param  string $username
     * @param  string $email
     *
     * @return string
     */
    public function updateEmail($username, $email)
    {
        $data = $this->connect();
        $key = array_search($username, array_column($data, 'Username'));
        
        $data[$key]['Username'] = $email;
        
        return $this->disconnect(self::USERS, $data);
    }

    /**
     * randomPassword
     *
     * @return string
     */
    public function randomPassword() 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * updateTrans
     *
     * @param  string $username
     * @param  string $translation
     * 
     * @return array
     */
    public function updateTrans($username, $translation)
    {
        $data = $this->connect();
        $key = array_search($username, array_column($data, 'Username'));
        
        $data[$key]['Language'] = $translation;
        
        return $this->disconnect(self::USERS, $data);
    }
    
    /**
     * getUserTrans
     *
     * @param  string $username
     * 
     * @return string
     */
    public function getUserTrans($username)
    {
        $data = $this->connect();
        $key = array_search($username, array_column($data, 'Username'));
        
        return $data[$key]['Language'];
    }
    
    /**
     * removeUser
     *
     * @param  string $userindex
     * 
     * @return array
     */
    public function removeUser($userindex)
    {
        $data = $this->connect();

        array_splice($data, $userindex, 1); 
        
        return $this->disconnect(self::USERS, $data);
    }

    /**
     * userExists
     *
     * @param  string $user
     * 
     * @return boolean
     */
    public function userExists($user)
    {
        return in_array($user, $this->getUsernames());
    }

    /**
     * getUsernames
     *
     * @return array
     */
    public function getUsernames()
    {
        $data = $this->connect();

        $usernames = array_column($data, 'Username');
        
        return $usernames;
    }

    /**
     * checkUserIsAdmin
     *
     * @param  string $username
     *
     * @return boolean
     */
    public function checkUserIsAdmin($username)
    {
        $data = $this->connect();
        $key = array_search($username, array_column($data, 'Username'));
        
        return $data[$key]['Admin'];
    }

    /**
     * createTimedToken
     *
     * @param  string $hour
     *
     * @return string
     */
    public function createTimedToken(string $hour)
    {
        $date = date('Y-m-d H:i', strtotime("+".$hour." hour"));
        $expiry = strtotime($date);
        $token = md5(uniqid(rand(), true));

        return $token.'&expiry='.$expiry;
    }

    /**
     * addToken
     *
     * @param  string $username
     * @param  string $token
     *
     * @return string
     */
    public function addToken($username, $token)
    {
        $data = $this->connect();
        $key = array_search($username, array_column($data, 'Username'));
        
        $data[$key]['Token'] = $token;
        
        return $this->disconnect(self::USERS, $data);
    }

    /**
     * getUsernameFromToken
     *
     * @param  string $token
     *
     * @return string
     */
    public function getUsernameFromToken($token)
    {
        $data = $this->connect();
        $key = array_search($token, array_column($data, 'Token'));
        
        return $data[$key]['Username'];
    }

    /**
     * getTokenFromUsername
     *
     * @param  string $username
     *
     * @return string
     */
    public function getTokenFromUsername($username)
    {
        $data = $this->connect();
        $key = array_search($username, array_column($data, 'Username'));
        
        return $data[$key]['Token'];
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
    
    /**
     * getUsers
     *
     *
     * @return array
     */
    public function getUsers()
    {
        $data = $this->connect();

        return $data;
    }

}