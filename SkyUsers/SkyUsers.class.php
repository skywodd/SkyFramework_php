<?php

/**
 * PHP CLASS - User-friendly users managing controler
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
 * Class SkyUser (User data wrapper)
 */
class SkyUser {

    /**
     * Array who store user account informations
     *
     * @var Array 
     */
    private $userParam = Array();

    /**
     * Create a new user structure
     * 
     * @param Array $source
     */
    public function __construct($source) {

        /* Store all specified arguments */
        $this->userParam = $source;
    }

    /**
     * Return the user id of user
     * 
     * @return Integer 
     */
    public function getUserId() {
        return (int) $this->userParam['user_id'];
    }

    /**
     * Return the nickname of user
     * 
     * @return String
     */
    public function getNickname() {
        return $this->userParam['nickname'];
    }

    /**
     * Return the display name of user
     * 
     * @return String 
     */
    public function getDisplayName() {
        return $this->userParam['display_name'];
    }

    /**
     * Set the display name of user
     * 
     * @param String $displayName 
     * @throws Exception 
     */
    public function setDisplayName($displayName) {

        /* Check argument */
        if (!is_string($displayName))
            throw new Exception('Display name must be a string !');

        $this->userParam['display_name'] = $displayName;
    }

    /**
     * Return the email address of user
     * 
     * @return String 
     */
    public function getEmail() {
        return $this->userParam['email'];
    }

    /**
     * Set the email address of user
     * 
     * @param String $email 
     * @throws Exception 
     */
    public function setEmail($email) {

        /* Check argument */
        if (!is_string($email))
            throw new Exception('Email address must be a string !');

        $this->userParam['email'] = $email;
    }

    /**
     * Return the password of user
     * 
     * @return String
     */
    public function getPassword() {
        return $this->userParam['password'];
    }

    /**
     * Set the password of user
     * 
     * @param String $password 
     * @throws Exception 
     */
    public function setPassword($password) {

        /* Check argument */
        if (!is_string($password))
            throw new Exception('Password must be a string !');

        $this->userParam['password'] = $password;
    }

    /**
     * Return the inscription date of user
     * 
     * @return String
     */
    public function getInscriptionDate() {
        return $this->userParam['inscription_date'];
    }

    /**
     * Return the last seen date of user
     * 
     * @return String
     */
    public function getLastSeenDate() {
        return $this->userParam['last_seen_date'];
    }

    /**
     * Set the last seen date of user
     * 
     * @param String $lastSeenDate 
     * @throws Exception 
     */
    public function setLastSeenDate($lastSeenDate) {

        /* Check argument */
        if (!is_string($lastSeenDate))
            throw new Exception('Last seen date must be a string !');

        $this->userParam['last_seen_date'] = $lastSeenDate;
    }

    /**
     * Set the sexe (M or F) of user
     * 
     * @param String $sexe
     * @throws Exception 
     */
    public function setSexe($sexe) {

        /* Check argument */
        if (!is_string($sexe))
            throw new Exception('Sexe must be a string !');

        $this->userParam['sexe'] = $sexe;
    }

    /**
     * Return the sexe of user
     * 
     * @return String 
     */
    public function getSexe() {

        return $this->userParam['sexe'];
    }

    /**
     * Set the region of user
     * 
     * @param String $region
     * @throws Exception 
     */
    public function setRegion($region) {

        /* Check argument */
        if (!is_string($region))
            throw new Exception('Region must be a string !');

        $this->userParam['region'] = $region;
    }

    /**
     * Return the region of user
     * 
     * @return String
     */
    public function getRegion() {
        return $this->userParam['region'];
    }

    /**
     * Set the birthday date of user
     *
     * @param String $birthday
     * @throws Exception 
     */
    public function setBirthday($birthday) {

        /* Check argument */
        if (!is_string($birthday))
            throw new Exception('Birthday must be a string !');

        $this->userParam['birthday'] = $birthday;
    }

    /**
     * Return the birthday date of user
     * 
     * @return String
     */
    public function getBirthday() {
        return $this->userParam['birthday'];
    }

    /**
     * Return the status of user
     * 
     * @return Integer
     */
    public function getStatus() {
        return (int) $this->userParam['status'];
    }

    /**
     * Set the status of user
     * 
     * @param Integer $status 
     * @throws Exception 
     */
    public function setStatus($status) {

        /* Check argument */
        if (!is_numeric($status))
            throw new Exception('Status must be a numeric !');

        $this->userParam['status'] = (int) $status;
    }

    /**
     * Return the slogan of user
     * 
     * @return String
     */
    public function getSlogan() {
        return $this->userParam['slogan'];
    }

    /**
     * Set the slogan of user
     * 
     * @param String $slogan 
     * @throws Exception 
     */
    public function setSlogan($slogan) {

        /* Check argument */
        if (!is_string($slogan))
            throw new Exception('Slogan must be a string !');

        $this->userParam['slogan'] = $slogan;
    }

    /**
     * Return the website name of user
     * 
     * @return String
     */
    public function getWebsiteName() {
        return $this->userParam['website_name'];
    }

    /**
     * Set the website name of user
     * 
     * @param String $websiteName 
     * @throws Exception 
     */
    public function setWebsiteName($websiteName) {

        /* Check argument */
        if (!is_string($websiteName))
            throw new Exception('Website name must be a string !');

        $this->userParam['website_name'] = $websiteName;
    }

    /**
     * Return the website url of user
     * 
     * @return String
     */
    public function getWebsiteUrl() {
        return $this->userParam['website_url'];
    }

    /**
     * Set the website url of user
     * 
     * @param String $websiteUrl 
     * @throws Exception 
     */
    public function setWebsiteUrl($websiteUrl) {

        /* Check argument */
        if (!is_string($websiteUrl))
            throw new Exception('Website url must be a string !');

        $this->userParam['website_url'] = $websiteUrl;
    }

    /**
     * Return the groupe id of user
     * 
     * @return Integer
     */
    public function getGroupeId() {
        return (int) $this->userParam['groupe_id'];
    }

    /**
     * Set the groupe id of user
     * 
     * @param Integer $groupeId 
     * @throws Exception 
     */
    public function setGroupeId($groupeId) {

        /* Check argument */
        if (!is_numeric($groupeId))
            throw new Exception('Groupe id must be a numeric !');

        $this->userParam['groupe_id'] = (int) $groupeId;
    }

    /**
     * Return the user info as array
     * 
     * @return Array
     */
    public function toArray() {
        return $this->userParam;
    }

    /**
     * Direct setter of user info array 
     * !! SHOULD NOT BE USED, FOR CONTROLLER CLASS USAGE ONLY !!
     * 
     * @param String $field
     * @param Mixed $value 
     */
    public function directSet($field, $value) {
        $this->userParam[$field] = $value;
    }

}

/**
 * Class SkyUsers (Users controller)
 */
class SkyUsers {
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
     * SkyUser structure used to store user info
     * 
     * @var SkyUser 
     */
    private $user = null;

    /**
     * Create a new SkyUsers controller
     *
     * @param String $table Name of users table in database
     */
    public function __construct($table) {

        /* Retrieve current SkySql instance */
        $this->sql = SkySql::getInstance();

        /* Store database table name */
        $this->table = $this->sql->escape($table);
    }

    /**
     * Open an user by id
     * Return false if not exist, true otherwise
     * 
     * @param String $userId User id
     * @return Boolean
     */
    public function openById($userId) {
        return $this->openBy('user_id', $userId);
    }

    /**
     * Open an user by nickname
     * 
     * @param String $nickname Nickname of user
     * @return Boolean
     */
    public function openByNickname($nickname) {
        return $this->openBy('nickname', $nickname);
    }

    /**
     * Open an user by email
     * 
     * @param String $email
     * @return Boolean 
     */
    public function openByEmail($email) {
        return $this->openBy('email', $email);
    }

    /**
     * Open an user by specified field
     * 
     * @param String $by
     * @param String $value
     * @return Boolean
     * @throws Exception 
     */
    private function openBy($by, $value) {

        /* Check argument */
        if (!is_string($value))
            throw new Exception('Value must be a string !');
        if ($value == '')
            throw new Exception('Value must be not empty !');

        /* Check if another user struct exist */
        if ($this->user !== null)
        /* If yes drop exception */
            throw new Exception('Previous user info have not be closed !');

        /* Send sql query */
        $request = $this->sql->query('SELECT * FROM ' . $this->table . ' WHERE ' . $by . ' = \'' . $this->sql->escape($value) . '\'');

        /* Check for error */
        if ($request === false)
        /* If something fail drop exception */
            throw new Exception('Something fail during sql request (open user) !');

        /* Check if query have return something */
        if ($request->num_rows == 0)
        /* If user don't exist, return false */
            return false;

        /* Fetch first result row */
        $raw = $request->fetch_assoc();

        /* Create a new SkyUser structure and store user data into */
        $this->user = new SkyUser($raw);

        /* Free resources used by sql request */
        $request->close();

        /* No error */
        return true;
    }

    /**
     * Create a new user
     * 
     * @param SkyUser $user User data structure (user id, inscription date, and last seen date fields will be ignored)
     * @throws Exception 
     */
    public function create(SkyUser $user) {

        /* Check if another user struct exist */
        if ($this->user !== null)
        /* If yes drop exception */
            throw new Exception('Previous user info have not be closed !');

        /* Turn user info into an associative array */
        $raw = $user->toArray();

        /* Send sql query */
        $request = $this->sql->query('INSERT INTO ' . $this->table . '(nickname, display_name, email, password, inscription_date, last_seen_date, sexe, region, birthday, status, slogan, website_name, website_url, groupe_id) VALUES('
                . '\'' . $this->sql->escape($raw['nickname']) . '\', \'' . $this->sql->escape($raw['display_name']) . '\', \'' . $this->sql->escape($raw['email'])
                . '\', \'' . $this->sql->escape($raw['password']) . '\', \'' . date('Y-m-d') . '\', \'' . date('Y-m-d H:i:s')
                . '\', \'' . $this->sql->escape($raw['sexe']) . '\', \'' . $this->sql->escape($raw['region']) . '\', \'' . $this->sql->escape($raw['birthday'])
                . '\', \'' . (int) $raw['status'] . '\', \'' . $this->sql->escape($raw['slogan'])
                . '\', \'' . $this->sql->escape($raw['website_name']) . '\', \'' . $this->sql->escape($raw['website_url']) . '\', \'' . (int) $raw['groupe_id'] . '\')'
        );

        /* Check for error */
        if (!$request || $this->sql->affected_rows != 1)
        /* Something fail, drop exception */
            throw new Exception('Something have fail during new user insertion !');

        /* Store new user data */
        // TODO BUG param -> array // FIXED -> CHECK
        $raw['user_id'] = $this->sql->insert_id;
        $raw['inscription_date'] = date('Y-m-d');
        $raw['last_seen_date'] = date('Y-m-d H:i:s');
        $this->user = new SkyUser($raw);
    }

    /**
     * Delete the current user
     * 
     * @throws Exception 
     */
    public function delete() {

        /* Check if user have been open previously */
        if ($this->user === null)
        /* If not drop exception */
            throw new Exception('No previous user info found !');

        /* Send sql query */
        $request = $this->sql->query('DELETE FROM ' . $this->table . ' WHERE user_id = ' . (int) $this->user->getUserId());

        /* Check for error */
        if (!$request || $this->sql->affected_rows != 1)
        /* Somehting fail, drop exception */
            throw new Exception('Something have fail during user deleting !');

        /* Delete previous user data */
        $this->close();
    }

    /**
     * Return the user data structure of current openned user
     * 
     * @return SkyUser
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Close current user, and unset current user data structure
     */
    public function close() {

        /* If user have been previously openned */
        if ($this->user !== null) {

            /* Unset data structure */
            unset($this->user);

            /* Set pointer to null */
            $this->user = null;
        }
    }

    /**
     * Update last seen date of current user (with current time) 
     */
    public function updateLastSeenDate() {
        $this->updateField('last_seen_date', date('Y-m-d H:i:s'));
    }

    /**
     * Update sexe of current user
     * 
     * @param String $sexe 
     * @throws Exception 
     */
    public function updateSexe($sexe) {

        /* Check argument */
        if (!is_string($sexe))
            throw new Exception('Sexe must be a string !');

        $this->updateField('sexe', $sexe);
    }

    /**
     * Update region of current user
     * 
     * @param String $region 
     * @throws Exception 
     */
    public function updateRegion($region) {

        /* Check argument */
        if (!is_string($region))
            throw new Exception('Region must be a string !');

        $this->updateField('region', $region);
    }

    /**
     * Update birthday date of current user
     * 
     * @param String $birthday 
     * @throws Exception 
     */
    public function updateBirthday($birthday) {

        /* Check argument */
        if (!is_string($birthday))
            throw new Exception('Birthday date must be a string !');

        $this->updateField('birthday', $birthday);
    }

    /**
     * Update display name of current user
     * 
     * @param String $displayName 
     * @throws Exception 
     */
    public function updateDisplayName($displayName) {

        /* Check argument */
        if (!is_string($displayName))
            throw new Exception('Display name must be a string !');

        $this->updateField('display_name', $displayName);
    }

    /**
     * Update email address of current user
     * 
     * @param String $email 
     * @throws Exception 
     */
    public function updateEmail($email) {

        /* Check argument */
        if (!is_string($email))
            throw new Exception('Email address must be a string !');

        $this->updateField('email', $email);
    }

    /**
     * Update password of current user
     * 
     * @param String $password 
     * @throws Exception 
     */
    public function updatePassword($password) {

        /* Check argument */
        if (!is_string($password))
            throw new Exception('Password must be a string !');

        $this->updateField('password', $password);
    }

    /**
     * Update status of current user
     * 
     * @param String $status 
     * @throws Exception 
     */
    public function updateStatus($status) {

        /* Check argument */
        if (!is_numeric($status))
            throw new Exception('$status must be a numeric !');
        if ($status < 0)
            throw new Exception('$status must be greater than 0 !');

        $this->updateField('status', $status);
    }

    /**
     * Update slogan of current user
     * 
     * @param String $slogan 
     * @throws Exception 
     */
    public function updateSlogan($slogan) {

        /* Check argument */
        if (!is_string($slogan))
            throw new Exception('Slogan must be a string !');

        $this->updateField('slogan', $slogan);
    }

    /**
     * Update website name of current user
     * 
     * @param String $websiteName website name
     * @throws Exception 
     */
    public function updateWebsiteName($websiteName) {

        /* Check arguments */
        if (!is_string($websiteName))
            throw new Exception('Website name must be a string !');

        $this->updateField('website_name', $websiteName);
    }

    /**
     * Update website url of current user
     * 
     * @param String $websiteUrl website url
     * @throws Exception 
     */
    public function updateWebsiteUrl($websiteUrl) {

        /* Check arguments */
        if (!is_string($websiteUrl))
            throw new Exception('Website url must be a string !');

        $this->updateField('website_url', $websiteUrl);
    }

    /**
     * Update groupe id of current user
     * 
     * @param Integer $groupeId 
     * @throws Exception 
     */
    public function updateGroupeID($groupeId) {

        /* Check argument */
        if (!is_numeric($groupeId))
            throw new Exception('Groupe id must be a numeric !');
        if ($groupeId < 0)
            throw new Exception('Groupe id must be greater than 0 !');

        $this->updateField('groupe_id', (int) $groupeId);
    }

    /**
     * Update a field of current user data structure
     * 
     * @param String $field Name of field to update
     * @param Mixed $value New value of field
     * @throws Exception 
     */
    private function updateField($field, $value) {

        /* Check for a previoulsy openned user structure */
        if (!isset($this->user))
        /* If not drop exception */
            throw new Exception('No previous user info found !');

        /* Send sql query */
        $request = $this->sql->query('UPDATE ' . $this->table . ' SET ' . $field . ' = \'' . $this->sql->escape($value) . '\' WHERE user_id = \'' . (int) $this->user->getUserId() . '\'');

        /* Check for error */
        if (!$request)
        /* Something fail, drop exception */
            throw new Exception('Something have fail during user ' . $field . ' info update !');

        /* Update user local data structure */
        $this->user->directSet($field, $value);
    }

    /* ----- Listing fuinctions ----- */

    /**
     * List users by id
     * 
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @param String $mode Shorting mode (ASC or DESC)
     * @param Array $filter Associative array of table to filter example Array('status' => '1')
     * Valid filter are : inscription_date, last_seen_date, status, groupe_id
     * @return Array 
     */
    public function listById($from, $to, $mode, $filter = null) {
        return $this->listBy('user_id', $from, $to, $mode, $filter);
    }

    /**
     * List users by nickname
     * 
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @param String $mode Shorting mode (ASC or DESC)
     * @param Array $filter Associative array of table to filter example Array('status' => '1')
     * Valid filter are : inscription_date, last_seen_date, status, groupe_id
     * @return Array 
     */
    public function listByNickname($from, $to, $mode, $filter = null) {
        return $this->listBy('nickname', $from, $to, $mode, $filter);
    }

    /**
     * List users by inscription date
     * 
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @param String $mode Shorting mode (ASC or DESC)
     * @param Array $filter Associative array of table to filter example Array('status' => '1')
     * Valid filter are : inscription_date, last_seen_date, status, groupe_id
     * @return Array 
     */
    public function listByInscriptionDate($from, $to, $mode, $filter = null) {
        return $this->listBy('inscription_date', $from, $to, $mode, $filter);
    }

    /**
     * List users by specified field
     * 
     * @param String $by Shorting field
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @param String $mode Shorting mode (ASC or DESC)
     * @param Array $filter Associative array of table to filter example Array('status' => '1')
     * Valid filter are : inscription_date, last_seen_date, status, groupe_id
     * @throws Exception 
     * @return Array 
     */
    private function listBy($by, $from, $to, $mode, $filter) {

        /* Check arguments */
        if (!is_numeric($from))
            throw new Exception('Starting limit must be a numeric !');
        if (!is_numeric($to))
            throw new Exception('Stoping limit must be a numeric !');
        if ($mode != 'ASC' && $mode != 'DESC')
            throw new Exception('Shorting mode must be ASC or DESC !');
        if ($to < $from)
            throw new Exception('Starting limit must be lower than stoping limit !');

        /* Initialize filter string */
        $filter_str = '';

        /* If filters are provided */
        if (isset($filter)) {

            /* Check type of filter */
            if (!is_array($filter))
            /* If not an array drop exception */
                throw new Exception('Filter array must be an array!');

            /* For each filter */
            foreach ($filter as $key => $value) {

                /* Check filter is a validate filter name */
                if ($key != 'inscription_date' && $key != 'last_seen_date' && $key != 'status' && $key != 'groupe_id')
                /* If not ignore it */
                    continue;

                /* Add filter and his value to filter string */
                $filter_str .= $key . ' = \'' . $this->sql->escape($value) . '\' AND ';
            }

            /* Finalize filter string (AND 1) */
            $filter_str .= '1';
        } else
        /* Set where clause to 1 (true) to bypass them */
            $filter_str = '1';

        /* Instanciate result array */
        $result = Array();

        /* Send sql query */
        $request = $this->sql->query('SELECT * FROM ' . $this->table . ' WHERE ' . $filter_str . ' ORDER BY ' . $by . ' ' . $mode . ' LIMIT ' . (int) $from . ', ' . (int) $to);

        /* Check for error */
        if ($request === false)
        /* If something fail drop exception */
            throw new Exception('Something fail during sql request (list by) !');

        /* While data available */
        while (($row = $request->fetch_assoc())) {

            /* Create a copy of data */
            $row_strip = $row;

            /* Unset sensible and unecessary data */
            unset($row_strip['password']);

            /* Append data to result array */
            $result[$row[$by]] = $row_strip;
        }

        /* Free resources used by sql request */
        $request->close();

        /* Return result array */
        return $result;
    }

    /**
     * Search users in database using user id
     * 
     * @param String $userId User id to search
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @return Array 
     */
    public function searchById($userId, $from, $to) {
        return $this->searchBy('user_id', $userId, $from, $to);
    }

    /**
     * Search users in database using nickname
     * 
     * @param String $nickname Nickname to search
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @return Array 
     */
    public function searchByNickname($nickname, $from, $to) {
        return $this->searchBy('nickname', $nickname, $from, $to);
    }

    /**
     * Search users in database using display name
     * 
     * @param String $displayName Display name to search
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @return Array 
     */
    public function searchByDisplayName($displayName, $from, $to) {
        return $this->searchBy('display_name', $displayName, $from, $to);
    }

    /**
     * Search users in database using email
     * 
     * @param String $email Email to search
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @return Array 
     */
    public function searchByEmail($email, $from, $to) {
        return $this->searchBy('email', $email, $from, $to);
    }

    /**
     * Search users in database
     * 
     * @param String $by Table of search
     * @param String $value Value to search
     * @param Integer $from Low index limit
     * @param Integer $to High index limit
     * @return Array
     * @throws Exception 
     */
    private function searchBy($by, $value, $from, $to) {

        /* Check arguments */
        if (!is_string($value))
            throw new Exception('Value must be a string !');
        if (!is_numeric($from))
            throw new Exception('Starting limit must be a numeric !');
        if (!is_numeric($to))
            throw new Exception('Stoping limit must be a numeric !');
        if ($to < $from)
            throw new Exception('Starting limit must be lower than stoping limit !');

        /* Instanciate result array */
        $result = Array();

        /* Send sql query */
        $request = $this->sql->query('SELECT * FROM ' . $this->table . ' WHERE ' . $by . ' LIKE \'%' . $this->sql->escape($value) . '%\' ORDER BY ' . $by . ' ASC LIMIT ' . (int) $from . ', ' . (int) $to);

        /* Check for error */
        if ($request === false)
        /* If something fail drop exception */
            throw new Exception('Something fail during sql request (search) !');

        /* While data available */
        while (($row = $request->fetch_assoc())) {

            /* Create a copy of data */
            $row_strip = $row;

            /* Unset sensible and unecessary data */
            unset($row_strip['password']);

            /* Append data to result array */
            $result[$row[$by]] = $row_strip;
        }

        /* Free resources used by sql request */
        $request->close();

        /* Return result array */
        return $result;
    }

}

?>
