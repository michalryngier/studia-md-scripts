<?php

include "PrintHelper.php";
include "PrimeHelper.php";

class StringNotation
{
    protected $number1, $number2;

    public function __construct(int $number1, ?int $number2 = null)
    {
        $this->number1 = $number1;
        $this->number2 = $number2;
    }

    public function main() : void
    {
        $arr = $this->factorizeWithPrint();
        PrintHelper::printSingle("Wynik: ");
        PrintHelper::printArray($arr);
    }

    protected function factorizeWithPrint() : array
    {
        if (is_null($this->number2)) {
            PrintHelper::printLine("Rozkład na czynniki pierwsze liczby: $this->number1");
        } else {
            PrintHelper::printLine("Rozkład na czynniki pierwsze liczb: $this->number1 i $this->number2");
        }
        PrintHelper::printLine();
        if (is_null($this->number2)) {
            return self::factorizeNumberPrint($this->number1);
        } else {
            $arr1 = self::factorizeNumberPrint($this->number1);
            $arr2 = self::factorizeNumberPrint($this->number2);
            return self::merge($arr1, $arr2);
        }
    }

    private static function factorizeNumberPrint(int $number) : array
    {
        PrintHelper::printLine("Liczba: $number");
        PrintHelper::printLine();
        $firstPrime = PrimeHelper::findNextPrime(0);
        $primeCounter = 0;
        $prime = $firstPrime;
        $factorized = [];
        $toDivide = $number;
        while ($toDivide !== 1) {
            if ($toDivide % $prime === 0) {
                if (isset($factorized[$primeCounter])) {
                    $factorized[$primeCounter]++;
                } else {
                    $factorized[$primeCounter] = 1;
                }
                PrintHelper::printDouble("$toDivide", $prime);
                $toDivide = $toDivide / $prime;
                $prime = $firstPrime;
                $primeCounter = 0;
            } else {
                $primeCounter++;
                $prime = PrimeHelper::findNextPrime($prime);
            }
        }
        return $factorized;
    }


    /* STATIC METHODS */

    public static function getFactorizedNumbers(int $number1, int $number2 = null) : array
    {
        $sn = new StringNotation($number1, $number2);
        return $sn->factorize();
    }

    public static function factorize(int $number1, ?int $number2 = null) : array
    {
        if (is_null($number2)) {
            return self::factorizeNumber($number1);
        } else {
            $arr1 = self::factorizeNumber($number1);
            $arr2 = self::factorizeNumber($number2);
            return self::merge($arr1, $arr2);
        }
    }

    protected static function merge(array $arr1, array $arr2) : array
    {
        $response = [];
        foreach ($arr1 as $key => $val) {
            $response[$key] = $val;
        }
        foreach ($arr2 as $key => $val) {
            if (isset($response[$key])) {
                $response[$key] += $val;
            } else {
                $response[$key] = $val;
            }
        }
        return $response;
    }

    protected static function factorizeNumber(int $number) : array
    {
        $firstPrime = PrimeHelper::findNextPrime(0);
        $primeCounter = 0;
        $prime = $firstPrime;
        $factorized = [];
        $toDivide = $number;
        while ($toDivide !== 1) {
            if ($toDivide % $prime === 0) {
                if (isset($factorized[$primeCounter])) {
                    $factorized[$primeCounter]++;
                } else {
                    $factorized[$primeCounter] = 1;
                }
                $toDivide = $toDivide / $prime;
                $prime = $firstPrime;
                $primeCounter = 0;
            } else {
                $primeCounter++;
                $prime = PrimeHelper::findNextPrime($prime);
            }
        }
        return $factorized;
    }

}

$number2 = null;
$number1 = 5265;
$sn = new StringNotation($number1, $number2);
$sn->main();
