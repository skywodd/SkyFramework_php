<?php

/**
 * PHP CLASS - Session management with user-friendly wrapper
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
 * Class SkySession
 */
class SkySession {

    /**
     * Create a SkySession object using specified arguments
     * 
     * @param String $name : Name of session
     * @param Integer $lifetime : Lifetime of session (in seconds)
     * @throws Exception 
     */
    public static function create($name = null, $lifetime = null) {

        /* Check arguments */
        if (isset($name)) {
            if (!is_string($name))
                throw new Exception('Session name must be a string or null !');
            if ($name == '')
                throw new Exception('Session name must be not empty or null !');
        }
        if (isset($lifetime)) {
            if (!is_numeric($lifetime))
                throw new Exception('Session lifetime must be a numeric or null !');
            if ($lifetime < 1)
                throw new Exception('Session lifetime must be greater or equal than 1 !');
        }

        /* Check if a lifetime have been specified for current session */
        if (isset($lifetime))
        /* Set session cookie lifetime */
            session_set_cookie_params($lifetime);

        /* Check if a name have been specified for current session */
        if (isset($name))
        /* Set name of current session */
            session_name($name);

        /* Open a new session, or resume a old one */
        if (session_start() == false)
        /* If something fail drop exeception */
            throw new Exception('Something fail during session starting !');
    }

    /**
     * Regenerate Session ID (Avoid session hijacking) 
     */
    public static function regenId() {

        /* Regenerate session id */
        if (session_regenerate_id(true) == false)
        /* If something fail drop exception */
            throw new Exception('Something goes wrong during session regeneration !');
    }

    /**
     * Return name of current session 
     * 
     * @return String
     */
    public static function getName() {

        /* return the current session name */
        return session_name();
    }

    /**
     * Return ID of the current session  
     * 
     * @return String
     */
    public static function getId() {

        /* return current session id */
        return session_id();
    }

    /**
     * Return true if the variable $varname exist in the current session, otherwise return false
     * 
     * @param String $varname : Name of variable to check
     * @return Boolean 
     */
    public static function exist($varname) {

        /* Check argument */
        if (!is_string($varname))
            throw new Exception('Variable name must be a string !');
        if ($varname == '')
            throw new Exception('Variable name must be not empty !');

        /* Check if varname exist in $_SESSION */
        return array_key_exists($varname, $_SESSION);
    }

    /**
     * Return content of specified variable from the current session
     * 
     * @param String $varname : Name of variable to get
     * @return Mixed 
     */
    public static function getFrom($varname) {

        /* Check argument */
        if (!is_string($varname))
            throw new Exception('Variable name must be a string !');
        if ($varname == '')
            throw new Exception('Variable name must be not empty !');

        /* Check if value exist in $_SESSION array */
        if (!array_key_exists($varname, $_SESSION))
        /* If not return null */
            return null;

        /* Return value associated to varname */
        return $_SESSION[$varname];
    }

    /**
     * Save content of the variable in the current session
     * 
     * @param String $varname : Name of variable to set
     * @param Mixed $value 
     */
    public static function setTo($varname, $value) {

        /* Check arguments */
        if (!is_string($varname))
            throw new Exception('Variable name must be a string !');
        if ($varname == '')
            throw new Exception('Variable name must be not empty !');

        /* Store value in session with specified varname as index key */
        $_SESSION[$varname] = $value;
    }

    /**
     * Return true if variable is set and equal to true
     * 
     * @param String $varname Name of variable to check
     * @param Boolean $value Set to true or false to (over)write previous value
     * @return Boolean
     */
    public static function isOk($varname, $value = null) {

        /* Check arguments */
        if (!is_string($varname))
            throw new Exception('Variable name must be a string !');
        if ($varname == '')
            throw new Exception('Variable name must be not empty !');
        if ($value != null)
            if (!is_bool($value))
                throw new Exception('Ok value must be a boolean !');

        /* Check if value need to be set or read back */
        if (isset($value)) {

            /* If value need to be set, store value */
            $_SESSION[$varname] = $value;

            /* Return value */
            return $value;

            /* Variable need to be check */
        } else {

            /* Check if variable exist */
            if (!array_key_exists($varname, $_SESSION))
            /* If not return false */
                return false;

            /* Check and return */
            return ($_SESSION[$varname] === true);
        }
    }

    /**
     * Delete variable from the current session
     * 
     * @param String $varname : Name of variable to delete
     */
    public static function deleteKey($varname) {

        /* Check argument */
        if (!is_string($varname))
            throw new Exception('Variable name must be a string !');
        if ($varname == '')
            throw new Exception('Variable name must be not empty !');

        /* Check if key exist */
        if (isset($_SESSION[$varname]))
        /* If yes, unset specified key */
            unset($_SESSION[$varname]);
    }

    /**
     * Close the current session
     * 
     * @param Boolean $backup : Set this param to TRUE to backup session before closing it
     */
    public static function close($backup = false) {

        /* Check argument */
        if (!is_bool($backup))
            throw new Exception('Backup option must be a boolean !');

        /* If session destroying requested */
        if ($backup == false) {
            /* If yes, close and wipe session */
            if (session_destroy() == false)
            /* If something fail drop exception */
                throw new Exception('Something goes wrong during session erasing !');
        } else
        /* Else, close and wipe session too, but save data before */
            session_write_close();

        /* Flush session data */
        $_SESSION = Array();
    }

}

?>
