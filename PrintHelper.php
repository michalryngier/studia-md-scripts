<?php

class PrintHelper
{
    const LINE_WIDTH = 60;

    public static function printLine(string $s = "") : void
    {
        echo $s . PHP_EOL;
    }

    public static function printSingle($s = "") : void
    {
        echo $s;
    }

    public static function printDouble(string $s1, string $s2) : void
    {
        echo self::createDoubleLine($s1, $s2) . PHP_EOL;
    }

    public static function createDoubleLine(string $s1, string$s2) : string
    {
        $firstStringPrinted = false;
        $responseString = $s1;
        $spaceLength = self::LINE_WIDTH / 2 - strlen($s1);
        for ($i = 0; $i < $spaceLength; $i++) {
            $responseString .= " ";
            if ($i === $spaceLength - 1 && $firstStringPrinted === false) {
                $firstStringPrinted = true;
                $responseString .= "|";
                $i = 0;
                $spaceLength = self::LINE_WIDTH / 2 - strlen($s2);
            }
        }
        $responseString .= $s2;
        return $responseString;
    }

    public static function printArray(array $arr)
    {
        $index = 0;
        $keys = array_keys($arr);
        sort($keys);
        $lastIndex = $keys[count($keys) - 1];
        self::printSingle("[ ");
        while ($index <= $lastIndex) {
            if (isset($arr[$index])) {
                self::printSingle($arr[$index] . ", ");
            } else {
                self::printSingle("0, ");
            }
            $index++;
        }
        self::printSingle("0 ]");
    }

    public static function quickArray(array $arr)
    {
        self::printSingle("[ ");
        foreach ($arr as $el) {
            self::printSingle("$el, ");
        }
        self::printSingle(" ]");
    }
}