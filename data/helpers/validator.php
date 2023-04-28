<?php

class validator {
    /*
        Validates whether parameter is in email format 
        according to RFC 5322 standard (this is done by FILTER_VALIDATE_EMAIL filter)
    */
    public static function email($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
        return true;
    }

    /*
        Validates whether parameter is a password that has at least 8 symbols, 
        at least one special character, and at least one digit
    */
    public static function password($password)
    {
        if(!preg_match('/^(?=.*[!@#$%^&*()\-_=+{};:,<.>]{1,})(?=.*[0-9]{1,})(?=.*[a-zA-Z]{1,}).{8,}$/', $password))
        {
            return false;
        }
        return true;
    }

    /*
        Validates whether parameter is a 6-character string
    */
    public static function authCode($code)
    {
        if(!preg_match('/^.{6}$/', $code))
        {
            return false;
        }
        return true;
    }

    /*
        Validates whether parameter is a non-empty text string
    */
    public static function textNotEmpty($text)
    {
        if(strlen($text) == 0) return false;
        return true;
    }
}