<?php

/**
 * PHP CLASS - Html form validation class
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
 * Class SkyFormCheck
 */
class SkyFormCheck {

    /**
     * Array of input names to check
     * 
     * @var Array 
     */
    private $inputs = Array();

    /**
     * Source of data, usually $_POST or $_GET
     * 
     * @var Array 
     */
    private $source = Array();

    /**
     * Create a new SkyFormCheck object based on specifed source array
     * 
     * @param Array $source Source of data, usually $_POST or $_GET
     * @throws Exception 
     */
    public function __construct($source) {

        /* Check argument */
        if (!is_array($source))
            throw new Exception('Source array must be an array !');

        /* Store source location */
        $this->source = $source;
    }

    /**
     * Name of input to check
     * 
     * @param String $name 
     * @throws Exception 
     */
    public function addInput($name) {

        /* Check argument */
        if (!is_string($name))
            throw new Exception('Input name must be a string !');
        if ($name == '')
            throw new Exception('Input name must be not empty !');

        /* Add input to global inputs array */
        $this->inputs[] = $name;
    }

    /**
     * Array of inputs name to check
     * 
     * @param Array $names 
     * @throws Exception 
     */
    public function addInputs($names) {

        /* Check argument */
        if (!is_array($names))
            throw new Exception('Inputs name array must be an array !');

        /* Add inputs to global inputs array */
        $this->inputs = array_merge($this->inputs, $names);
    }

    /**
     * Return true if form is fully completed, false otherwise
     * 
     * @return Boolean 
     */
    public function isComplete() {

        /* For each input of global inputs array */
        foreach ($this->inputs as $input) {

            /* Check if input exist and is not empty */
            if (!array_key_exists($input, $this->source) || trim($this->source[$input]) == '')
            /* If not return false */
                return false;
        }

        /* Otherwise if all is good return true */
        return true;
    }

    /**
     * Return value of input
     * 
     * @param String $name
     * @throws Exception 
     * @return String 
     */
    public function getValue($name) {

        /* Check argument */
        if (!is_string($name))
            throw new Exception('Input name must be a string !');
        if ($name == '')
            throw new Exception('Input name must be not empty !');

        /* Check if value exist in source array */
        if (!array_key_exists($name, $this->source))
        /* If not return null */
            return null;

        /* Return value from source directly */
        return $this->source[$name];
    }

}

?>
