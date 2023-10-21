<?php  

namespace App\Models;

// convert kg to gram
if (!function_exists('kgToGram')) {
    function kgToGram($value)
    {
        return $value * 1000;
    }
}

// convert gram to kg
if (!function_exists('gramToKg')) {
    function gramToKg($value)
    {
        return $value / 1000;
    }
}

// convert liter to ml
if (!function_exists('literToMl')) {
    function literToMl($value)
    {
        return $value * 1000;
    }
}

// convert ml to liter
if (!function_exists('mlToLiter')) {
    function mlToLiter($value)
    {
        return $value / 1000;
    }
}