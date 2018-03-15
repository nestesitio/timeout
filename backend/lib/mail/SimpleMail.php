<?php

namespace lib\mail;

/**
 * Simple Mail
 *
 * A simple PHP wrapper class for sending email using the mail() method.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to the MIT license, which is
 * available through the world-wide-web at the following URI:
 * http://github.com/eoghanobrien/php-simple-mail/LICENCE.txt
 *
 * @category  SimpleMail
 * @package   SimpleMail
 * @author    Eoghan O'Brien <eoghan@eoghanobrien.com>
 * @copyright 2009 - 2014 Eoghan O'Brien
 * @license   http://github.com/eoghanobrien/php-simple-mail/LICENCE.txt MIT
 * @version   1.5
 * @link      http://github.com/eoghanobrien/php-simple-mail
 */

/**
 * Simple Mail class.
 *
 * @category  SimpleMail
 * @package   SimpleMail
 * @author    Eoghan O'Brien <eoghan@eoghanobrien.com>
 * @copyright 2009 - 2014 Eoghan O'Brien
 * @license   http://github.com/eoghanobrien/php-simple-mail/LICENCE.txt MIT
 * @version   1.4
 * @link      http://github.com/eoghanobrien/php-simple-mail
 */
class SimpleMail
{
    /**
     * @var int $sm_wrap
     */
    protected $sm_wrap = 78;

    /**
     * @var array $sm_to
     */
    protected $sm_to = array();

    /**
     * @var string $sm_subject
     */
    protected $sm_subject;

    /**
     * @var string $sm_message
     */
    protected $sm_message;

    /**
     * @var array $sm_headers
     */
    protected $sm_headers = array();

    /**
     * @var string $sm_parameters
     */
    protected $sm_params;

    /**
     * @var array $sm_attachments
     */
    protected $sm_attachments = array();

    /**
     * @var string $sm_uid
     */
    protected $sm_uid;


    /**
     * __construct
     *
     * Resets the class properties.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * reset
     *
     * Resets all properties to initial state.
     *
     * @return SimpleMail
     */
    public function reset()
    {
        $this->sm_to = array();
        $this->sm_headers = array();
        $this->sm_subject = null;
        $this->sm_message = null;
        $this->sm_wrap = 78;
        $this->sm_params = null;
        $this->sm_attachments = array();
        $this->sm_uid = $this->getUniqueId();
        return $this;
    }

    /**
     * setTo
     *
     * @param string $email The email address to send to.
     * @param string $name  The name of the person to send to.
     *
     * @return SimpleMail
     */
    public function setTo($email, $name)
    {
        $this->sm_to[] = $this->formatHeader((string) $email, (string) $name);
        return $this;
    }

    /**
     * getTo
     *
     * Return an array of formatted To addresses.
     *
     * @return array
     */
    public function getTo()
    {
        return $this->sm_to;
    }

    /**
     * setSubject
     *
     * @param string $subject The email subject
     *
     * @return SimpleMail
     */
    public function setSubject($subject)
    {
        $this->sm_subject = $this->encodeUtf8(
            $this->filterOther((string) $subject)
        );
        return $this;
    }

    /**
     * getSubject function.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->sm_subject;
    }

    /**
     * setMessage
     *
     * @param string $message The message to send.
     *
     * @return SimpleMail
     */
    public function setMessage($message)
    {
        $this->sm_message = str_replace("\n.", "\n..", (string) $message);
        return $this;
    }

    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->sm_message;
    }

    /**
     * addAttachment
     *
     * @param string $path     The file path to the attachment.
     * @param string $filename The filename of the attachment when emailed.
     *
     * @return SimpleMail
     */
    public function addAttachment($path, $filename = null)
    {
        $filename = empty($filename) ? basename($path) : $filename;
        $this->sm_attachments[] = array(
            'path' => $path,
            'file' => $filename,
            'data' => $this->getAttachmentData($path)
        );
        return $this;
    }

    /**
     * getAttachmentData
     *
     * @param string $path The path to the attachment file.
     *
     * @return string
     */
    public function getAttachmentData($path)
    {
        $filesize = filesize($path);
        $handle = fopen($path, "r");
        $attachment = fread($handle, $filesize);
        fclose($handle);
        return chunk_split(base64_encode($attachment));
    }

    /**
     * setFrom
     *
     * @param string $email The email to send as from.
     * @param string $name  The name to send as from.
     *
     * @return SimpleMail
     */
    public function setFrom($email, $name)
    {
        $this->addMailHeader('From', (string) $email, (string) $name);
        return $this;
    }

    /**
     * addMailHeader
     *
     * @param string $header The header to add.
     * @param string $email  The email to add.
     * @param string $name   The name to add.
     *
     * @return SimpleMail
     */
    public function addMailHeader($header, $email = null, $name = null)
    {
        $address = $this->formatHeader((string) $email, (string) $name);
        $this->sm_headers[] = sprintf('%s: %s', (string) $header, $address);
        return $this;
    }

    /**
     * addGenericHeader
     *
     * @param string $header The generic header to add.
     * @param mixed  $value  The value of the header.
     *
     * @return SimpleMail
     */
    public function addGenericHeader($header, $value)
    {
        $this->sm_headers[] = sprintf(
            '%s: %s',
            (string) $header,
            (string) $value
        );
        return $this;
    }

    /**
     * getHeaders
     *
     * Return the headers registered so far as an array.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->sm_headers;
    }

    /**
     * setAdditionalParameters
     *
     * Such as "-fyouremail@yourserver.com
     *
     * @param string $additionalParameters The addition mail parameter.
     *
     * @return SimpleMail
     */
    public function setParameters($additionalParameters)
    {
        $this->sm_params = (string) $additionalParameters;
        return $this;
    }

    /**
     * getAdditionalParameters
     *
     * @return string
     */
    public function getParameters()
    {
        return $this->sm_params;
    }

    /**
     * setWrap
     *
     * @param int $wrap The number of characters at which the message will wrap.
     *
     * @return SimpleMail
     */
    public function setWrap($wrap = 78)
    {
        $wrap = (int) $wrap;
        if ($wrap < 1) {
            $wrap = 78;
        }
        $this->sm_wrap = $wrap;
        return $this;
    }

    /**
     * getWrap
     *
     * @return int
     */
    public function getWrap()
    {
        return $this->sm_wrap;
    }

    /**
     * hasAttachments
     * 
     * Checks if the email has any registered attachments.
     *
     * @return bool
     */
    public function hasAttachments()
    {
        return !empty($this->sm_attachments);
    }

    /**
     * assembleAttachment
     *
     * @return string
     */
    public function assembleAttachmentHeaders()
    {
        $head = array();
        $head[] = "MIME-Version: 1.0";
        $head[] = "Content-Type: multipart/mixed; boundary=\"{$this->sm_uid}\"";

        return join(PHP_EOL, $head);
    }

    /**
     * assembleAttachmentBody
     *
     * @return string
     */
    public function assembleAttachmentBody()
    {
        $body = array();
        $body[] = "This is a multi-part message in MIME format.";
        $body[] = "--{$this->sm_uid}";
        $body[] = "Content-type:text/html; charset=\"utf-8\"";
        $body[] = "Content-Transfer-Encoding: 7bit";
        $body[] = "";
        $body[] = $this->sm_message;
        $body[] = "";
        $body[] = "--{$this->sm_uid}";

        foreach ($this->sm_attachments as $attachment) {
            $body[] = $this->getAttachmentMimeTemplate($attachment);
        }

        return implode(PHP_EOL, $body);
    }

    /**
     * getAttachmentMimeTemplate
     *
     * @param array  $attachment An array containing 'file' and 'data' keys.
     * @param string $uid        A unique identifier for the boundary.
     *
     * @return string
     */
    public function getAttachmentMimeTemplate($attachment)
    {
        $file = $attachment['file'];
        $data = $attachment['data'];

        $head = array();
        $head[] = "Content-Type: application/octet-stream; name=\"{$file}\"";
        $head[] = "Content-Transfer-Encoding: base64";
        $head[] = "Content-Disposition: attachment; filename=\"{$file}\"";
        $head[] = "";
        $head[] = $data;
        $head[] = "";
        $head[] = "--{$this->sm_uid}";

        return implode(PHP_EOL, $head);
    }

    /**
     * send
     *
     * @throws \RuntimeException on no 'To: ' address to send to.
     * @return boolean
     */
    public function send()
    {
        $to = $this->getToForSend();
        $headers = $this->getHeadersForSend();

        if (empty($to)) {
            throw new \RuntimeException(
                'Unable to send, no To address has been set.'
            );
        }

        if ($this->hasAttachments()) {
            $message  = $this->assembleAttachmentBody();
            $headers .= PHP_EOL . $this->assembleAttachmentHeaders();
        } else {
            $message = $this->getWrapMessage();
        }

        return mail($to, $this->sm_subject, $message, $headers, $this->sm_params);
    }

    /**
     * debug
     *
     * @return string
     */
    public function debug()
    {
        return '<pre>' . print_r($this, true) . '</pre>';
    }

    /**
     * magic __toString function
     *
     * @return string
     */
    public function __toString()
    {
        return print_r($this, true);
    }

    /**
     * formatHeader
     *
     * Formats a display address for emails according to RFC2822 e.g.
     * Name <address@domain.tld>
     *
     * @param string $email The email address.
     * @param string $name  The display name.
     *
     * @return string
     */
    public function formatHeader($email, $name = null)
    {
        $email = $this->filterEmail($email);
        if (empty($name)) {
            return $email;
        }
        $name = $this->encodeUtf8($this->filterName($name));
        return sprintf('"%s" <%s>', $name, $email);
    }

    /**
     * encodeUtf8
     *
     * @param string $value The value to encode.
     *
     * @return string
     */
    public function encodeUtf8($value)
    {
        $value = trim($value);
        if (preg_match('/(\s)/', $value)) {
            return $this->encodeUtf8Words($value);
        }
        return $this->encodeUtf8Word($value);
    }

    /**
     * encodeUtf8Word
     *
     * @param string $value The word to encode.
     *
     * @return string
     */
    public function encodeUtf8Word($value)
    {
        return sprintf('=?UTF-8?B?%s?=', base64_encode($value));
    }

    /**
     * encodeUtf8Words
     *
     * @param string $value The words to encode.
     *
     * @return string
     */
    public function encodeUtf8Words($value)
    {
        $words = explode(' ', $value);
        $encoded = array();
        foreach ($words as $word) {
            $encoded[] = $this->encodeUtf8Word($word);
        }
        return join($this->encodeUtf8Word(' '), $encoded);
    }

    /**
     * filterEmail
     *
     * Removes any carriage return, line feed, tab, double quote, comma
     * and angle bracket characters before sanitizing the email address.
     *
     * @param string $email The email to filter.
     *
     * @return string
     */
    public function filterEmail($email)
    {
        $rule = array(
            "\r" => '',
            "\n" => '',
            "\t" => '',
            '"'  => '',
            ','  => '',
            '<'  => '',
            '>'  => ''
        );
        $email = strtr($email, $rule);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $email;
    }

    /**
     * filterName
     *
     * Removes any carriage return, line feed or tab characters. Replaces
     * double quotes with single quotes and angle brackets with square
     * brackets, before sanitizing the string and stripping out html tags.
     *
     * @param string $name The name to filter.
     *
     * @return string
     */
    public function filterName($name)
    {
        $rule = array(
            "\r" => '',
            "\n" => '',
            "\t" => '',
            '"'  => "'",
            '<'  => '[',
            '>'  => ']',
        );
        $filtered = filter_var(
            $name,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_NO_ENCODE_QUOTES
        );
        return trim(strtr($filtered, $rule));
    }

    /**
     * filterOther
     *
     * Removes ASCII control characters including any carriage return, line
     * feed or tab characters.
     *
     * @param string $data The data to filter.
     *
     * @return string
     */
    public function filterOther($data)
    {
        return filter_var($data, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW);
    }

    /**
     * getHeadersForSend
     *
     * @return string
     */
    public function getHeadersForSend()
    {
        if (empty($this->sm_headers)) {
            return '';
        }
        return join(PHP_EOL, $this->sm_headers);
    }

    /**
     * getToForSend
     *
     * @return string
     */
    public function getToForSend()
    {
        if (empty($this->sm_to)) {
            return '';
        }
        return join(', ', $this->sm_to);
    }

    /**
     * getUniqueId
     *
     * @return string
     */
    public function getUniqueId()
    {
        return md5(uniqid(time()));
    }

    /**
     * getWrapMessage
     *
     * @return string
     */
    public function getWrapMessage()
    {
        return wordwrap($this->sm_message, $this->sm_wrap);
    }
}
