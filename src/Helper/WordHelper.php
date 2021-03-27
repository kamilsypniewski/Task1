<?php


namespace App\Helper;

class WordHelper
{
    public static function changeLetterOrder($word): string
    {
        $word = mb_str_split($word);
        $first = array_shift($word);
        $last = array_pop($word);
        shuffle($word);
        $word = implode($word);

        return $first . $word . $last;
    }

}