<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch;

class Slug
{
    public function make($s)
    {
        $patterns = array(
            '/Ä/' => 'Ae',
            '/Á/' => 'A',
            '/À/' => 'A',
            '/Â/' => 'A',
            '/ä/' => 'ae',
            '/á/' => 'a',
            '/à/' => 'a',
            '/â/' => 'a',
            '/Ö/' => 'Oe',
            '/Ó/' => 'O',
            '/Ò/' => 'O',
            '/Ô/' => 'O',
            '/ö/' => 'oe',
            '/ó/' => 'o',
            '/ò/' => 'o',
            '/ô/' => 'o',
            '/Ü/' => 'Ue',
            '/Ú/' => 'U',
            '/Ù/' => 'U',
            '/ü/' => 'ue',
            '/ú/' => 'u',
            '/ù/' => 'u',
            '/É/' => 'E',
            '/È/' => 'E',
            '/é/' => 'e',
            '/è/' => 'e',
            '/î/' => 'i',
            '/\'s/i' => 's',
            '/[^a-zA-Z0-9_]/' => '_',
            '/_+/' => '_'
        );

        foreach ($patterns as $find => $replace)
        {
            $s = preg_replace($find, $replace, $s);
        }

        $s = trim($s, '_');

        if(!$s)
        {
            $s = uniqid();
        }

        return mb_strtolower($s);
    }   
}