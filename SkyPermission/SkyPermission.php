<?php

/**
 * PHP CLASS - User-friendly groups permission controler
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
 * Class SkyPermission
 */
class SkyPermission {
    /**
     * ListBy shorting constants 
     */

    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * Sql instance pointer
     *
     * @var SkySql
     */
    private $sql = null;

    /**
     * Name of users table in database
     * 
     * @var String 
     */
    private $table = '';

    /**
     * Create a new SkyPermission controller
     * 
     * @param String $table Name of permissions table in database
     */
    public function __construct($table) {

        /* Retrieve current SkySql instance */
        $this->sql = SkySql::getInstance();

        /* Store database table name */
        $this->table = $this->sql->escape($table);
    }

    /**
     * Get permissions array associated with groupe id
     * 
     * @param Integer $groupeId Groupe Id
     * @throws Exception
     * @return Array
     */
    public function getPermission($groupeId) {

        /* Check argument */
        if (!is_numeric($groupeId))
            throw new Exception('Groupe id must be a numeric !');
        if ($groupeId < 0)
            throw new Exception('Groupe id must be greater than 0 !');

        /* Send sql query */
        $request = $this->sql->query('SELECT * FROM ' . $this->table . ' WHERE groupe_id = ' . (int) $groupeId);

        /* Check for error */
        if ($request === false)
        /* If something fail drop exception */
            throw new Exception('Something fail during sql request (open user) !');

        /* Check if query have return something */
        if ($request->num_rows == 0)
        /* If not user don't exist, return false */
            return null;

        /* Fetch first result row */
        $raw = $request->fetch_assoc();

        /* Free resources used by sql request */
        $request->close();

        /* No error */
        return $raw;
    }

    /**
     * Set permissions array associated with groupe id
     * 
     * @param Integer $groupeId Groupe Id
     * @throws Exception
     * @return Array
     */
    public function setPermission($groupeId, $permArr) {
        // TODO 
    }

    public function createPermission($permArr) {
        // TODO
    }

    public function deletePermission($groupeId) {
        // TODO
    }

    /**
     * Return true if user can do specified action
     * 
     * @param String $action
     * @param Array $permArr 
     * @throws Exception
     * @return Boolean
     */
    public function canDo($action, $permArr) {

        /* Check arguments */
        if (!is_string($action))
            throw new Exception('Action must be a string !');
        if ($action == '')
            throw new Exception('Action must be not empty !');
        if (!is_array($permArr))
            throw new Exception('Permission array must be an array !');

        /* Test if permission exist in array */
        if (array_key_exists($action, $permArr))
            throw new Exception('Unkown permission !');

        /* Return permission value */
        return (bool) $permArr[$action];
    }

    /**
     * List all permission in database shorted by groupe id
     * 
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @param String $mode Shorting mode (ASC or DESC)
     * @return Array 
     */
    public function listPermissionById($from, $to, $mode) {
        return $this->listPermissionBy('groupe_id', $from, $to, $mode);
    }

    /**
     * List all permission in database shorted by groupe name
     * 
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @param String $mode Shorting mode (ASC or DESC)
     * @return Array 
     */
    public function listPermissionByName($from, $to, $mode) {
        return $this->listPermissionBy('name', $from, $to, $mode);
    }

    /**
     * List all permission in database shorted by spécified index
     * 
     * @param String $by Index for shorting
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @param String $mode Shorting mode (ASC or DESC)
     * @return Array 
     */
    private function listPermissionBy($by, $from, $to, $mode) {

        /* Check arguments */
        if (!is_numeric($from))
            throw new Exception('Starting limit must be a numeric !');
        if (!is_numeric($to))
            throw new Exception('Stoping limit must be a numeric !');
        if ($mode != 'ASC' && $mode != 'DESC')
            throw new Exception('Shorting mode must be ASC or DESC !');
        if ($to < $from)
            throw new Exception('Starting limit must be lower than stoping limit !');

        /* Instanciate result array */
        $result = Array();

        /* Send sql query */
        $request = $this->sql->query('SELECT * FROM ' . $this->table . ' ORDER BY ' . $by . ' ' . $mode . ' LIMIT ' . (int) $from . ', ' . (int) $to);

        /* Check for error */
        if ($request === false)
        /* If something fail drop exception */
            throw new Exception('Something fail during sql request (list by) !');

        /* While data available */
        while (($row = $request->fetch_assoc())) {

            /* Create a copy of data */
            $row_strip = $row;

            /* Append data to result array */
            $result[$row[$by]] = $row_strip;
        }

        /* Free resources used by sql request */
        $request->close();

        /* Return result array */
        return $result;
    }

    /**
     * Search groups in database
     * 
     * @param String $name Name to search
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @return Array
     * @throws Exception 
     */
    public function searchByName($name, $from, $to) {

        /* Check arguments */
        if (!is_string($name))
            throw new Exception('Name must be a string !');
        if (!is_numeric($from))
            throw new Exception('Starting limit must be a numeric !');
        if (!is_numeric($to))
            throw new Exception('Stoping limit must be a numeric !');
        if ($to < $from)
            throw new Exception('Starting limit must be lower than stoping limit !');

        /* Instanciate result array */
        $result = Array();

        /* Send sql query */
        $request = $this->sql->query('SELECT * FROM ' . $this->table . ' WHERE name LIKE \'%' . $this->sql->escape($name) . '%\' ORDER BY name ASC LIMIT ' . (int) $from . ', ' . (int) $to);

        /* Check for error */
        if ($request === false)
        /* If something fail drop exception */
            throw new Exception('Something fail during sql request (search) !');

        /* While data available */
        while (($row = $request->fetch_assoc())) {

            /* Create a copy of data */
            $row_strip = $row;

            /* Append data to result array */
            $result[$row['name']] = $row_strip;
        }

        /* Free resources used by sql request */
        $request->close();

        /* Return result array */
        return $result;
    }

}

?>
