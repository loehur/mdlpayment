<?php

class Validasi
{
    function enc($text)
    {
        $newText = crypt(md5($text), md5("j499uL0v3ly&N3lyL0vEly_F0r3ver")) . md5(md5($text)) . crypt(md5($text), md5("saturday_10.06.2017_12.45"));
        return $newText;
    }
}
