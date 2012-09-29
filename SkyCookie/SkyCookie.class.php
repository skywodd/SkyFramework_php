<?php

/**
 * PHP CLASS - Cookies management with user-friendly wrapper
 * 
 * @author SkyWodd
 * @version 1
 * @link http://skyduino.wordpress.com
 * 
 * Please report bug to <skywodd at gmail.com>
 */
/*
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * Version History
 * 14/05/2012 - Initial commit
 *              
 */

/* Avoid direct access to script */
if (!defined('APPS_RUNNING'))
    die('<h1>Direct access to php class is not allowed.</h1>');

/**
 * Class SkyCookie
 */
class SkyCookie {

    /**
     * Create a new cookie
     * 
     * @param String $name Name of cookie
     * @param String $value Content of cookie
     * @param Integer $expire Expire timestamp of cookie (default 0)
     * @param String $path Path of cookie (default /)
     * @param String $domain Domain of cookie (default null)
     * @throws Exception 
     */
    public static function create($name, $value, $expire = 0, $path = '/', $domain = null) {

        /* Compute cookies data and send then to client */
        if (setcookie($name, $value, $expire, $path, $domain) == false)
        /* If something fail drop exception */
            throw new Exception('Something fail during cookie creation !');
    }

    /**
     * Return true if cookie exist, otherwise return false
     *
     * @param String $name Name of cookie
     * @throws Exception 
     * @return Boolean 
     */
    public static function exist($name) {

        /* Check arguments */
        if (!is_string($name))
            throw new Exception('Cookie name must be a string !');
        if ($name == '')
            throw new Exception('Cookie name must be not empty !');

        /* Check if specified cookie exist */
        return array_key_exists($name, $_COOKIE);
    }

    /**
     * Return content of cookie
     * 
     * @param type $name Name of cookie
     * @throws Exception 
     * @return String 
     */
    public static function getFrom($name) {

        /* Check arguments */
        if (!is_string($name))
            throw new Exception('Cookie name must be a string !');
        if ($name == '')
            throw new Exception('Cookie name must be not empty !');

        /* Check if specified cookie exist */
        if (array_key_exists($name, $_COOKIE) == false)
        /* If not drop exception */
            throw new Exception('Cookie does not exist !');

        /* Return value of cookie */
        return $_COOKIE[$name];
    }

    /**
     * Delete a cookie
     *
     * @param String $name Name of cookie
     * @param String $path Path of cookie (default /)
     * @param String $domain Domain of cookie (default null)
     * @throws Exception 
     */
    public static function delete($name, $path = '/', $domain = null) {

        /* Check arguments */
        if (!is_string($name))
            throw new Exception('Cookie name must be a string !');
        if ($name == '')
            throw new Exception('Cookie name must be not empty !');

        /* Timeout cookie, client browser will delete then at next page load */
        if (setcookie($name, '', time() - 3600, $path, $domain) == false)
        /* If something fail drop exception */
            throw new Exception('Something fail during cookie erasing !');
    }

}

?>
