<?php

/**
 * PHP CLASS - Simple and usefull Class to retrieve real IP of visitors
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
 * 05/05/2012 - Initial commit
 *              
 */

/* Avoid direct access to script */
if (!defined('APPS_RUNNING'))
    die('<h1>Direct access to php class is not allowed.</h1>');

/**
 * Class SkyVisitorIP 
 */
class SkyVisitorIP {

    /**
     * Return the IP of visitor, try to passthrougth proxy IP
     * THIS FUNCTION CAN RETURN A SPOOFED IP, BE AWARE !
     * 
     * @return String 
     */
    public static function getIP() {

        /* Check for a possible proxy forwarding */
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {

            /* If proxy forwarding used, return forward ip (CAN be spoofed) */
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

            /* If no proxy forwarding found */
        } else {

            /* Return tcp connection IP (can't be spoofed) */
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Return the IP of client behing proxy, or null
     * 
     * @return String 
     */
    public static function getForwardIP() {

        /* Check if proxy forwarding is used */
        if (!isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        /* If not return null */
            return null;

        /* Else return forward ip */
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    /**
     * Return the IP used for http connection
     * This ip CANNOT be spoofed !
     * 
     * @return String 
     */
    public static function getRemoteIP() {

        /* Return tcp connection IP (can't be spoofed) */
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Return the link to previous visited page of client, or null if not specified by web browser
     * 
     * @return String 
     */
    public static function getReferer() {
        
        /* Check if referer link is know (web browser can hide it) */
        if (!isset($_SERVER['HTTP_REFERER']))
            /* If not return null */
            return null;

        /* Return referer link URL */
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * Return the user agent of client, or null if not specified by web browser
     * 
     * @return String 
     */
    public static function getUserAgent() {
        
        /* Check if user agent is know (web browser can hide it) */
        if (!isset($_SERVER['HTTP_USER_AGENT']))
            return null;

        /* Return user agent string  */
        return $_SERVER['HTTP_USER_AGENT'];
    }

}

?>
