<?php
/**
 * Just Framework - It's a PHP micro-framework for Full Stack Web Developer
 *
 * @package     Just Framework
 * @copyright   2016 (c) Mahmoud Elnezamy
 * @author      Mahmoud Elnezamy <http://nezamy.com>
 * @link        http://justframework.com
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @version     1.0.0
 */
namespace System\Support;
/**
 * Str
 *
 * @package     Just Framework
 * @author      Mahmoud Elnezamy <http://nezamy.com>
 * @since       1.0.0
 */

class Str
{
	/**
     * Convert string camelCase to array.
     *
     * @param string 	$str
     *
     * @return mixed
     */
	public static function camelCase($str) {
		return preg_split('/(?<=\\w)(?=[A-Z])/', $str);
	}

    public static function replace_last($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

	/**
     * Encrypt using mcrypt
     *
     * @param   mixed   $data   the data to encrypt, supports any type "it will be serialized"
     * @param   string  $key    the secrt key
     * @param   string  $cipher the cipher
     * @param   string  $mode   the mode
     * @return  string
     */
    public static function encrypt($data, $key, $cipher = MCRYPT_RIJNDAEL_128, $mode = MCRYPT_MODE_CBC)
    {
        $data       =   serialize($data);
        $key        =   hash('sha256', $key, true);
        $iv_size    =   mcrypt_get_iv_size($cipher, $mode);
        $iv         =   mcrypt_create_iv($iv_size, MCRYPT_RAND);

        return  base64_encode(serialize(array($iv, mcrypt_encrypt($cipher, $key, $data, $mode, $iv))));
    }

    /**
     * Decrypt using mcrypt
     *
     * @param   mixed   $data   the data to be decrypted
     * @param   string  $key    the secret key
     * @param   string  $cipher the cipher key
     * @param   string  $mode   the mode
     * @return  string
     */
    public static function decrypt($data, $key, $cipher = MCRYPT_RIJNDAEL_128, $mode = MCRYPT_MODE_CBC)
    {
        $key    =   hash('sha256', $key, true);

        @ list($iv, $encrypted) = (array) unserialize(base64_decode($data));

        return unserialize(trim(mcrypt_decrypt($cipher, $key, $encrypted, $mode, $iv)));
    }

    /**
     * Hash string using crypt function
     *
     * @uses    crypt()
     * @param   string  $string     string to hash
     * @param   string  $algorithm  [blowfish, md5, sha256, sha512]
     * @return  string
     */
    public static function hash($string, $algorithm = 'blowfish')
    {
        switch( strtolower($algorithm) ):
            case('md5'):
                $salt = '$1$'.(static::rand(12)).'$';
                break;
            case('sha256'):
                $salt = '$5$rounds=5000$'.(static::rand(16)).'$';
                break;
            case('sha512'):
                $salt = '$6$rounds=5000$'.(static::rand(16)).'$';
                break;
            case('blowfish'):
            default:
                $salt = '$2a$09$'.(static::rand(22)).'$';
                break;
        endswitch;

        return base64_encode(crypt($string, $salt));
    }

    /**
     * Checks whether a crypted hash is valid
     *
     * @uses    crypt()
     * @param   string $real    the real string
     * @param   string $hash    the hashed string
     * @return  bool
     */
    public static function verify($real, $hash)
    {
        $hash   =   base64_decode($hash);
        return      crypt($real, $hash) == $hash;
    }

    /**
     * Generate a random string with a certain length
     *
     * @param   integer $length
     * @param   bool    $special
     * @return  string
     */
	public static function rand($length = 10, $special = false)
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$special && ($characters .= '!@#$%^&*()+=>:;*-~`{}[],');
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	/**
     * Hash string using password_hash function.
     *
     * @param string 	$pass
     *
     * @return string
     */
    public static function password($pass)
    {
        return password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
    }

	/**
     * Checks whether a password hash is valid.
     *
     * @param string 	$pass
     *
     * @return string
     */
    public static function password_verify($pass, $hash)
    {
        return password_verify($pass, $hash);
    }

}
