<?php

/**
 * PHP CLASS - Simple but efficient XML generator
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
 * Class SkyXml
 */
class SkyXml {

    /**
     * Source array with xml node and data 
     * 
     * @var Array 
     */
    private $source = null;

    /**
     * Xml header with xml version and encoding
     * 
     * @var String 
     */
    private $header = '';

    /**
     * Create a new SkyXml object
     * 
     * @param Array $source Source array with xml node and data 
     * @param String $xmlHeader Xml header string with xml version and encoding
     */
    public function __construct($source, $xmlHeader = '<?xml version="1.0" encoding="ISO-8859-1"?>') {

        /* Check arguments */
        if(!is_array($source))
            throw new Exception('Source array must be an array !');
        if(!is_string($xmlHeader))
            throw new Exception('Xml header must be a string !');
        
        /* Store usefull variable */
        $this->source = $source;
        $this->header = $xmlHeader;
    }

    /**
     * Process array recursively to stdout 
     * 
     * @param Array $arr Source of data 
     */
    private function processEcho($arr) {

        /* For each node of source array */
        foreach ($arr as $key => $value) {

            /* Output openning tag */
            echo "<$key>";

            /* Test if node contain another nodes */
            if (is_array($value)) {

                /* If yes process it recursively */
                $this->processEcho($value);

                /* Else if not */
            } else {

                /* Output his content */
                echo $value;
            }

            /* Output closing tag */
            echo "</$key>";
        }
    }

    /**
     * Render source array to xml and output result to stdout
     * 
     * @param Boolean $header Set to true to send xml mime-type header
     */
    public function renderToEcho($header = true) {
        
        /* Check argument */
        if(!is_bool($header))
            throw new Exception('Header option must be a boolean !');
        
        /* If mime-type header are required */
        if($header)
            /* Send it to client */
            header('Content-Type: text/xml');
        
        /* Echo xml header */
        echo $this->header;
        
        /* Start recusive process */
        $this->processEcho($this->source);
    }
    
    /**
     * Process array recursively and return resulting string
     * 
     * @param Array $arr Source of data 
     * @return String
     */
    private function processReturn($arr) {

        /* Declare result string */
        $res = '';
        
        /* For each node of source array */
        foreach ($arr as $key => $value) {

            /* Add openning tag */
            $res .= "<$key>";

            /* Test if node contain another nodes */
            if (is_array($value)) {

                /* If yes process it recursively */
                $res .= $this->processReturn($value);

                /* Else if not */
            } else {

                /* Add his content */
                $res .= $value;
            }

            /* Add closing tag */
            $res .= "</$key>";
        }
        
        return $res;
    }

    /**
     * Render source array to xml and return resulting string
     * 
     * @return String 
     */
    public function renderToString() {
        
        /* Start recursive process and return result */
        return $this->header . $this->processReturn($this->source);
    }

}

?>
