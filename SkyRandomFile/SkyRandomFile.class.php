<?php

/**
 * PHP CLASS - Select a random file (with extension filter) from a directory
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
 * Class SkyRandomFile
 */
class SkyRandomFile {

    /**
     * Source directory path of files
     * 
     * @var String 
     */
    private $path = '';

    /**
     * List of files extension to process
     * 
     * @var Array
     */
    private $extension = Array();

    /**
     * Create a new SkyRandomFile object based on specified source directory
     * 
     * @param String $path
     * @param Array $extension
     * @throws Exception 
     */
    public function __construct($path, $extension) {

        /* Check arguments */
        if (!is_array($extension))
            throw new Exception('Extension array must be an array !');
        if (count($extension) == 0)
            throw new Exception('Extension array must contain at least one extension !');

        /* Store source path */
        $this->path = $path;

        /* To avoid sensitive case extension all extension are shifted to upper case */
        foreach ($extension as $key => $value)
            $extension[$key] = strtoupper($value);

        /* Store normalized extension array */
        $this->extension = $extension;

        /* Check if source directory is ok */
        if (!is_dir($path) || !is_readable($path))
        /* If not drop exception */
            throw new Exception('Source directory is not readable !');
    }

    /**
     * Return the path to a random file from source directory
     * 
     * @return String
     * @throws Exception 
     */
    public function getPath() {

        /* Instanciate files names array */
        $files = Array();

        /* Open source directory */
        $handle = opendir($this->path);

        /* If something fail */
        if (!$handle)
        /* Drop exception */
            throw new Exception('Cannot open source directory !');

        /* For each entry of directory */
        while (( $file = readdir($handle) ) !== false) {
            /* Test if entry if a normal file and has an accepted extension */
            if (is_file($this->path . '/' . $file) && in_array(strtoupper(end(explode('.', $file))), $this->extension)) {

                /* If yes add his filename to files array */
                $files[] = $file;
            }
        }

        /* Close source directory */
        closedir($handle);

        /* Shuffle filenames array */
        shuffle($files);

        /* Return one filename from files array with directory path appended */
        return $this->path . '/' . end($files);
    }

}

?>
