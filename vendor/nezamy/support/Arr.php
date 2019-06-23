<?php
/**
 * Just Framework - It's a PHP micro-framework for Full Stack Web Developer
 *
 * @package     Just Framework
 * @copyright   2016 (c) Mahmoud Elnezamy
 * @author      Mahmoud Elnezamy <http://nezamy.com>
 * @link        http://justframework.com
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @version     1.0.1
 */
namespace System\Support;
/**
 * Arr
 *
 * @package     Just Framework
 * @author      Mahmoud Elnezamy <http://nezamy.com>
 * @since       1.0.1
 */
class Arr
{
	/**
	* Get value from nested array.
	*
	* @param array 	$arr
	* @param string    $k
	* @param string 	$default
	*
	* @return mixed
	*/
	public static function get(array $arr, $k, $default=null)
	{
		if ( isset($arr[$k]) ) return $arr[$k];

		$nested = explode('.',$k);
		foreach ( $nested as $part ) {
		    if (isset($arr[$part])) {
				$arr = $arr[$part];
				continue;
		    } else {
				$arr = $default;
				break;
		    }
		}
		return $arr;
	}

	/**
     * set value to nested array.
     *
     * @param array 	$arr
     * @param string    $k
     * @param mixed 	$v
     *
     * @return array
     */
	public static function set(array $arr, $k, $v)
	{
		$nested = !is_array($k) ? explode('.',$k) : $k;
		$count = count($nested);
		if ($count == 1){
			return $arr[$k] = $v;
		}
		elseif ($count > 1)
		{
			$prev = '';
			$loop = 1;
			$unshift = $nested;

			foreach ($nested as $part)
			{
				if (isset($arr[$part]) && $count > $loop)
				{
					$prev = $part;
					array_shift($unshift);
					$loop++;
					continue;
				}
				else
				{
					if ( $loop > 1 && $loop < $count )
					{
						if( !isset($arr[$prev][$part]) ) $arr[$prev][$part] = [];

						$arr[$prev] = static::set($arr[$prev], $unshift, $v);
						$loop++; break;
					}
					elseif ( $loop >= 1 && $loop == $count )
					{
						if ( !is_array($arr[$prev]) ) $arr[$prev] = [];

						if ($part == '')
							$arr[$prev][] = $v;
						else
							$arr[$prev][$part] = $v;
					}else{
						$arr[$part] = [];
						$prev = $part;
						array_shift($unshift);
						$loop++;
					}
				}
	        }
		}
		return $arr;
	}

	/**
     * Get value if key exists or default value.
     *
     * @param array 	$arr
     * @param string    $k
     * @param string 	$default
     *
     * @return mixed
     */
	public static function value(array $arr, $k, $default=null){
		return isset($arr[$k]) ? $arr[$k] : $default;
	}

	/**
     * Get value from string json.
     *
     * @param string 	$jsonStr
     * @param string    $k
     * @param string 	$default
     *
     * @return mixed
     */
	public static function json($jsonStr, $k=null, $default=null){
		$json = json_decode($jsonStr, true);
		if($k && $json){
			return self::get($json, $k, $default);
		}
		return $json;
	}
	
	public static function replace_values($arr, $from = null, $to = "")
	{
		$results = [];
		foreach ($arr as $k => $v) {
			$toArr = (array) $v;
			if(count($toArr) > 1 || is_array($v)){
				$results[$k] = nullToString($toArr);
			} else {
				$results[$k] = $v;
				if ($v == $from) {
					$results[$k] = $to;
				}
			}
		}
		return $results;
	}
}
