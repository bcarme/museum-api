<?php


namespace App\Service;


class Hashtag
{
    public function generateHashtag(string $input) :string
    {
        $text = preg_replace("/(?![.=$'€%-])\p{P}/u", "", strtolower(trim($input)));
        $string = str_replace('and', '', $text);
        $inputTransform= str_replace('the', '', $string);
        $stringnospace = str_replace('-', '', $inputTransform);
        
        if($stringnospace > 21){
            $hashtag = substr($stringnospace, 0, 5);
        }
               
        $hashtag = '#'. $stringnospace;
        return $hashtag;
    }
}