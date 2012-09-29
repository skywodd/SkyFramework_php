<?php

/**
 * PHP CLASS - User-friendly users account validation wrapper
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
 * Class SkyValidation
 */
class SkyValidation {

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
     * User id of currently ued user
     *
     * @var Integer
     */
    private $userId = -1;

    /**
     * User ticket
     * 
     * @var String
     */
    private $ticket = '';

    /**
     * Create a new SkyValidation controler
     *
     * @param String $table Validation table name in database
     */
    public function __construct($table) {

        /* Retrieve current SkySql instance */
        $this->sql = SkySql::getInstance();

        /* Store database table name */
        $this->table = $this->sql->escape($table);
    }

    /**
     * Open ticket by user id 
     * 
     * @param Integer $userId User id
     * @throws Exception 
     */
    public function openById($userId) {

        /* Check argument */
        if (!is_numeric($userId))
            throw new Exception('User id must be a string !');
        if ($userId < 0)
            throw new Exception('User id must be greater than 0 !');

        /* Check if another user ticket still exist */
        if ($this->userId != -1)
        /* If yes drop exception */
            throw new Exception('Previous ticket info have not be closed !');

        /* Send sql query */
        $request = $this->sql->query('SELECT * FROM ' . $this->table . ' WHERE user_id = ' . (int) $userId);

        /* Check for error */
        if ($request === false)
        /* If something fail drop exception */
            throw new Exception('Something fail during sql request (open user) !');

        /* Fetch first result row */
        $raw = $request->fetch_assoc();

        /* Check if query have return something */
        if ($request->num_rows != 0)
        /* If yes store user ticket */
            $this->ticket = $raw['ticket'];

        /* Save user id */
        $this->userId = $userId;

        /* Free resources used by sql request */
        $request->close();
    }

    /**
     * Return true if user have a ticket available 
     * 
     * @return Boolean
     */
    public function hasTicket() {
        return ($this->ticket != '');
    }

    /**
     * Return the 13 length string of user ticket
     * 
     * @return String
     * @throws Exception 
     */
    public function getTicket() {

        /* Check if user have ticket */
        if ($this->ticket == '')
            throw new Exception('No ticket available !');

        /* Return ticket */
        return $this->ticket;
    }

    /**
     * Insert a new ticket id in database for user
     * 
     * @return String 
     */
    public function createTicket() {

        /* Check if user have been openned */
        if ($this->userId == -1)
        /* If yes drop exception */
            throw new Exception('No user info openned !');

        /* Generate ticket */
        $this->ticket = uniqid();

        /* Send sql query */
        $request = $this->sql->query('INSERT INTO ' . $this->table . '(user_id, ticket) VALUE (\'' . (int) $this->userId . '\', \'' . $this->ticket . '\')');

        /* Check for error */
        if ($request === false || $this->sql->affected_rows != 1)
        /* If something fail drop exception */
            throw new Exception('Something fail during sql request (open user) !');
    }

    /**
     * Return true if user ticket is valid 
     * 
     * @param String $ticket
     * @return Boolean 
     */
    public function validateTicket($ticket) {
        return ($this->ticket == $ticket);
    }

    /**
     * Delete ticket(s) of user in database
     * 
     * @throws Exception 
     */
    public function deleteTicket() {

        /* Check if user have been openned */
        if ($this->userId == -1)
        /* If yes drop exception */
            throw new Exception('No user info openned !');

        /* Send sql query */
        $request = $this->sql->query('DELETE FROM ' . $this->table . ' WHERE user_id = ' . (int) $this->userId);

        /* Check for error */
        if (!$request || $this->sql->affected_rows != 1)
        /* Somehting fail, drop exception */
            throw new Exception('Something have fail during ticket delete !');

        /* Delete previous user data */
        $this->close();
    }

    /**
     * Close user info  
     */
    public function close() {

        /* Reset variable */
        $this->ticket = '';
        $this->userId = -1;
    }

}

?>
