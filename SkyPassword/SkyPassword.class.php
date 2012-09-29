<?php

/**
 * PHP CLASS - Password utility class
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
 * 08/05/2012 - Initial commit
 *              
 */

/* Avoid direct access to script */
if (!defined('APPS_RUNNING'))
    die('<h1>Direct access to php class is not allowed.</h1>');

/**
 * Class SkyPassword
 */
class SkyPassword {

    /**
     * Return true if encrypted password and hash are equal
     * 
     * @param String $hash Hash to check against
     * @param String $password Plain text password
     * @param String $algo Hashing algorithm to use (default sha256)
     * @return Boolean 
     */
    public static function check($hash, $password, $algo = 'sha256') {
        
        /* Check argument */
        if(!is_string($hash))
            throw new Exception('Password hash must be a string !');
        if($hash == '')
            throw new Exception('Password hash must be not empty !');
                
        /* Compute and test password */
        return (hash($algo, $password) == $hash);
    }

    /**
     * Compute plain text password to hash
     * 
     * @param String $password Plain text password
     * @param String $algo Hashing algorithm to use (default sha256)
     * @return String 
     */
    public static function compute($password, $algo = 'sha256') {
        
        /* Check argument */
        if(!is_string($password))
            throw new Exception('Password must be a string !');
        if($password == '')
            throw new Exception('Password must be not empty !');
        
        /* compute password and return hash */
        return hash($algo, $password);
    }
    
    /**
     * Generate a password according security level specified
     * (Generate a level 5 password by default)
     * 
     * @param Integer $length Length of output password string (minimum 6)
     * @param Boolean $upperLower If true password will contain upper and lower case (default true)
     * @param Boolean $numeric If true password will contain numeric (default true)
     * @param Boolean $specialChar If true password will contain special char (default false)
     * @param Integer $sufflePass Number of suffle pass before return password (default 2)
     * @return String 
     */
    public static function generate($length = 10, $upperLower = true, $numeric = true, $specialChar = false, $sufflePass = 2) {
        
        /* Check arguments */
        if(!is_numeric($length))
            throw new Exception('Password length must be a numeric !');
        if($length < 6)
            throw new Exception('Password length must be greater than 6 ! (seriously 6 char password is the minimum ...)');
        if(!is_bool($upperLower))
            throw new Exception('Upper and lower case option must be a boolean !');
        if(!is_bool($numeric))
            throw new Exception('Alpha and numeric option must be a boolean !');
        if(!is_bool($specialChar))
            throw new Exception('Special char option must be a boolean !');
        if(!is_numeric($sufflePass))
            throw new Exception('Shuffle pass count must be a numeric !');
        if($sufflePass < 1)
            throw new Exception('Shuffle pass count must be greater than 1 !');

        /* Lower case charset */
        $lowerCase = 'abcdefghijkmnopqrstuvwxyz';

        /* Upper case charset */
        $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        /* Numeric char charset */
        $numericCase = '234567890';

        /* Special char charset */
        $specialCase = '!"#$%`\'()*+,-./:;<=>?@[\]^_`{|}~';

        /* declare empty password string */
        $password = '';

        /* Compute password balance using boolean trick */
        $balance = 1 + (int) $upperLower + (int) $numeric + (int) $specialChar;

        /* Add some lower case to password */
        for ($i = 0; $i < ($length / $balance); $i++)
            $password .= $lowerCase[rand(0, strlen($lowerCase) - 1)];

        /* If upper case are allowed */
        if ($upperLower)
        /* Add some upper case to password */
            for ($i = 0; $i < ($length / $balance); $i++)
                $password .= $upperCase[rand(0, strlen($upperCase) - 1)];

        /* If numeric case are allowed */
        if ($numeric)
        /* Add some numeric case to password */
            for ($i = 0; $i < ($length / $balance); $i++)
                $password .= $numericCase[rand(0, strlen($numericCase) - 1)];

        /* If special char are allowed */
        if ($specialChar)
        /* Add some special char to password */
            for ($i = 0; $i < ($length / $balance); $i++)
                $password .= $specialCase[rand(0, strlen($specialCase) - 1)];

        /* Add some lower case to password to have the correct password length */
        $l = strlen($password);
        for ($i = 0; $i < ($length - $l); $i++)
            $password .= $lowerCase[rand(0, strlen($lowerCase) - 1)];

        /* For each number of suffle pass specified */
        for ($i = 0; $i < $sufflePass; $i++)
        /* Mix password string */
            $password = str_shuffle($password);

        /* All done */
        return $password;
    }

    /**
     * Compute the strength of given password.
     * Strength level start from 0 (totally bullshit password) to 10 (Elite pasword inside)
     * A good password should be between 4 and 5
     * 
     * @param String $password
     * @return Integer 
     */
    public static function getStrength($password) {
        
        /* Check argument */
        if(!is_string($password))
            throw new Exception('Password must be a string !');
        if($password == '')
            throw new Exception('Password must be not empty !');
        
        /* Strength level from 0 (totally bullshit password) to 10 (Elite pasword inside) */
        $strength = 0;

        /* Test if password length is less than 8 char */
        if (strlen($password) < 8)
        /* If yes return 0, this password should not be used */
            return 0;

        /* Test if password length is more (or equal) than 8 char */
        if (strlen($password) >= 8)
        /* If yes, good +1 point */
            $strength++;

        /* Test if password length is more (or equal) than 10 char */
        if (strlen($password) >= 10)
        /* If yes, pretty good +1 point */
            $strength++;

        /* Test if password length is more (or equal) than 12 char */
        if (strlen($password) >= 12)
        /* If yes, very good job +1 point */
            $strength++;

        /* Test if password length is more (or equal) than 15 char */
        if (strlen($password) >= 15)
        /* If yes, you rock ! +2 point */
            $strength += 2;

        /* Test if password contain lower case char */
        if (preg_match('/[a-z]/', $password))
        /* If yes, good +1 point */
            $strength++;

        /* Test if password contain upper case char */
        if (preg_match('/[A-Z]/', $password))
        /* If yes, good +1 point */
            $strength++;

        /* Test if password contain numerical char */
        if (preg_match('/[0-9]/', $password))
        /* If yes, good +1 point */
            $strength++;

        /* Test if password contain special char */
        if (preg_match('/[!"#$%`\'()*+,-.\/:;<=>?@[\]^_`{|}~]/', $password))
        /* If yes, Woo! Elite inside +2 point */
            $strength += 2;

        /* A good password should be between 4 and 5 */
        return $strength;
    }

}

?>
