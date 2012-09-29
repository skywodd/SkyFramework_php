<?php

/**
 * PHP CLASS - Mysql database (structure and data) backup class
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
 * SkyMysqlBackup
 */
class SkyMysqlBackup {

    /**
     * Backup a database using specified arguments
     * 
     * @param String $host Hostname or IP of mysql server
     * @param String $username Username to use for connection
     * @param String $password Password to use for connection
     * @param String $database Database to backup
     * @param String $outputfile Path to sql dump file
     * @throws Exception 
     */
    public function __construct($host, $username, $password, $database, $outputfile) {

        /* Create output sql file, WITH OVERWRITING */
        $fo = fopen($outputfile, 'w+');

        /* If something fail */
        if (!$fo)
        /* Drop an exception */
            throw new Exception('Cannot create dump file !');

        /* Connection to server */
        $link = new mysqli($host, $username, $password, $database);

        /* If connection fail */
        if ($link->connect_errno)
        /* Drop an exception */
            throw new Exception('Cannot connect to mysql server !');

        /* Print dump header */
        fwrite($fo, '-- Backup of ' . $database . ' (' . date('d-M-Y') . ")\n\n");

        /* Request all table names */
        $tables = $link->query('SHOW TABLES');

        /* If request fail */
        if (!$tables)
        /* Drop an exception */
            throw new Exception('Cannot retrieve tables listing !');

        /* While we got table names */
        while ($table = $tables->fetch_row()) {

            /* Print drop table segment */
            fwrite($fo, "DROP TABLE `${table[0]}`;\n\n");

            /* Request table structure */
            $struct = $link->query('SHOW CREATE TABLE ' . $table[0]);

            /* If request fail */
            if (!$struct)
            /* Drop an exception */
                throw new Exception('Cannot retrieve table structure !');

            /* While we got structure row */
            while ($create = $struct->fetch_row()) {

                /* Write them to dump file */
                fwrite($fo, "${create[1]} \n\n");
            }

            /* Free ressources used by structure request */
            $struct->close();

            /* Request all table data */
            $data = $link->query('SELECT * FROM ' . $table[0]);

            /* If request fail */
            if (!$data)
            /* Drop an exception */
                throw new Exception('Cannot retrieve table data !');

            /* While we got data */
            while ($row = $data->fetch_row()) {

                /* Print insert segment */
                fwrite($fo, 'INSERT INTO `' . $table[0] . '` VALUES(');

                /* For each elements of table */
                for ($i = 0; $i < $data->field_count; $i++) {

                    /* Print separator, excepted for first element */
                    if ($i != 0)
                        fwrite($fo, ', ');

                    /* Escape and write data to dump file */
                    fwrite($fo, '\'' . mysql_real_escape_string($row[$i]) . '\'');
                }

                /* Finalize insert segment */
                fwrite($fo, ");\n");
            }

            /* Free ressources used by data request */
            $data->close();

            /* Make dump more clear */
            fwrite($fo, "\n");
        }

        /* Free ressources used by tables request */
        $tables->close();

        /* Close connection with server */
        $link->close();

        /* Close dump file */
        fclose($fo);
    }

}

?>
