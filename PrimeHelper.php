<?php


class PrimeHelper
{
    protected static function isPrime(int $number) : bool
    {
        if (in_array($number, [0, 1])) return false;
        if ($number === 2) return true;
        $stop = floor(sqrt($number));
        $i = 2;
        while ($i <= $stop) {
            if ($number % $i === 0) return false;
            $i++;
        }
        return true;
    }

    public static function findNextPrime(int $number) : int
    {
        $number++;
        $isPrime = self::isPrime($number);
        if ($isPrime === false) {
            return self::findNextPrime($number);
        }
        return $number;
    }
}