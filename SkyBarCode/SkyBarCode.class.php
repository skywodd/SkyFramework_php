<?php

/**
 * PHP CLASS - Code-39 Barcode generation class (without CRC char)
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
 * SkyBarCode 
 */
class SkyBarCode {
    /* Barcode Type 39 Generator */

    /**
     * Ascii to Binary table
     * (From wikipedia : http://fr.wikipedia.org/wiki/Code_39)
     * 
     * @var Array 
     */
    private static $asciiTable = Array(
        'A' => '111010100010111',
        'B' => '101110100010111',
        'C' => '111011101000101',
        'D' => '101011100010111',
        'E' => '111010111000101',
        'F' => '101110111000101',
        'G' => '101010001110111',
        'H' => '111010100011101',
        'I' => '101110100011101',
        'J' => '101011100011101',
        'K' => '111010101000111',
        'L' => '101110101000111',
        'M' => '111011101010001',
        'N' => '101011101000111',
        'O' => '111010111010001',
        'P' => '101110111010001',
        'Q' => '101010111000111',
        'R' => '111010101110001',
        'S' => '101110101110001',
        'T' => '101011101110001',
        'U' => '111000101010111',
        'V' => '100011101010111',
        'W' => '111000111010101',
        'X' => '100010111010111',
        'Y' => '111000101110101',
        'Z' => '100011101110101',
        '0' => '101000111011101',
        '1' => '111010001010111',
        '2' => '101110001010111',
        '3' => '111011100010101',
        '4' => '101000111010111',
        '5' => '111010001110101',
        '6' => '101110001110101',
        '7' => '101000101110111',
        '8' => '111010001011101',
        '9' => '101110001011101',
        '-' => '100010101110111',
        '.' => '111000101011101',
        ' ' => '100011101011101',
        '$' => '100010001000101',
        '/' => '100010001010001',
        '+' => '100010100010001',
        '%' => '101000100010001',
        /* Wikipedia don't give raw code for *, so I reversed it from example picture */
        '*' => '100010111011101'
    );

    /**
     * GD image object
     * 
     * @var Resource 
     */
    private $image = null;

    /**
     * Compute a string into a code-39 barcode image
     * (Accepted char : A-z 0-9, dot, space, $, +, -, %, and /, but NOT * )
     * 
     * @param String $str String to compute
     * @param Interger $height Height of output barcode image (default 100px)
     * @param Integer $pxPerLine Number of pixels per vertical lines (default 1px)
     * @throws Exception
     */
    public function __construct($str, $height = 100, $pxPerLine = 1) {

        /* Arguments check */
        if (!is_string($str))
            throw new Exception('Source text must be a string !');
        if ($str == '')
            throw new Exception('Source text must be not empty !');
        if (!is_numeric($height))
            throw new Exception('Height of image must be a numeric !');
        if ($height < 1)
            throw new Exception('Height of image must be greater (or equal) than 1 pixel !');
        if (!is_numeric($pxPerLine))
            throw new Exception('Number of pixels per vertical line must be a numeric !');
        if ($pxPerLine < 1)
            throw new Exception('Number of pixels per vertical line must be greater (or equal) than 1 pixel !');

        /* Security cast */
        $height = (int) $height;
        $pxPerLine = (int) $pxPerLine;

        /* Strip all forbidden char, and cast string to upper case */
        $str = '*' . preg_replace('#[^0-9A-Z. $/+%-]#', '', strtoupper($str)) . '*';

        /* Compute barcode width */
        /* Each char is encoded with 15 bits + 1 bit of spacing */
        $width = (int) $pxPerLine * ((strlen($str) * 15) + strlen($str));

        /* Create blank image */
        $this->image = imagecreatetruecolor($width, $height);

        /* Check for error */
        if ($this->image === false)
        /* If yes drop exception */
            throw new Exception('Something goes wrong during initial image creation !');

        /* Compute B/W color */
        $white = imagecolorallocate($this->image, 255, 255, 255);
        $black = imagecolorallocate($this->image, 0, 0, 0);

        /* Check for error */
        if ($white === false || $black === false)
        /* If yes drop exception */
            throw new Exception('Something goes wrong during color allocation !');

        /* Horizontal offset */
        $x = 0;

        /* For each char of normalized string */
        for ($i = 0; $i < strlen($str); $i++) {

            /* Draw spacing line */
            $this->drawLine($x, $pxPerLine, $white, $height);

            /* Increment offset */
            $x++;

            /* Load char binary */
            $binary = self::$asciiTable[$str[$i]];

            /* For each bits of char binary */
            for ($z = 0; $z < 15; $z++) {

                /* If bit is set */
                if ($binary[$z] == '1') {

                    /* Draw black line */
                    $this->drawLine($x, $pxPerLine, $black, $height);

                    /* Else, if bit is not set */
                } else {

                    /* Draw white line */
                    $this->drawLine($x, $pxPerLine, $white, $height);
                }

                /* Increase offset */
                $x += $pxPerLine;
            }
        }
    }

    /**
     * Draw a vertical $color line of $l pixel starting at $x
     * 
     * @param type $x Horizontal starting position
     * @param type $l Width in pixel of line
     * @param type $color Color of line
     * @throws Exception
     */
    private function drawLine($x, $l, $color, $height) {

        /* For each pixel of line width */
        for ($i = 0; $i < $l; $i++)
        /* Draw line with specified color, at specified position */
            if (imageline($this->image, $x + $i, 0, $x + $i, $height, $color) == false)
            /* If something fail drop exception */
                throw new Exception('Something goes wrong during image drawing !');
    }

    /**
     * Output raw image data
     * 
     * @param Boolean $sendHeader If true send mime-type header before data
     * @throws Exception
     */
    public function getRawPng($sendHeader = true) {

        /* Check argument */
        if (!is_bool($sendHeader))
            throw new Exception('Send header option must be a boolean !');

        /* Send header if required */
        if ($sendHeader == true) {
            /* Send mime-type png header */
            header("Content-type: image/png");
        }

        /* Write raw image data to stdsout */
        if (imagepng($this->image) == false)
        /* If something fail drop exception */
            throw new Exception('Something goes wrong during png image generation !');
    }

    /**
     * Save image as png to specified path
     * 
     * @param String $path Path of output png file
     * @throws Exception
     */
    public function saveAsPng($path) {

        /* Check argument */
        if (!is_string($path))
            throw new Exception('Image path must be a string !');
        if ($path == '')
            throw new Exception('Image path must be not empty !');

        /* Save image as png to $path */
        if (imagepng($this->image, $path) == false)
        /* If something fail drop exception */
            throw new Exception('Cannot save barcode image !');
    }

    /**
     * Free resource used by image
     * 
     * @throws Exception 
     */
    public function __destruct() {

        /* Free resources used by image */
        if (imagedestroy($this->image) == false)
        /* If something fail */
            throw new Exception('Cannot free image resources !');
    }

}
