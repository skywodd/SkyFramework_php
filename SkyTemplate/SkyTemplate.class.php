<?php

/**
 * PHP CLASS - Simple and user friendly template engine
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
 * 15/05/2012 - Initial commit
 * 
 */

/* Avoid direct access to script */
if (!defined('APPS_RUNNING'))
    die('<h1>Direct access to php class is not allowed.</h1>');

/**
 * Class SkyTemplate
 */
class SkyTemplate {

    const COMPILED_FILE_EXT = 'html';

    /**
     * Timeout options 
     */
    const NO_TIMEOUT = 0;

    /**
     * Block status 
     */
    const VISIBLE = true;
    const HIDDEN = false;

    /**
     * Path to template directory
     * 
     * @var String 
     */
    private $templateDirectory = '';

    /**
     * Path to cache directory
     * 
     * @var String 
     */
    private $cacheDirectory = '';

    /**
     * Result of template parsing
     * 
     * @var String 
     */
    private $parseResult = '';

    /**
     * Path to cache file
     * 
     * @var String 
     */
    private $cacheFilename = null;

    /**
     * Path to template file
     * 
     * @var String 
     */
    private $templateFilename = null;

    /**
     * Timeout limit of cache file
     * 
     * @var Integer 
     */
    private $cacheTimeout = self::NO_TIMEOUT;

    /* ---- Template Arguments Array ---- */

    /**
     * List of global simple template variable
     * 
     * @var Array 
     */
    private $varList = Array();

    /**
     * List of namespaced adressable template variable (for loops)
     * 
     * @var Array 
     */
    private $arrayNamespaceList = Array();

    /**
     * List of blocks name and status (true = visible, false = hidden)
     * 
     * @var Array 
     */
    private $blockList = Array();

    /**
     * Set to true when loop processing is finished
     * 
     * @var Boolean 
     */
    private $processFinished = false;

    /**
     * Create a new SkyTemplate object using specified arguments
     * 
     * @param String $templateDirectory Path to template directory
     * @param String $cacheDirectory Path to cache directory
     * @throws Exception 
     */
    public function __construct($templateDirectory, $cacheDirectory) {

        /* Store usefull variables */
        $this->cacheDirectory = $cacheDirectory;
        $this->templateDirectory = $templateDirectory;

        /* Check if cache directory is readable and writable */
        if (!is_writable($cacheDirectory) || !is_readable($cacheDirectory))
        /* If not drop exception */
            throw new Exception('Cache directory does not exist or is not readable/writable.');

        /* Check if template directory is readable */
        if (!is_readable($templateDirectory))
        /* If not drop exception */
            throw new Exception('Template directory does not exist or is not readable.');
    }

    /* ---- Template engine management functions ---- */

    /**
     * Open a template file for parsing
     * 
     * @param String $templateFilename Filename of template file
     * @throws Exception 
     */
    public function open($templateFilename) {

        /* Compute and store template filename */
        $this->templateFilename = $this->templateDirectory . '/' . $templateFilename;

        /* Check if template file is readable */
        if (!is_readable($this->templateFilename))
        /* If not drop exception */
            throw new Exception('Template file does not exist or is not readable.');

        /* Get content of template file into buffer */
        $this->parseResult = file_get_contents($this->templateFilename);

        /* Check for error */
        if ($this->parseResult === false)
        /* If something fail drop exception */
            throw new Exception('Unable to get template file content !');
    }

    /**
     * Free memory used by buffer
     */
    public function close() {

        /* If buffer is not empty */
        if (isset($this->parseResult))
        /* Flush it to free memory */
            unset($this->parseResult);
    }

    /**
     * Setting up cache engine for cache management
     * 
     * @param type $cacheFilename Output cache file
     * @param type $timeout Timeout of cached file (in MINUTES)
     */
    public function setCache($cacheFilename, $timeout) {

        /* Check arguments */
        if (!is_string($cacheFilename))
            throw new Exception('Cache filename must be a string !');
        if ($cacheFilename == '')
            throw new Exception('Cache filename must be not empty !');

        if (!is_numeric($timeout))
            throw new Exception('Timeout must be a numeric !');
        if ($timeout < 0)
            throw new Exception('Timeout must be greater or equal than 0 !');

        /* Store usefull variables */
        $this->cacheTimeout = $timeout;
        $this->cacheFilename = $this->cacheDirectory . '/' . $cacheFilename;
    }

    /**
     * Add global variable to template arguments
     * 
     * @param String $varName Template variable name
     * @param String $value Template variable value
     */
    public function addSimpleVar($varName, $value) {

        /* Check arguments */
        if (!is_string($varName))
            throw new Exception('Variable name must be a string !');
        if ($varName == '')
            throw new Exception('Variable name must be not empty !');
        if (!is_string($value))
            throw new Exception('Variable value must be a string !');
        if ($value == '')
            throw new Exception('Variable value must be not empty !');

        /* Add value to list */
        $this->varList[$varName] = $value;
    }

    /**
     * Add global variable to template arguments
     * 
     * @param Array $varArr Array of template variable name / value
     */
    public function addArrayVar($varArr) {

        /* Check arguments */
        if (!is_array($varArr))
            throw new Exception('Variables array must be a array ! (obvious ...)');

        /* Add value to list */
        $this->varList = array_merge($this->varList, $varArr);
    }

    /**
     * Add namespaced addressable variable to template arguments
     * 
     * @param String $namespace Namespace of variable
     * @param String $varName Name of variable in namespace
     * @param Array $value Array of value of variable
     */
    public function addNamespaceVar($namespace, $varName, $value) {

        /* Check arguments */
        if (!is_string($namespace))
            throw new Exception('Namespace must be a string !');
        if ($namespace == '')
            throw new Exception('Namespace must be not empty !');
        if (!is_string($varName))
            throw new Exception('Variable name must be a string !');
        if ($varName == '')
            throw new Exception('Variable name must be not empty !');
        if (!is_array($value))
            throw new Exception('Variable values array must be a array !');

        /* If namespace not exist in list */
        if (!isset($this->arrayNamespaceList[$namespace]))
        /* Create it */
            $this->arrayNamespaceList[$namespace] = Array();

        /* Add values to list at correct namespace */
        $this->arrayNamespaceList[$namespace][$varName] = $value;
    }

    /**
     * Add block status to template arguments
     * 
     * @param String $blockName Block name
     * @param Boolean $status Block status (VISIBLE or HIDDEN)
     */
    public function addBlock($blockName, $status) {

        /* Check arguments */
        if (!is_string($blockName))
            throw new Exception('Block name must be a string !');
        if ($blockName == '')
            throw new Exception('Block name must be not empty !');
        if (!is_bool($status))
            throw new Exception('Block status must be a boolean !');

        /* Add block status to list */
        $this->blockList[$blockName] = $status;
    }

    /**
     * Load template file and process it with specified Tags, Blocks, and Vars.
     * 
     * @throws Exception
     * @return Integer 
     */
    public function parse() {

        /* Keep starting time for benchmark */
        $start = microtime();

        /* Process includes */
        $this->parseResult = preg_replace_callback('#<!--[ ]+INCLUDE[ ]([^ ]+)[ ]+-->#i', Array($this, 'callback_includes'), $this->parseResult);

        /* Process blocks */
        $this->parseResult = preg_replace_callback('#<!--[ ]+BLOCK[ ]([^ ]+)[ ]+-->(.*)<!--[ ]+END[ ]\\1[ ]+-->#ism', Array($this, 'callback_blocks'), $this->parseResult);

        /* Process global variables */
        $this->parseResult = preg_replace_callback('#{[ ]*([^ .}]*)[ ]*}#i', Array($this, 'callback_vars'), $this->parseResult);

        /* Process loop */
        $this->parseResult = preg_replace_callback('#<!--[ ]+LOOP[ ]([^ ]+)[ ]+-->(.*)<!--[ ]+END[ ]\\1[ ]+-->#ism', Array($this, 'callback_loops'), $this->parseResult);

        return microtime() - $start;
    }

    /**
     * Return current buffer content
     * 
     * @return String 
     */
    public function getOutput() {

        /* Return buffer content */
        return $this->parseResult;
    }

    /* ---- Low level template callback ---- */

    /**
     * Callback for include tag <!-- INCLUDE template.tpl -->
     * 
     * @param Array $matches Preg_replace callback result arguments
     * @return String 
     */
    private function callback_includes($matches) {

        /* Compute include file path */
        $filename = $this->templateDirectory . '/' . $matches[1];

        /* Check if file exist and is readable */
        if (!is_readable($filename))
        /* If not ignore include and drop an HTML comment instead */
            return "<!-- Impossible to include $filename -->";

        /* Return file content */
        $content = file_get_contents($filename);

        /* Check for error */
        if ($content === false)
        /* If something fail drop exception */
            throw new Exception('Unable to get included file content !');

        return $content;
    }

    /**
     * Callback for block tag <!-- BLOCK johndoe --> (...) <!-- END johndoe -->
     * 
     * @param Array $matches Preg_replace callback result arguments
     * @return String 
     */
    private function callback_blocks($matches) {

        /* Check if block is registered in template arguments */
        if (!array_key_exists($matches[1], $this->blockList))
        /* if not ignore block statement and drop an HTML comment instead */
            return "<!-- Unknown block ${matches[1]} -->";

        /* Return content according block state */
        if ($this->blockList[$matches[1]] === true)
            return $matches[2];
        else
            return '';
    }

    /**
     * Callback for variables tag {varname}
     *
     * @param Array $matches Preg_replace callback result arguments
     * @return String 
     */
    private function callback_vars($matches) {

        /* Check if variable is registered in template arguments */
        if (!array_key_exists($matches[1], $this->varList))
        /* if no valid namespace found, ignore block statement and drop an HTML comment instead */
            return "<!-- Unknown variable ${matches[1]} -->";

        /* Return variable value */
        return $this->varList[$matches[1]];
    }

    /**
     * Callback for namespaced variables tag {namespace.varname}
     *
     * @param Array $matches Preg_replace callback result arguments
     * @return String 
     */
    private function callback_namespace_vars($matches) {

        /* Check if variable is registered in template arguments */
        if (!array_key_exists($matches[1], $this->arrayNamespaceList))
        /* if no valid namespace found, ignore block statement and drop an HTML comment instead */
            return "<!-- Unknown variable ${matches[1]}.${matches[2]} -->";

        /* Check if variable is registered in template arguments */
        if (!array_key_exists($matches[2], $this->arrayNamespaceList[$matches[1]]))
        /* if no valid namespace found, ignore block statement and drop an HTML comment instead */
            return "<!-- Unknown variable ${matches[1]}.${matches[2]} -->";

        /* Get variable value */
        $res = current($this->arrayNamespaceList[$matches[1]][$matches[2]]);

        /* If array is finish, stop processing */
        if (next($this->arrayNamespaceList[$matches[1]][$matches[2]]) === false)
            $this->processFinished = true;

        /* Return result value */
        return $res;
    }

    /**
     * Callback for loop tag <!-- LOOP johndoe --> (...) <!-- END johndoe -->
     *
     * @param Array $matches Preg_replace callback result arguments
     * @return String 
     */
    private function callback_loops($matches) {

        /* Declare result string */
        $result = '';

        /* Check if loop is registered in template arguments */
        if (!array_key_exists($matches[1], $this->arrayNamespaceList))
        /* if not ignore block statement and drop an HTML comment instead */
            return "<!-- Unknown loop ${matches[1]} -->";

        /* Process not finished */
        $this->processFinished = false;

        /* Rewind each template loop arguments */
        foreach ($this->arrayNamespaceList[$matches[1]] as $key => $value) {
            reset($this->arrayNamespaceList[$matches[1]][$key]);
        }

        /* For each key of arguments array */
        while (!$this->processFinished) {
            /* replace tags name with value */
            $result .= preg_replace_callback('#{[ ]*([^ .}]*)[.]([^ }]*)[ ]*}#i', Array($this, 'callback_namespace_vars'), $matches[2]);
        }

        /* Return result string */
        return $result;
    }

    /* ---- Cache management functions ---- */

    /**
     * Save to cache the current content of buffer 
     * 
     * @throws Exception 
     */
    public function toCache() {

        /* Open cache file in write w/ erasing mode */
        $fo = fopen($this->cacheFilename, 'w+');

        /* Check if fopen fail */
        if ($fo === null)
        /* If yes drop exception */
            throw new Exception('Cannot open cache file for writting.');

        /* Write buffer to cache */
        fwrite($fo, $this->parseResult);

        /* Close file handle */
        fclose($fo);
    }

    /**
     * Return TRUE if a cached version of current template exist and is not timed out
     * 
     * @return boolean 
     */
    public function isCached() {

        /* Check if cache file is readable */
        if (!is_readable($this->cacheFilename))
        /* If not return false */
            return false;

        /* Get file create time and check it against stored timeout */
        if ((time() - filemtime($this->cacheFilename)) >= ($this->cacheTimeout * 60))
        /* If timeout is exceded file is (virtualy) not in cache */
            return false;
        else
        /* If timeout is not exceded file is cached ! */
            return true;
    }

    /**
     * Delete cached version of template from cache
     */
    public function deleteFromCache() {

        /* File exist, delete it */
        if (unlink($this->cacheFilename) == false)
        /* If something fail drop exception */
            throw new Exception('Unable to unlink cache file !');
    }

    /**
     * Get previous processed template file from cache into buffer
     */
    public function getFromCache() {

        /* Get content of cache file into buffer */
        $this->parseResult = file_get_contents($this->cacheFilename);

        /* Check for error */
        if ($this->parseResult === false)
        /* If something fail drop exception */
            throw new Exception('Unable to get cached file content !');
    }

    /**
     * Delete all cache files of cache directory
     */
    public function cleanCache() {

        /* Get cache directory listing */
        $cDir = dir($this->cacheDirectory);

        /* Check for error */
        if ($cDir === false)
        /* If something fail drop exception */
            throw new Exception('Unable to get cached file content !');

        /* For each entry in directory listing */
        while ($entry = $cDir->read()) {

            /* Compute file path */
            $filename = $this->cacheDirectory . '/' . $entry;

            /* Process each cache files */
            if (is_file($filename) && end(explode('.', $entry)) == self::COMPILED_FILE_EXT)
            /* Delete file from disk */
                if (unlink($filename) == false)
                /* If something fail drop user error message */
                    user_error('Unable to unlink file ' . $filename, E_USER_ERROR);
        }

        /* Close directory listing cursor */
        $cDir->close();
    }

    /**
     * Destroy SkyTemplate object 
     */
    public function __destruct() {

        /* Free buffer */
        $this->close();
    }

}

?>
