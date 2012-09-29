<?php

/**
 * PHP CLASS - Php image upload class
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
 * 22/05/2012 - Initial commit
 *              
 */

/* Avoid direct access to script */
if (!defined('APPS_RUNNING'))
    die('<h1>Direct access to php class is not allowed.</h1>');

/**
 * Class SkyImage
 */
class SkyImage {

    /**
     * Final filename of uploaded file
     *
     * @var String
     */
    private $outputFilename = '';

    /**
     * Process uploaded image from user
     * 
     * @param String $inputName Name of form file input
     * @param Integer $maxSize Maximum size (in bytes) of uploaded file
     * @param Array $allowedType Associative array of extension => mime-type
     * @param String $uploadDirectory Path to upload directory
     * @throws Exception 
     */
    public function __construct($inputName, $maxSize, $allowedType, $uploadDirectory) {

        /* Check argument */
        if (!is_string($inputName))
            throw new Exception('Input name must be a string !');
        if ($inputName == '')
            throw new Exception('Input name must be not empty !');
        if (!is_numeric($maxSize))
            throw new Exception('File max size must be a numeric !');
        if ($maxSize <= 0)
            throw new Exception('File max size must be greater than 0 !');
        if (!is_array($allowedType))
            throw new Exception('Allowed type array must be an array !');
        if (!is_string($uploadDirectory))
            throw new Exception('Upload directory path must be a string !');
        if ($uploadDirectory == '')
            throw new Exception('Upload directory path must be not empty !');

        /* Normalize file extension */
        foreach ($allowedType as $mimetype => $extension) {
            $allowedType[$mimetype] = strtoupper($extension);
        }

        /* Check if file input is empty */
        if (!isset($_FILES[$inputName]))
            throw new Exception('File input must be not null !');

        /* Check for client side error */
        if (isset($_FILES[$inputName]['error']) && $_FILES[$inputName]['error'] != UPLOAD_ERR_OK)
            throw new Exception('Something fail during file upload ! Error code : ' . $_FILES[$inputName]['error']);

        /* Check for server side error */
        if (!isset($_FILES[$inputName]['tmp_name']) || !is_uploaded_file($_FILES[$inputName]['tmp_name']))
            throw new Exception('Uploaded file not found (Ho god ...) !');

        /* Check filename */
        if (!isset($_FILES[$inputName]['name']))
            throw new Exception('Uploaded file must have a name.');

        /* Check uploaded file size */
        $fileSize = filesize($_FILES[$inputName]['tmp_name']);
        if ($fileSize === false)
            throw new Exception('Something fail during uploaded file size check !');
        if ($fileSize > $maxSize)
            throw new Exception('File exceeds the maximum allowed size !');
        if ($fileSize == 0)
            throw new Exception('File size must be greater than 0 (obvious) !');

        /* Check file according mime-type */
        if (reset(explode('/', $_FILES[$inputName]['type'])) != 'image')
            throw new Exception('File is not an image (according mime-type) !');

        /* Check file according magic-string */
        $imageinfo = getimagesize($_FILES[$inputName]['tmp_name']);
        if ($imageinfo === false)
            throw new Exception('Something fail during image info reading !');
        if (!array_key_exists($imageinfo['mime'], $allowedType))
            throw new Exception('File format is not allowed !');

        /* Sanitize filename */
        $filename = strtr($_FILES[$inputName]['name'], 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $filename = preg_replace('/[^A-Za-z0-9_.-s ]/i', '', $filename);
        if (strlen($filename) == 0)
            throw new Exception('Invalid file name (empty after sanitizing) !');

        /* Validate file extension */
        if (!in_array(end(explode('.', strtoupper($filename))), $allowedType))
            throw new Exception('Invalid file extension !');

        /* Rename file to avoid overwrite and file deduction */
        $filename = uniqid('IMG_') . '_' . $filename;
        $this->outputFilename = $uploadDirectory . '/' . $filename;

        /* Move uploaded file to upload directory */
        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $this->outputFilename) == false)
            throw new Exception('Something file during uploaded file displacement !');
    }

    /**
     * Return the final output filename of uploaded file
     *
     * * @return String 
     */
    public function getOutputFilename() {
        return $this->outputFilename;
    }

    /**
     * Delete a file
     * 
     * @param String $filename File to delete
     * @throws Exception 
     */
    public static function delete($filename) {

        /* Commit delete */
        if (unlink($filename) == false)
        /* If something fail drop error */
            throw new Exception('Unable to delete file !');
    }

    /**
     * Return image info of uploaded file
     * 
     * @return Array
     * @throws Exception 
     */
    public function getInfo() {

        /* Get image info */
        $imageinfo = getimagesize($this->outputFilename);

        /* Check for error */
        if ($imageinfo === false)
        /* If something fail dropxception */
            throw new Exception('Something fail during image info reading !');

        /* Return image info */
        return $imageinfo;
    }

    /**
     * Return image info of image file
     * 
     * @param String $filename File name
     * @return Array
     * @throws Exception 
     */
    public static function getInfoEx($filename) {

        /* Check argument */
        if (!is_string($filename))
            throw new Exception('Filename must be a string !');
        if ($filename == '')
            throw new Exception('Filename must be not empty !');

        /* Get image info */
        $imageinfo = getimagesize($filename);

        /* Check for error */
        if ($imageinfo === false)
        /* If something fail dropxception */
            throw new Exception('Something fail during image info reading !');

        /* Return image info */
        return $imageinfo;
    }

    /**
     * Extract height from image info
     * 
     * @param Array $imginfo Image info
     * @return Integer
     */
    public static function getHeight(Array $imginfo) {

        /* Check arguments */
        if (!is_array($imginfo))
            throw new Exception('Image info structure must be an array !');

        return (int) $imginfo[1];
    }

    /**
     * Extract width from image info
     *  
     * @param Array $imginfo Image info
     * @return Integer
     */
    public static function getWidth($imginfo) {

        /* Check arguments */
        if (!is_array($imginfo))
            throw new Exception('Image info structure must be an array !');

        return (int) $imginfo[0];
    }

    /**
     * Extract image size as html properties string from image info
     * 
     * @param Array $imginfo Image info
     * @return String 
     */
    public static function getSizeString($imginfo) {

        /* Check arguments */
        if (!is_array($imginfo))
            throw new Exception('Image info structure must be an array !');

        return $imginfo[3];
    }

    public function resize($outPath, $maxWidth) {
        self::resizeEx($this->outputFilename, $outPath, $maxWidth);
    }

    public static function resizeEx($imgPath, $outPath, $maxWidth) {

        /* Get image size info */
        $imginfo = self::getInfoEx($imgPath);
        $height = self::getHeight($imginfo);
        $width = self::getWidth($imginfo);

        /* Compute resize ratio */
        if ($width <= $height)
            $ratio = $height / $maxWidth;
        else
            $ratio = $width / $maxWidth;

        /* Apply ratio to image size */
        $new_width = $width / $ratio;
        $new_height = $height / $ratio;

        /* Create blank image */
        $image = imagecreatetruecolor($new_width, $new_height);

        /* Check for error */
        if ($image === false)
        /* If something fail drop exception */
            throw new Exception('Something goes wrong during target image creation !');

        /* Get raw image */
        switch ($imginfo['mime']) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($imgPath);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($imgPath);
                break;
            case 'image/png':
                $source = imagecreatefrompng($imgPath);
                break;
        }

        /* Check for error */
        if ($source === false)
        /* If something fail drop exception */
            throw new Exception('Something goes wrong during source image reading !');

        /* Resize image */
        if (imagecopyresampled($image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height) == false)
        /* If something fail */
            throw new Exception('Something goes wrong during image resizing !');

        /* Save resized image */
        if (imagepng($image, $outPath) === false)
        /* If something fail drop exception */
            throw new Exception('Something goes wrong during image saving !');

        /* Free resources */
        imagedestroy($image);
        imagedestroy($source);
    }

}

?>
