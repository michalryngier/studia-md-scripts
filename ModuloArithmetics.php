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

    public static function resolveLinear(int $a, int $b, int $mod) : void
    {
        if (self::isReversible($a, $mod) === false)
            PrintHelper::printLine("Kongruencja nie ma rozwiązania.");
        else {
            $reverse = self::findReverse($a, $mod);
            $resolved = $b * self::findReverse($a, $mod);
            $lastModulo = $resolved % $mod;
            PrintHelper::printLine("Rozwiązaniem kongruencji jest:\nx === a^(-1) * b = $reverse * $b = $resolved === $lastModulo (mod $mod)");
        }
    }

    public static function relativelyFirst(array $args) : bool
    {
        for ($i = 0; $i < count($args); $i++)
            for ($j = $i + 1; $j < count($args); $j++)
                if (self::getGCD($args[$i], $args[$j]) !== 1) return false;
        return true;
    }

    public static function resolveSystem(array $system) : void
    {
        $x = 0;
        $M = 1;
        $xis = [];
        $Mis = [];
        if (self::relativelyFirst(array_map(function ($equation) {
            return $equation["m"];
        }, $system)) === false) PrintHelper::printLine("Układ nie ma rozwiązań.");

        /* M */
        PrintHelper::printSingle("\nM = ");
        array_walk($system, function (array $equation, int $key) use (&$M) {
            if ($key === 0) PrintHelper::printSingle($equation["m"]);
            else PrintHelper::printSingle(" * " . $equation["m"]);
            $M *= $equation["m"];
        });
        PrintHelper::printLine(" = $M");

        /* M_i */
        array_walk($system, function (array $equation, int $key) use ($M, &$Mis) {
            $val = $M / $equation["m"];
            PrintHelper::printLine("M_" . $key + 1 . " = $M / {$equation['m']} = $val");
            $Mis[] = $val;
        });

        /* X_i */
        array_walk($Mis, function (int $val, int $key) use ($system, &$xis) {
            $reverse = self::findReverse($val, $system[$key]["m"]) % $system[$key]["m"];
            PrintHelper::printLine("x_" . $key + 1 . " = $val^(-1) mod {$system[$key]['m']} = $reverse");
            $xis[] = $reverse;
        });

        /* X */
        PrintHelper::printSingle("x === ");
        array_walk($xis, function (int $val, int $key) use ($Mis, $system, &$x) {
            $string = $system[$key]["a"] . "*" . $Mis[$key] . "*" . $val;
            if ($key === 0) PrintHelper::printSingle($string);
            else PrintHelper::printSingle(" + $string");
            $x += $system[$key]["a"] * $Mis[$key] * $val;
        });
        PrintHelper::printLine(" = $x = " . $x % $M . " (mod $M)");
    }

    public static function euler(int $n) : int
    {
        $set = 0;
        for ($i = 1; $i < $n; $i++)
            if (self::relativelyFirst([$i, $n]))
                $set++;
        PrintHelper::printLine("\np($n) = $set");

        return $set;
    }

    public static function getAllEulerNumbers(int $n)
    {
        $numbs = [];
        for ($i = $n; $i < 10000; $i++) {
            if (self::euler($i) === $n) $numbs[] = $i;
        }
        return $numbs;
    }
}

$a = 7;
$b = 5;
$mod = 19;

//var_dump(ModuloArithmetics::getAllEulerNumbers(10));
//var_dump(ModuloArithmetics::findReverse(0, 7));
//ModuloArithmetics::euler(65);
ModuloArithmetics::resolveLinear($a, $b, $mod);
//var_dump(ModuloArithmetics::relativelyFirst([16, 125]));
//ModuloArithmetics::resolveSystem([
//    [
//        "a" => 9,
//        "m" => 4
//    ],
//    [
//        "a" => 0,
//        "m" => 9
//    ],
//    [
//        "a" => 72,
//        "m" => 25
//    ],
//]);