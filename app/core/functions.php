<?php

function kebabToPascal($kebabString)
{
    $words = explode('-', $kebabString);
    $pascalString = '';

    foreach ($words as $word) {
        $pascalString .= ucfirst($word);
    }

    return $pascalString;
}
