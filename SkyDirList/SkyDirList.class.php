<?php

/**
 * PHP CLASS - Directory listing class
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
 * Class SkyDirList
 */
class SkyDirList {

    /**
     * Root directory path
     *
     * @var String 
     */
    private $path = '';

    /**
     * Recursive process status
     * 
     * @var Boolean 
     */
    private $recursive = false;

    /**
     * Create a new SkyDirList object based on specified root directory
     * 
     * @param String $path Root directory path
     * @param Boolean $recursive Set to true to enable recursivity
     * @throws Exception 
     */
    public function __construct($path, $recursive = false) {
        
        /* Check argments */
        if(!is_bool($recursive))
            throw new Exception('Recursion option must be a boolean !');
        
        /* Store usefull variable */
        $this->path = $path;
        $this->recursive = $recursive;

        /* Check if root directory is readable and is really a directory */
        if (!is_dir($path) || !is_readable($path))
            /* If not drop exception */
            throw new Exception('Root directory is not readable !');
    }

    /**
     * Return the representation of root directory in Array form
     * 
     * @return Array
     */
    public function getTree() {

        /* Start process */
        return $this->process($this->path);
    }

    /**
     * Recursive process function
     * 
     * @param String $dir Root directory path
     * @return Array
     * @throws Exception 
     */
    private function process($dir) {

        /* Instanciate result array */
        $res = Array();

        /* Open directory */
        $handle = opendir($dir);

        /* If something fail */
        if (!$handle)
        /* Drop exception */
            throw new Exception('Directory is not readable !');

        /* For each entry of directory */
        while (($file = readdir($handle))) {

            /* Process all files and directory excepted current and parent directory link */
            if ($file != '.' && $file != '..') {

                /* Test if entry is a sub directory and if recursivity is enable */
                if (is_dir($dir . '/' . $file) && $this->recursive) {

                    /* If yes launch recursivity on sub directory, and add sub result array to current result array */
                    $res[$file] = $this->process($dir . '/' . $file);

                    /* Else test if entry is a normal file (avoid following symbolic link) */
                } else if (is_file($dir . '/' . $file)) {

                    /* If yes add it to result array */
                    $res[$file] = null;
                }
            }
        }

        /* Close directory */
        closedir($handle);

        /* Return result array */
        return $res;
    }

}

?>
