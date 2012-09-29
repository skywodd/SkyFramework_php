<?php

/**
 * PHP CLASS - Anti XSS and type matching security class
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

/*
 * SkySanitize
 */

class SkySanitize {
    /* ----- Filtering and sanitize functions ----- */

    /**
     * Sanitize email address
     * 
     * @param String $input Input to sanitize
     * @return String 
     */
    public function filterEmail($input) {
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize Url
     * 
     * @param String $input Input to sanitize
     * @return String 
     */
    public function filterUrl($input) {
        return filter_var($input, FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    }

    /**
     * Sanitize String with quotes inside
     * 
     * @param String $input Input to sanitize
     * @return String 
     */
    public function filterQuotes($input) {
        return filter_var($input, FILTER_SANITIZE_MAGIC_QUOTES);
    }

    /**
     * Sanitize Float
     * 
     * @param Mixed $input Input to sanitize
     * @return Float 
     */
    public function filterFloat($input) {
        return (float)filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * Sanitize Integer
     * 
     * @param Mixed $input Input to sanitize
     * @return Integer 
     */
    public function filterInteger($input) {
        return (int)filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Sanitize Integer
     * 
     * @param Mixed $input Input to sanitize
     * @return Integer 
     */
    public function filterIntegerRange($input, $min, $max) {
        return (int)filter_var($input, FILTER_SANITIZE_NUMBER_INT, Array('min_range' => $min, 'max_range' => $max));
    }

    /**
     * Sanitize Html entities
     * 
     * @param String $input Input to sanitize
     * @return String 
     */
    public function filterHtml($input) {
        return filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * Sanitize String
     * 
     * @param String $input Input to sanitize
     * @return String 
     */
    public function filterString($input) {
        return filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    }

    /**
     * Sanitize string (avoid null char)
     * 
     * @param String $input 
     * @return String
     */
    public function filterNullChar($input) {
        return str_replace(chr(0), '', $input);
    }

    /* ----- Type validation functions ----- */

    /**
     * Return true if $input is a valide eamil address
     * 
     * @param Mixed $input Input to check
     * @see http://atranchant.developpez.com/code/validation/
     * @return Boolean 
     */
    public function validateEmail($input) {
        $before = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';  /* Char accepted before @ */
        $after = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; /* Char accepted after @ */
        $regex = "/^$before+(\.$before+)*@($after{1,63}\.)+$after{2,63}$/i";

        return preg_match($regex, $input);
    }

}

?>
