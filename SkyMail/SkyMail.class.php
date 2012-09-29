<?php

/**
 * PHP CLASS - User-friendly email sender
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
 * Class SkyMail
 */
class SkyMail {
    /* Prority const */

    const PRIORITY_NON_URGENT = 'non-urgent';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_URGENT = 'urgent';

    /* Type const */
    const RAW_TYPE_IMAGE = 'image';
    const RAW_TYPE_AUDIO = 'audio';
    const RAW_TYPE_VIDEO = 'video';
    const RAW_TYPE_APPLICATION = 'application';
    const RAW_TYPE_RAW_STREAM = 'application/octet-stream';
    const RAW_TYPE_POSTSCRIPT = 'application/postscript';

    /* Common charset */
    const CHARSET_ISO = 'iso-8859-1';
    const CHARSET_UTF8 = 'utf-8';

    /* Multipart subtypes */
    const MULTIPART_MIXED = 'mixed';
    const MULTIPART_ALTERNATVE = 'alternative';
    const MULTIPART_DIGEST = 'digest';

    /**
     * Bcc address
     * 
     * @var String 
     */
    private $address_bcc = '';

    /**
     * Cc address
     * 
     * @var String 
     */
    private $address_cc = '';

    /**
     * Content descrption 
     * 
     * @var String
     */
    private $content_description = '';

    /**
     * Content type
     * 
     * @var String
     */
    private $content_type = 'text/plain; charset=us-ascii';

    /**
     * Mail sent date
     * 
     * @var String
     */
    private $date = '';

    /**
     * From address
     * 
     * @var String
     */
    private $adress_from = '';

    /**
     * Content Mime type
     * 
     * @var String
     */
    private $mime_type = 'MIME-Version: 1.0';

    /**
     * Mail priority
     * 
     * @var String 
     */
    private $priority = self::PRIORITY_NORMAL;

    /**
     * Reply to address
     * 
     * @var String
     */
    private $reply_to = '';

    /**
     * Original sender address 
     * 
     * @var String
     */
    private $sender = '';

    /**
     * Mail subject
     * 
     * @var String
     */
    private $subjet = '(no subject)';

    /**
     * Read confirmation address
     * 
     * @var String
     */
    private $confirm_reading_to = '';

    /**
     * To address
     * 
     * @var String
     */
    private $address_to = '';

    /**
     * Mail body content
     * 
     * @var String
     */
    private $content = '';

    /**
     * Mail multiparts bounary
     * 
     * @var String
     */
    private $bounary = '';

    /**
     * Mail attachements array
     * 
     * @var Array 
     */
    private $attachements = Array();

    /**
     * Add address to To field
     * 
     * @param String $address 
     */
    public function addTo($address) {
        $this->addAddress($this->address_to, $address);
    }

    /**
     * Add address with name associed to To field
     * 
     * @param String $name
     * @param String $address 
     */
    public function addNamedTo($name, $address) {
        $this->addNamedAddress($this->address_to, $name, $address);
    }

    /**
     * Add address to Bcc field
     * 
     * @param String $address 
     */
    public function addBcc($address) {
        $this->addAddress($this->address_bcc, $address);
    }

    /**
     * Add address with name associed to Bcc field
     * 
     * @param String $name
     * @param String $address 
     */
    public function addNamedBcc($name, $address) {
        $this->addNamedAddress($this->address_bcc, $name, $address);
    }

    /**
     * Add address to Cc field
     * 
     * @param String $address 
     */
    public function addCc($address) {
        $this->addAddress($this->address_cc, $address);
    }

    /**
     * Add address with name associed to Cc field
     * 
     * @param String $name
     * @param String $address 
     */
    public function addNamedCc($name, $address) {
        $this->addNamedAddress($this->address_cc, $name, $address);
    }

    /**
     * Add address to From field (only one stored)
     * 
     * @param String $address 
     */
    public function addFrom($address) {
        $this->adress_from = '';
        $this->addAddress($this->adress_from, $address);
    }

    /**
     * Add address with name associed to From field
     * 
     * @param String $name
     * @param String $address 
     */
    public function addNamedFrom($name, $address) {
        $this->adress_from = '';
        $this->addNamedAddress($this->adress_from, $name, $address);
    }

    /**
     * Add address to ReplyTo field (only one stored)
     * 
     * @param String $address 
     */
    public function addReplyTo($address) {
        $this->reply_to = '';
        $this->addAddress($this->reply_to, $address);
    }

    /**
     * Add address with name associed to ReplyTo field
     * 
     * @param String $name
     * @param String $address 
     */
    public function addNamedReplyTo($name, $address) {
        $this->reply_to = '';
        $this->addNamedAddress($this->reply_to, $name, $address);
    }

    /**
     * Add address to Sender field (only one stored)
     * 
     * @param String $address 
     */
    public function addSender($address) {
        $this->sender = '';
        $this->addAddress($this->sender, $address);
    }

    /**
     * Add address with name associed to Sender field
     * 
     * @param String $name
     * @param String $address 
     */
    public function addNamedSender($name, $address) {
        $this->sender = '';
        $this->addNamedAddress($this->sender, $name, $address);
    }

    /**
     * Add address to ConfirmTo field (only one stored)
     * 
     * @param String $address 
     */
    public function addConfirmTo($address) {
        $this->confirm_reading_to = '';
        $this->addAddress($this->confirm_reading_to, $address);
    }

    /**
     * Add address with name associed to ConfirmTo field
     * 
     * @param String $name
     * @param String $address 
     */
    public function addNamedConfirmTo($name, $address) {
        $this->confirm_reading_to = '';
        $this->addNamedAddress($this->confirm_reading_to, $name, $address);
    }

    /**
     * Add address to specified field
     * 
     * @param String $field
     * @param String $address
     * @throws Exception 
     */
    private function addAddress(&$field, $address) {

        /* Check arguments */
        if (!is_string($address))
            throw new Exception('Address must be a string !');
        if ($address == '')
            throw new Exception('Address must be not empty !');
        if (!self::isInjectionSafe($address))
            throw new Exception('Address potentialy contain headers injection !');

        /* Append ',' if other address are set */
        if ($field != '')
            $field .= ', ';

        /* Append address */
        $field .= $address;
    }

    /**
     * Append address with name associed to specified field
     *
     * @param String $field
     * @param String $name
     * @param String $address
     * @throws Exception 
     */
    private function addNamedAddress(&$field, $name, $address) {

        /* Check arguments */
        if (!is_string($name))
            throw new Exception('Name must be a string !');
        if ($name == '')
            throw new Exception('Name must be not empty !');
        if (!is_string($address))
            throw new Exception('Address must be a string !');
        if ($address == '')
            throw new Exception('Address must be not empty !');
        if (!self::isInjectionSafe($name) || !self::isInjectionSafe($address))
            throw new Exception('Address or name potentialy contain headers injection !');

        /* Append , if other address are set */
        if ($field != '')
            $field .= ', ';

        /* Sanitize name */
        $name = preg_replace('#[^0-9A-Za-z. _-]#', '', $name);

        /* Append name and address */
        $field .= $name . ' <' . $address . '>';
    }

    /**
     * Return true if string is headers injection safe, false otherwise
     * 
     * @param String $str
     * @return Boolean
     */
    private static function isInjectionSafe($str) {

        return !preg_match('/[\n\r]/', $str);
    }

    /**
     * Set content description
     * 
     * @param String $description
     * @throws Exception 
     */
    public function setContentDescription($description) {

        /* Check argument */
        if (!is_string($description))
            throw new Exception('Description must be a string !');
        if (!self::isInjectionSafe($description))
            throw new Exception('Description potentialy contain headers injection !');

        $this->content_description = $description;
    }

    /**
     * Set content type to text with specified charset
     * 
     * @param String $charset
     * @throws Exception 
     */
    public function setContentTypeText($charset) {

        /* Check argument */
        if (!is_string($charset))
            throw new Exception('Charset must be a string !');
        if ($charset == '')
            throw new Exception('Charset must be not empty !');
        if (!self::isInjectionSafe($charset))
            throw new Exception('Charset potentialy contain headers injection !');

        $this->content_type = "text/plain; charset=\"$charset\"";
    }

    /**
     * Set content type to html with specified charset
     * 
     * @param String $charset
     * @throws Exception 
     */
    public function setContentTypeHtml($charset) {

        /* Check argument */
        if (!is_string($charset))
            throw new Exception('Charset must be a string !');
        if ($charset == '')
            throw new Exception('Charset must be not empty !');
        if (!self::isInjectionSafe($charset))
            throw new Exception('Charset potentialy contain headers injection !');

        $this->content_type = "text/html; charset=\"$charset\"";
    }

    /**
     * Set content type to multiparts with specified bounary (optionnal)
     * 
     * @param String $subtype Sub type of content
     * @param string $bounary Separator between mail body and attachements
     * @throws Exception 
     */
    public function setContentTypeMultiPart($subtype, $bounary = null) {

        /* If no bounary specified generate one */
        if (!isset($bounary))
            $bounary = '--' . uniqid('BOUNARY');

        /* Check arguments */
        if (!is_string($subtype))
            throw new Exception('Sub type must be a string !');
        if (!is_string($bounary))
            throw new Exception('Bounary must be a string !');
        if ($subtype != 'mixed' && $subtype != 'alternative' && $subtype != 'digest')
            throw new Exception('Sub type must be empty, mixed, alternative, or mixed !');

        /* Store content type and bounary */
        $this->content_type = "multipart/$subtype; boundary=\"$bounary\"";
        $this->bounary = $bounary;
    }

    /**
     * Set content type to specified mime-type 
     * 
     * @param String $subtype
     * @throws Exception 
     */
    public function setContentTypeRaw($subtype) {

        /* Check argument */
        if (!is_string($subtype))
            throw new Exception('Sub type must be a string !');
        if ($subtype == '')
            throw new Exception('Sub type must be not empty !');
        if (!self::isInjectionSafe($subtype))
            throw new Exception('Sub type potentialy contain headers injection !');

        $this->content_type = $subtype;
    }

    /**
     * Set sent date of mail to current datetime 
     */
    public function setDateNow() {

        /* Use current datetime */
        $this->date = date('r');
    }

    /**
     * Set sent date of mail to specified datetime
     * 
     * @param String $date
     * @throws Exception 
     */
    public function SetDate($date) {

        /* Check argument */
        if (!is_string($date))
            throw new Exception('Date must be a string formated like : Sun, 17 Sep 2006 09:33:12 GMT !');
        if (!self::isInjectionSafe($date))
            throw new Exception('Date potentialy contain headers injection !');

        /* Use specified date or use current datetime */
        if ($date == '')
            $this->date = date('r');
        else
            $this->date = $date;
    }

    /**
     * Set subject of mail
     * 
     * @param String $subject
     * @throws Exception 
     */
    public function addSubject($subject) {

        /* Check argument */
        if (!is_string($subject))
            throw new Exception('Subject must be a string !');
        if ($subject == '')
            throw new Exception('Subject must be not empty !');
        if (!self::isInjectionSafe($subject))
            throw new Exception('Subject potentialy contain headers injection !');

        $this->subjet = $subject;
    }

    /**
     * Add content (overwrite) to mail body
     * 
     * @param String $content
     * @throws Exception 
     */
    public function addContent($content) {

        /* Check argument */
        if (!is_string($content))
            throw new Exception('Content must be a string !');
        if ($content == '')
            throw new Exception('Content must be not empty !');

        /* Fix content for windows based mailer */
        $content = str_replace("\n. ", "\n..", $content);

        /* Wrap line to 70 characters */
        $content = wordwrap($content, 70);

        $this->content = $content;
    }

    /**
     * Set mail priority
     * 
     * @param String $priority
     * @throws Exception 
     */
    public function setPriority($priority) {

        /* Check argument */
        if (!is_string($priority))
            throw new Exception('Priority must be a string !');
        if ($priority != 'non-urgent' && $priority != 'normal' && $priority != 'urgent')
            throw new Exception('Priority must be non-urgent, normal, or urgent !');

        $this->priority = $priority;
    }

    /**
     * Add attachement to mail
     * 
     * @param String $filename Path to attachement file
     * @throws Exception 
     */
    public function addAttachement($filename) {

        /* Check argument */
        if (!is_file($filename) || !is_readable($filename))
            throw new Exception('File is does not exist or is not readable !');

        /* Get file content */
        $content = file_get_contents($filename);
        $mimetype = filetype($filename);

        /* Check for error */
        if ($content === false || $mimetype === false)
        /* if something file drop exception */
            throw new Exception('Something goes wrong during attachement content reading !');

        /* Turn raw content to base64 and wrap line */
        $b64content = base64_encode($content);
        $b64content = wordwrap($b64content, 70);

        /* Attachement header */
        $headers = 'Content-type: ' . $mimetype . '; name = ' . $filename . "\r\n";
        $headers .= 'Content-transfer-encoding: base64' . "\r\n";

        /* Add attachement to mail */
        $this->attachements[$filename] = $headers . "\r\n" . $b64content;
    }

    /**
     * Send mail to mailing deamon
     * 
     * @throws Exception 
     */
    public function send() {

        /* Check required arguments */
        if ($this->address_to == '')
            throw new Exception('Address TO must be not empty!');
        if ($this->subjet == '')
            throw new Exception('Subject must be not empty!');
        if ($this->content == '')
            throw new Exception('Content must be not empty!');

        /* Declare additionals headers string */
        $headers = '';

        /* Process Bcc header */
        if ($this->address_bcc != '')
            $headers .= 'Bcc: ' . $this->address_bcc . "\r\n";

        /* Process Cc header */
        if ($this->address_cc != '')
            $headers .= 'Cc: ' . $this->address_cc . "\r\n";

        /* Process Content-Description header */
        if ($this->content_description != '')
            $headers .= 'Content-Description: ' . $this->content_description . "\r\n";

        /* Process Content-Type header */
        if ($this->content_type != '')
            $headers .= 'Content-Type: ' . $this->content_type . "\r\n";

        /* Process Date header */
        if ($this->date != '')
            $headers .= 'Date: ' . $this->date . "\r\n";

        /* Process From header */
        if ($this->adress_from != '')
            $headers .= 'From: ' . $this->adress_from . "\r\n";

        /* Process MIME-Version header */
        if ($this->mime_type != '')
            $headers .= 'MIME-Version: ' . $this->mime_type . "\r\n";

        /* Process Priority header */
        if ($this->priority != '')
            $headers .= 'Priority: ' . $this->priority . "\r\n";

        /* Process Reply-To header */
        if ($this->reply_to != '')
            $headers .= 'Reply-To: ' . $this->reply_to . "\r\n";

        /* Process Sender header */
        if ($this->sender != '')
            $headers .= 'Sender: ' . $this->sender . "\r\n";

        /* Process X-Confirm-Reading-To header */
        if ($this->confirm_reading_to != '')
            $headers .= 'X-Confirm-Reading-To: ' . $this->confirm_reading_to . "\r\n";

        /* Add mailer author info */
        $headers .= 'X-Mailer: PHP/SkyMail' . "\r\n\r\n";

        /* Process attachements */
        $attachments = '';
        foreach ($this->attachements as $filename => $attachment) {
            $attachments .= $this->bounary . "\r\n";
            $attachments .= $attachment . "\r\n";
        }

        /* Finalize mail if multi-parted */
        if (count($this->attachements) != 0)
            $attachments .= $this->bounary . "\r\n";

        /* Send mail to mailing deamon */
        //if (mail($this->address_to, $this->subjet, $this->content . "\r\n" . $attachments, $headers) == false)
        /* If something fail drop error */
        //    throw new Exception('Something goes wrong during mail delivery request!');
        //    
        // EMULATION MODE !
        echo '<p>Headers</p>';
        var_dump($headers);

        echo '<p>Mail to</p>';
        var_dump($this->address_to);

        echo '<p>Subject</p>';
        var_dump($this->subjet);

        echo '<p>Content</p>';
        var_dump($this->content . "\r\n" . $attachments);
    }

}

?>