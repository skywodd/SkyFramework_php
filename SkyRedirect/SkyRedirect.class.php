<?php

/**
 * PHP CLASS - Page redirector for url rewriting support
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
 * Class SkyRedirect
 */
class SkyRedirect {

    /**
     * Associative array of pages / index
     * At least array must contain 'default' and 'error' pages.
     * 
     * @var Array 
     */
    private $pages = Array();

    /**
     * Array used for redirection
     * 
     * @var Array 
     */
    private $source = Array();

    /**
     * Index in $source used for redirection
     *
     * @var String 
     */
    private $index = '';

    /**
     * Create a new page redirector
     * 
     * @param Array $pages Associative array of pages / index, at least array must contain 'default' and 'error' pages.
     * @param Array $source Array to use for redirection
     * @param String $index Index in $source to use for redirection
     * @throws Exception 
     */
    public function __construct($pages, $source, $index) {

        /* Check arguments */
        if (!is_array($pages))
            throw new Exception('Pages redirection array must be an array !');
        if (count($pages) == 0 || !isset($pages['default']) || !isset($pages['error']))
            throw new Exception('Pages redirection array must contain at least default and error pages !');
        if (!is_array($source))
            throw new Exception('Source array must be an array !');
        if (!is_string($index))
            throw new Exception('Index must be a string !');
        if ($index == '')
            throw new Exception('Index must be not empty !');

        /* Store usefull variables */
        $this->pages = $pages;
        $this->source = $source;
        $this->index = $index;
    }

    /**
     * Process redirection
     */
    public function redirect() {

        /* Check if redirection index is set */
        if (!isset($this->source[$this->index]) || empty($this->source[$this->index])) {
            
            /* If not include default page */
            include $this->pages['default'];
            return;
        }

        /* Check if requested page is accessible */
        if (isset($this->pages[$this->source[$this->index]])) {

            /* If yes include it */
            include $this->pages[$this->source[$this->index]];

            /* Else if not */
        } else {
            
            /* Include error page */
            include $this->pages['error'];
        }
    }

}

?>
