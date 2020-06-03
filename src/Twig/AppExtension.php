<?php


// app/src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('slugify', [$this, 'slugify']),
        ];
    }

    public function slugify(string $input) :string
    {
        setlocale(LC_CTYPE, 'fr_FR');
        $inputTransform = iconv('UTF-8','ASCII//TRANSLIT', strtolower(trim($input)));
        $slugNoSign = preg_replace('/\W/', ' ', $inputTransform);
        $slug = preg_replace('(\s+)', "-", $slugNoSign);
        return $slug;
    }
}