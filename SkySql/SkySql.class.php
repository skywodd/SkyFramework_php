<?php

/**
 * PHP CLASS - MySql wrapper with user-friendly function
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
 * 03/05/2012 - Initial commit
 *              
 */

/* Avoid direct access to script */
if (!defined('APPS_RUNNING'))
    die('<h1>Direct access to php class is not allowed.</h1>');

/**
 * Class SkySql
 */
class SkySql extends mysqli {

    /**
     * Shared instance to class
     *
     * @var SkySql
     */
    private static $instance = null;

    /**
     * Total execution time of sql requests
     * 
     * @var Float 
     */
    private $executionTime = 0;

    /**
     * Total count of sql query
     * 
     * @var Integer 
     */
    private $requestCount = 0;

    /**
     * Create connection to MySql serve using specified arguments
     * 
     * @param String $host Hostname or IP of MySql server
     * @param String $username Username to use for connection
     * @param String $password Password to use for connection
     * @param String $database Database to use
     * @param Integer $port Port to use for connection
     * @throws Exception 
     */
    public function __construct($host, $username, $password, $database, $port = null) {

        /* Check if a previous instance allready exist */
        if (self::$instance != NULL)
        /* If yes drop exception (don't overwrite previous instance) */
            throw new Exception('Previous instance allready created.');

        /* Instanciate MySqli connection */
        parent::__construct($host, $username, $password, $database, $port);

        /* Store instance for futur object instanciation */
        self::$instance = $this;
    }

    /**
     * Set __clone() to private to avoid cloning
     */
    private function __clone() {
        
    }

    /**
     * Return previous instancied SkySql object
     * 
     * @return SkySql
     * @throws Exception 
     */
    public function getInstance() {

        /* Look for a previous instance */
        if (self::$instance == NULL)
        /* If no previous instance found drop exception */
            throw new Exception('No previous instance found !');

        /* Return previous instancied object */
        return self::$instance;
    }

    /**
     * Make query to MySql server and return answer
     * 
     * @param String $request : Sql query (don't forget to escape user input)
     * @return Resource 
     */
    public function query($request) {
        
        /* Check argument */
        if(!is_string($request))
            throw new Exception('Sql request must be a string !');
        if($request == '')
            throw new Exception('Sql request must be not empty !');

        /* Get current time */
        $startTime = microtime();

        /* Send query to database */
        $answer = parent::query($request);

        /* Increase global execution time by sql query time */
        $this->executionTime += microtime() - $startTime;

        /* Increment sql request counter */
        $this->requestCount++;

        /* Return sql result */
        return $answer;
    }

    /**
     * Return the last occured error code at connection
     * 
     * @return Integer 
     */
    public function getConnectError() {

        /* Return connection error code (if any) */
        return $this->connect_errno;
    }

    /**
     * Return the total time of sql request execution
     * 
     * @return Float 
     */
    public function getExecutionTime() {

        /* Return total time of sql execution */
        return $this->executionTime;
    }

    /**
     * Return the count of commited sql requests 
     *
     * @return Integer 
     */
    public function getQueryCount() {

        /* Return numbers of sql query requested */
        return $this->requestCount;
    }

    /**
     * Return the last occured error code and message
     * 
     * @return Array 
     */
    public function getLastError() {

        /* Return last error code and message (if any) */
        return array($this->errno, $this->error);
    }

    /**
     * Escape special sql char (for security)
     * 
     * @param String $str : String to escape
     * @return String 
     */
    public function escape($str) {

        /* Return escaped string (escape all sql special char) */
        return $this->real_escape_string($str);
    }

    /**
     * Close MySqli connection, and destroy SkySql instance
     */
    public function close() {

        /* Close MySqli connection */
        parent::close();

        /* Destroy current instance */
        self::$instance = NULL;
    }

}

?>