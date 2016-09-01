<?php


/**
 * Squiloople Framework
 *
 * LICENSE: Feel free to use and redistribute this code.
 *
 * @author Michael Rushton <michael@squiloople.com>
 * @link http://squiloople.com/
 * @package Squiloople
 * @version 1.0
 * @copyright © 2012 Michael Rushton
 */

namespace Torpedo\ValueObjects\Web;

/**
 * Email Address Validator
 *
 * Validate email addresses according to the relevant standards
 */

final class EmailAddressValidator
{
    // The RFC 5321 constant
    const RFC_5321 = 5321;
    // The RFC 5322 constant
    const RFC_5322 = 5322;
    /**
     * The email address
     *
     * @access private
     * @var string $_email_address
     */
    private $_email_address;
    /**
     * A quoted string local part is either allowed (true) or not (false)
     *
     * @access private
     * @var boolean $_quoted_string
     */
    private $_quoted_string = false;
    /**
     * An obsolete local part is either allowed (true) or not (false)
     *
     * @access private
     * @var boolean $_obsolete
     */
    private $_obsolete = false;
    /**
     * A basic domain name is either required (true) or not (false)
     *
     * @access private
     * @var boolean $_basic_domain_name
     */
    private $_basic_domain_name = true;
    /**
     * A domain literal domain is either allowed (true) or not (false)
     *
     * @access private
     * @var boolean $_domain_literal
     */
    private $_domain_literal = false;
    /**
     * Comments and folding white spaces are either allowed (true) or not (false)
     *
     * @access private
     * @var boolean $_cfws
     */
    private $_cfws = false;

    /**
     * Set the email address and turn on the relevant standard if required
     *
     * @access public
     * @param string $email_address
     * @param null|integer $standard
     */
    public function __construct($email_address, $standard = null)
    {
        // Set the email address
        $this->_email_address = $email_address;
        // Set the relevant standard or throw an exception if an unknown is requested
        switch ($standard) {
            // Do nothing if no standard requested
            case null:
                break;
            // Otherwise if RFC 5321 requested
            case self::RFC_5321:
                $this->setStandard5321();
                break;
            // Otherwise if RFC 5322 requested
            case self::RFC_5322:
                $this->setStandard5322();
                break;
            // Otherwise throw an exception
            default:
                throw new Exception('Unknown RFC standard for email address validation.');
        }
    }

    /**
     * Call the constructor fluently
     *
     * @access public
     * @static
     * @param string $email_address
     * @param null|integer $standard
     * @return EmailAddressValidator
     */
    public static function setEmailAddress($email_address, $standard = null)
    {
        return new self($email_address, $standard);
    }

    /**
     * Validate the email address using a basic standard
     *
     * @access public
     * @return EmailAddressValidator
     */
    public function setStandardBasic()
    {
        // A quoted string local part is not allowed
        $this->_quoted_string = false;
        // An obsolete local part is not allowed
        $this->_obsolete = false;
        // A basic domain name is required
        $this->_basic_domain_name = true;
        // A domain literal domain is not allowed
        $this->_domain_literal = false;
        // Comments and folding white spaces are not allowed
        $this->_cfws = false;
        // Return the EmailAddressValidator object
        return $this;
    }

    /**
     * Validate the email address using RFC 5321
     *
     * @access public
     * @return EmailAddressValidator
     */
    public function setStandard5321()
    {
        // A quoted string local part is allowed
        $this->_quoted_string = true;
        // An obsolete local part is not allowed
        $this->_obsolete = false;
        // Only a basic domain name is not required
        $this->_basic_domain_name = false;
        // A domain literal domain is allowed
        $this->_domain_literal = true;
        // Comments and folding white spaces are not allowed
        $this->_cfws = false;
        // Return the EmailAddressValidator object
        return $this;
    }

    /**
     * Validate the email address using RFC 5322
     *
     * @access public
     * @return EmailAddressValidator
     */
    public function setStandard5322()
    {
        // A quoted string local part is disallowed
        $this->_quoted_string = false;
        // An obsolete local part is allowed
        $this->_obsolete = true;
        // Only a basic domain name is not required
        $this->_basic_domain_name = false;
        // A domain literal domain is allowed
        $this->_domain_literal = true;
        // Comments and folding white spaces are allowed
        $this->_cfws = true;
        // Return the EmailAddressValidator object
        return $this;
    }

    /**
     * Either allow (true) or do not allow (false) a quoted string local part
     *
     * @access public
     * @param boolean $allow
     * @return EmailAddressValidator
     */
    public function setQuotedString($allow = true)
    {
        // Either allow (true) or do not allow (false) a quoted string local part
        $this->_quoted_string = $allow;
        // Return the EmailAddressValidator object
        return $this;
    }

    /**
     * Either allow (true) or do not allow (false) an obsolete local part
     *
     * @access public
     * @param boolean $allow
     * @return EmailAddressValidator
     */
    public function setObsolete($allow = true)
    {
        // Either allow (true) or do not allow (false) an obsolete local part
        $this->_obsolete = $allow;
        // Return the EmailAddressValidator object
        return $this;
    }

    /**
     * Either require (true) or do not require (false) a basic domain name
     *
     * @access public
     * @param boolean $allow
     * @return EmailAddressValidator
     */
    public function setBasicDomainName($allow = true)
    {
        // Either require (true) or do not require (false) a basic domain name
        $this->_basic_domain_name = $allow;
        // Return the EmailAddressValidator object
        return $this;
    }

    /**
     * Either allow (true) or do not allow (false) a domain literal domain
     *
     * @access public
     * @param boolean $allow
     * @return EmailAddressValidator
     */
    public function setDomainLiteral($allow = true)
    {
        // Either allow (true) or do not allow (false) a domain literal domain
        $this->_domain_literal = $allow;
        // Return the EmailAddressValidator object
        return $this;
    }

    /**
     * Either allow (true) or do not allow (false) comments and folding white spaces
     *
     * @access public
     * @param boolean $allow
     * @return EmailAddressValidator
     */
    public function setCFWS($allow = true)
    {
        // Either allow (true) or do not allow (false) comments and folding white spaces
        $this->_cfws = $allow;
        // Return the EmailAddressValidator object
        return $this;
    }

    /**
     * Return the regular expression for a dot atom local part
     *
     * @access private
     * @return string
     */
    private function _getDotAtom()
    {
        return "([!#-'*+\/-9=?^-~-]+)(?>\.(?1))*";
    }

    /**
     * Return the regular expression for a quoted string local part
     *
     * @access private
     * @return string
     */
    private function _getQuotedString()
    {
        return '"(?>[ !#-\[\]-~]|\\\[ -~])*"';
    }

    /**
     * Return the regular expression for an obsolete local part
     *
     * @access private
     * @return string
     */
    private function _getObsolete()
    {
        return '([!#-\'*+\/-9=?^-~-]+|"(?>'
        . $this->_getFWS()
        . '(?>[\x01-\x08\x0B\x0C\x0E-!#-\[\]-\x7F]|\\\[\x00-\xFF]))*'
        . $this->_getFWS()
        . '")(?>'
        . $this->_getCFWS()
        . '\.'
        . $this->_getCFWS()
        . '(?1))*';
    }

    /**
     * Return the regular expression for a domain name domain
     *
     * @access private
     * @return string
     */
    private function _getDomainName()
    {
        // Return the basic domain name format if required
        if ($this->_basic_domain_name) {
            return '(?>' . $this->_getDomainNameLengthLimit()
            . '[a-z\d](?>[a-z\d-]*[a-z\d])?'
            . $this->_getCFWS()
            . '\.'
            . $this->_getCFWS()
            . '){1,126}[a-z]{2,6}';
        }
        // Otherwise return the full domain name format
        return $this->_getDomainNameLengthLimit()
        . '([a-z\d](?>[a-z\d-]*[a-z\d])?)(?>'
        . $this->_getCFWS()
        . '\.'
        . $this->_getDomainNameLengthLimit()
        . $this->_getCFWS()
        . '(?2)){0,126}';
    }

    /**
     * Return the regular expression for an IPv6 address
     *
     * @access private
     * @return string
     */
    private function _getIPv6()
    {
        return '([a-f\d]{1,4})(?>:(?3)){7}|(?!(?:.*[a-f\d][:\]]){8,})((?3)(?>:(?3)){0,6})?::(?4)?';
    }

    /**
     * Return the regular expression for an IPv4-mapped IPv6 address
     *
     * @access private
     * @return string
     */
    private function _getIPv4MappedIPv6()
    {
        return '(?3)(?>:(?3)){5}:|(?!(?:.*[a-f\d]:){6,})(?5)?::(?>((?3)(?>:(?3)){0,4}):)?';
    }

    /**
     * Return the regular expression for an IPv4 address
     *
     * @access private
     * @return string
     */
    private function _getIPv4()
    {
        return '(25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)(?>\.(?6)){3}';
    }

    /**
     * Return the regular expression for a domain literal domain
     *
     * @access private
     * @return string
     */
    private function _getDomainLiteral()
    {
        return '\[(?:(?>IPv6:(?>'
        . $this->_getIPv6()
        . '))|(?>(?>IPv6:(?>'
        . $this->_getIPv4MappedIPv6()
        . '))?'
        . $this->_getIPv4()
        . '))\]';
    }

    /**
     * Return either the regular expression for folding white spaces or its backreference
     *
     * @access private
     * @param boolean $define
     * @return string
     */
    private function _getFWS($define = false)
    {
        // Return the backreference if $define is set to FALSE otherwise return the regular expression
        if ($this->_cfws) {
            return !$define ? '(?P>fws)' : '(?<fws>(?>(?>(?>\x0D\x0A)?[\t ])+|(?>[\t ]*\x0D\x0A)?[\t ]+)?)';
        }
    }

    /**
     * Return the regular expression for comments
     *
     * @access private
     * @return string
     */
    private function _getComments()
    {
        return '(?<comment>\((?>'
        . $this->_getFWS()
        . '(?>[\x01-\x08\x0B\x0C\x0E-\'*-\[\]-\x7F]|\\\[\x00-\x7F]|(?P>comment)))*'
        . $this->_getFWS()
        . '\))';
    }

    /**
     * Return either the regular expression for comments and folding white spaces or its backreference
     *
     * @access private
     * @param boolean $define
     * @return string
     */
    private function _getCFWS($define = false)
    {
        // Return the backreference if $define is set to FALSE
        if ($this->_cfws && !$define) {
            return '(?P>cfws)';
        }
        // Otherwise return the regular expression
        if ($this->_cfws) {
            return '(?<cfws>(?>(?>(?>'
            . $this->_getFWS(true)
            . $this->_getComments()
            . ')+'
            . $this->_getFWS()
            . ')|'
            . $this->_getFWS()
            . ')?)';
        }
    }

    /**
     * Establish and return the valid format for the local part
     *
     * @access private
     * @return string
     */
    private function _getLocalPart()
    {
        // The local part may be obsolete if allowed
        if ($this->_obsolete) {
            return $this->_getObsolete();
        }
        // Otherwise the local part must be either a dot atom or a quoted string if the latter is allowed
        if ($this->_quoted_string) {
            return '(?>' . $this->_getDotAtom() . '|' . $this->_getQuotedString() . ')';
        }
        // Otherwise the local part must be a dot atom
        return $this->_getDotAtom();
    }

    /**
     * Establish and return the valid format for the domain
     *
     * @access private
     * @return string
     */
    private function _getDomain()
    {
        // The domain must be either a domain name or a domain literal if the latter is allowed
        if ($this->_domain_literal) {
            return '(?>' . $this->_getDomainName() . '|' . $this->_getDomainLiteral() . ')';
        }
        // Otherwise the domain must be a domain name
        return $this->_getDomainName();
    }

    /**
     * Return the email address length limit
     *
     * @access private
     * @return string
     */
    private function _getEmailAddressLengthLimit()
    {
        return '(?!(?>' . $this->_getCFWS() . '"?(?>\\\[ -~]|[^"])"?' . $this->_getCFWS() . '){255,})';
    }

    /**
     * Return the local part length limit
     *
     * @access private
     * @return string
     */
    private function _getLocalPartLengthLimit()
    {
        return '(?!(?>' . $this->_getCFWS() . '"?(?>\\\[ -~]|[^"])"?' . $this->_getCFWS() . '){65,}@)';
    }

    /**
     * Establish and return the domain name length limit
     *
     * @access private
     * @return string
     */
    private function _getDomainNameLengthLimit()
    {
        return '(?!' . $this->_getCFWS() . '[a-z\d-]{64,})';
    }

    /**
     * Check to see if the domain can be resolved to MX RRs
     *
     * @access private
     * @param array $domain
     * @return integer|boolean
     */
    private function _verifyDomain($domain)
    {
        // Return 0 if the domain cannot be resolved to MX RRs
        if (!checkdnsrr(end($domain), 'MX')) {
            return 0;
        }
        // Otherwise return true
        return true;
    }

    /**
     * Perform the validation check on the email address's syntax and, if required, call _verifyDomain()
     *
     * @access public
     * @param boolean $verify
     * @return boolean|integer
     */
    public function isValid($verify = false)
    {
        // Return false if the email address has an incorrect syntax
        if (!preg_match(
            '/^'
            . $this->_getEmailAddressLengthLimit()
            . $this->_getLocalPartLengthLimit()
            . $this->_getCFWS()
            . $this->_getLocalPart()
            . $this->_getCFWS()
            . '@'
            . $this->_getCFWS()
            . $this->_getDomain()
            . $this->_getCFWS(true)
            . '$/isD'
            , $this->_email_address
        )
        ) {
            return false;
        }
        // Otherwise check to see if the domain can be resolved to MX RRs if required
        if ($verify) {
            return $this->_verifyDomain(explode('@', $this->_email_address));
        }
        // Otherwise return 1
        return 1;
    }
}