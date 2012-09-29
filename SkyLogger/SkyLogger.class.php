<?php

/**
 * PHP CLASS - Logging system with syslog like verbosity level
 * 
 * @author SkyWodd
 * @version 1
 * @link http://skyduino.wordpress.com
 * @see W3C DateTime Format : Y-m-d\TH:i:sP (eg 2012-03-23T08:34:00+00:00)
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
 * Class SkyLogger
 */
class SkyLogger {
    /**
     * Verbose Level (syslog like) 
     * EMERGENCY : Fatal error, system unusable
     * ALERT : Immediate intervention necessary
     * CRITICAL : Critical system error
     * ERROR : Functionnal error
     * WARNING : Simple warning
     * NOTICE : Noticable message
     * INFORMATION : Usefull message
     * DEBUG : Debugging message
     * NONE : No log output
     */

    const NONE = -1;
    const EMERGENCY = 0;
    const ALERT = 1;
    const CRITICAL = 2;
    const ERROR = 3;
    const WARNING = 4;
    const NOTICE = 5;
    const INFORMATION = 6;
    const DEBUG = 7;

    /**
     * Convertion table 
     * String to level, or level to string 
     *
     * @var Array
     */
    public $levelTable = Array(
        'EMERGENCY' => 0, 'ALERT' => 1,
        'CRITICAL' => 2, 'ERROR' => 3,
        'WARNING' => 4, 'NOTICE' => 5,
        'INFORMATION' => 6, 'DEBUG' => 7,
        0 => 'EMERGENCY', 1 => 'ALERT',
        2 => 'CRITICAL', 3 => 'ERROR',
        4 => 'WARNING', 5 => 'NOTICE',
        6 => 'INFORMATION', 7 => 'DEBUG');

    /**
     * Oversize Mode 
     */

    const O_TRUNC = 1;
    const O_ROTATE = 2;

    /**
     * Shared instance of class 
     *
     * @var SkyLogger
     */
    private static $instance = null;

    /**
     * Output filename, including directory and extension (usually xxxx.log)
     * 
     * @var String 
     */
    private $outputFilename = '';

    /**
     * File handle to output log file
     * 
     * @var Resource 
     */
    private $outputFileHandle = false;

    /**
     * Verbosity level of log
     * 
     * @var Integer 
     */
    private $outputLevel = 0;

    /**
     * Size limit of output log file (in Mo)
     * 
     * @var Integer
     */
    private $outputSizeLimit = 0;

    /**
     * Action to take when log file is oversized
     * 
     * @var Integer 
     */
    private $oversizeMode = 0;

    /**
     * Create a new SkyLogger object using specified arguments
     *
     * @param String $directory Absolute or relatif path to logging directory
     * @param String $filename Filename of output log file
     * @param Integer $level Verbosity level (default ERROR)
     * @param Integer $sizeLimit Maximum size of log file in Mo (default 5Mo)
     * @param Integer $oversizeMode Action to take when log file get oversized (default Truncate)
     * @throws Exception 
     */
    public function __construct($directory, $filename, $level = self::ERROR, $sizeLimit = 5, $oversizeMode = O_TRUNC) {

        /* Check arguments */
        if (!is_numeric($level))
            throw new Exception('Verbosity level must be a numeric !');
        if ($level < self::NONE || $level > self::DEBUG)
            throw new Exception('Verbosity level must be between -1 and 7 !');
        if (!is_numeric($sizeLimit))
            throw new Exception('File size limit must be a numeric !');
        if ($sizeLimit < 1)
            throw new Exception('File size limit must be greater than 1 !');
        if ($oversizeMode != self::O_ROTATE && $oversizeMode != self::O_TRUNC)
            throw new Exception('Oversize action must be O_TRUNC or O_ROTATE !');

        /* Check if a previous instance allready exist */
        if (self::$instance != NULL)
        /* If yes drop exception (don't overwrite previous instance) */
            throw new Exception('Previous instance allready created !');

        /* Store usefull variables */
        $this->outputLevel = (int) $level;
        $this->outputSizeLimit = (int) $sizeLimit;
        $this->oversizeMode = (int) $oversizeMode;

        /* Check if logging directory exist and is writable */
        if (!is_writable($directory))
        /* If not drop exception */
            throw new Exception('Log directory does not exist or is not writable !');

        /* Compute and store output log filename */
        $this->outputFilename = $directory . '/' . $filename;

        /* Open output log file in append R/W mode */
        $this->outputFileHandle = fopen($this->outputFilename, 'a+');

        /* Check if openning fail */
        if ($this->outputFileHandle === false)
        /* If something goes wrong drop exception */
            throw new Exception('Cannot open log file !');

        /* Store instance for futur object instanciation */
        self::$instance = $this;
    }

    /**
     * Set __clone() to private to avoid cloning
     */
    private function __clone() {
        
    }

    /**
     * Return previous instancied SkyLogger object
     * 
     * @return SkyLogger
     * @throws Exception 
     */
    public static function getInstance() {

        /* Look for a previous instance */
        if (self::$instance == NULL)
        /* If no previous instance found drop exception */
            throw new Exception('No previous instance found !');

        /* Return previous instancied object */
        return self::$instance;
    }

    /**
     * Close the log file and destroy current instance
     */
    public function close() {

        /* Check if output file is open */
        if ($this->outputFileHandle === false)
        /* If not ignore function call */
            return;

        /* Free handle used by output log file */
        fclose($this->outputFileHandle);

        /* Unset handle used by output log file */
        $this->outputFileHandle = false;

        /* Destroy current instance */
        self::$instance = null;
    }

    /**
     * Sync data in buffer to disk
     * 
     * @throws Exception 
     */
    public function sync() {

        /* Check if output file is open */
        if ($this->outputFileHandle === false)
        /* If not drop exception */
            throw new Exception('Cannot sync a closed log !');

        /* Sync data in buffer with disk */
        fflush($this->outputFileHandle);
    }

    /**
     * Flush current log file and sync data to disk
     * 
     * @throws Exception 
     */
    public function flush() {

        /* Check if output file is open */
        if ($this->outputFileHandle === false)
        /* If not drop exception */
            throw new Exception('Cannot flush a closed log.');

        /* Truncate file to 0 byte */
        ftruncate($this->outputFileHandle, 0);

        /* Sync data in buffer with disk */
        fflush($this->outputFileHandle);
    }

    /**
     * Rotate log (need to be overload with custom archiving and management methods)
     * 
     * @throws Exception 
     */
    public function rotate() {
        throw new Exception('Need to be overload with custom archiving and management methods !');
    }

    /**
     * Delete log file
     * 
     * @throws Exception 
     */
    public function destroy() {

        /* Close log file */
        $this->close();

        /* Delete log file from disk */
        if (unlink($this->outputFilename) == false)
        /* If something fail drop exception */
            throw new Exception('Cannot delete log file !');
    }

    /**
     * Return size in Mo of log file
     *
     * @throws Exception 
     * @return Integer
     */
    public function getSize() {

        /* Get log file size */
        $nbBytes = filesize($this->outputFilename);

        /* If filesize() fail */
        if ($nbBytes === false)
        /* Drop exception */
            throw new Exception('Cannot return size of file !');

        /* Return size in Mo */
        return round($nbBytes / 1048576, 2);
    }

    /**
     * Read and parse a line from log file
     *
     * @throws Exception 
     * @return Array
     */
    private function read() {

        /* Get entire line from log file */
        $line = fgets($this->outputFileHandle);

        /* Check for error */
        if ($line === false)
            return null;

        /* Initialise sscanf variables */
        $datetime = null;
        $type = null;
        $remote = null;
        $msg = null;

        /* Scan and extract values from line */
        /* Line format : JJ/MM/YY HH:MM:SS TYPE REMOTE_IP MSG\n */
        $n = sscanf($line, "%s %s %s %[^\n]", $datetime, $type, $remote, $msg);

        /* Check if sscanf have successfully extract all values */
        if ($n != 4)
        /* If not drop exception */
            throw new Exception('Cannot extract all data from log file line !');

        /* Return dictionnary of values */
        return Array('datetime' => $datetime, 'level' => $this->levelTable[$type], 'remote' => $remote, 'msg' => $msg);
    }

    /**
     * Get all log entries
     *
     * @param Integer $limit Maximum numbers of entry to list (default 500)
     * @return Array
     * @throws Exception 
     */
    public function getAll($limit = 500) {

        /* Check argument */
        if (!is_numeric($limit))
            throw new Exception('Limit must be a numeric !');

        /* Check if log file is open */
        if ($this->outputFileHandle === false)
        /* If not drop exception */
            throw new Exception('Cannot process a closed log !');

        /* Instanciate Array */
        $ret = Array();

        /* Backup file cursor position */
        $seek = ftell($this->outputFileHandle);

        /* Go to the beginning of file */
        fseek($this->outputFileHandle, 0);

        /* Initialize interator */
        $i = 0;
        
        /* Read one line from file */
        $cur = $this->read();

        /* While not end of file */
        while (!feof($this->outputFileHandle) || is_null($cur) && $i < $limit) {
            
            /* Increment iterator */
            $i++;

            /* Store line values into array */
            array_push($ret, $cur);

            /* Read one line from file */
            $cur = $this->read(); 
        }

        /* Restore file cursor position */
        fseek($this->outputFileHandle, $seek);

        /* Return array (of array) */
        return $ret;
    }

    /**
     * Write a message into log file
     * (Note: NewLine are trimmed to space during process)
     *
     * @param Integer $level Verbosity level of message
     * @param String $msg Message to log
     * @throws Exception 
     */
    public function write($level, $msg) {

        /* If verbosity level of msg is upper than logging level */
        if ($level > $this->outputLevel)
        /* Ignore function call */
            return;

        /* Check if output file is open */
        if ($this->outputFileHandle === false)
        /* If not drop exception */
            throw new Exception('Cannot write to a closed log !');

        /* If log file size trigger output maximum size */
        if ($this->getSize() >= $this->outputSizeLimit)
        /* Take appropriate action */
            if ($this->oversizeMode == O_TRUNC)
            /* Flush current log file before writting */
                $this->flush();
            else
            /* Rotate log (call overloaded custom method) */
                $this->rotate();

        // TODO write at beginning of file ! not at end ! (insert)
            
        /* Write message with logging informations into log file */
        fwrite($this->outputFileHandle, date(DATE_W3C) . ' ' . $this->levelTable[$level] . ' ' . $_SERVER['REMOTE_ADDR'] . ' ' . str_replace("\n", ' ', $msg) . "\n");

        /* Sync buffer with disk */
        fflush($this->outputFileHandle);
    }

}

?>