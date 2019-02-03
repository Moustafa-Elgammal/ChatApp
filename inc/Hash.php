<?php

class Hash
{
    public static function make($word, $salt)
    {
        return sha1($word . $salt);
    }
}