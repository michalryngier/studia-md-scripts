<?php

include "PrintHelper.php";

class ModuloArithmetics
{
    public static function isReversible(int $num, int $modulo) : bool
    {
        return self::getGCD($num, $modulo) === 1;
    }

    protected static function getGCD(int $first, int $second) : int
    {
        $rest = $first % $second;
        if ($rest === 0) {
            return $second;
        }
        return self::getGCD($second, $rest);
    }

    public static function findReverse(int $num, int $modulo) : int|bool
    {
        if (self::isReversible($num, $modulo)) {
            return self::_findReverse($num, $modulo);
        }
        return false;
    }

    protected static function _findReverse(int $num, int $modulo) : int
    {
        $reverse = 0;
        while ($reverse % $modulo < $modulo) {
            if (($reverse * $num) % $modulo === 1) return $reverse;
            $reverse++;
        }
        return -1;
    }
}

$number = 3;
$mod = 8;

$ma = ModuloArithmetics::findReverse($number, $mod);

if ($ma) {
    PrintHelper::printLine("$ma jest liczbą odwrotna do $number modulo $mod");
} else {
    PrintHelper::printLine("Nie istnieje liczba odwrotna do $number modulo $mod");
}
