<?php

include "PrintHelper.php";
include "PrimeHelper.php";

class StrongPrimes
{
    public static function maxPowerThatDividesTheNumber(int $prime, int $num) : int
    {
        $toPower = 1;
        $sum = 0;
        PrintHelper::printSingle("a_$prime = ");
        while(($divider = self::power($prime, $toPower)) <= $num) {
            if ($divider !== $prime) PrintHelper::printSingle(" + ");
            $sum += floor($num / $divider);
            PrintHelper::printSingle("⌊ $num / $divider ⌋");
            $toPower++;
        }
        PrintHelper::printSingle(" = $sum");
        PrintHelper::printLine("\nLiczba $num! jest podzielna przez $prime^$sum\n($prime^$sum | $num!)");
        return $sum;
    }

    public static function factorizeStrong(int $num, int $prime = 1)
    {
        $prime = PrimeHelper::findNextPrime($prime);
        if ($prime <= $num) {
            self::maxPowerThatDividesTheNumber($prime, $num);
            self::factorizeStrong($num, $prime);
        }
    }

    protected static function power(int $num, int $toPower) : int
    {
        return self::_power($num, $num, $toPower);
    }

    private static function _power(int $num, int $originalNum, int $toPower) : int
    {
        if ($toPower === 0) {
            return 1;
        }
        if ($toPower === 1) {
            return $num;
        }
        return self::_power($num * $originalNum, $originalNum, --$toPower);
    }
}

StrongPrimes::maxPowerThatDividesTheNumber(20, 500);