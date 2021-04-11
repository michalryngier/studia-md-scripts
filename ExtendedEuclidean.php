<?php

include "PrintHelper.php";

class ExtendedEuclidean
{
    protected $a;
    protected $b;
    protected $results = [];
    protected $NWD = 1;
    protected $xValue;
    protected $yValue;

    public function __construct(int $a, int $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function main(): void
    {
        $reversed = false;
        if ($this->b > $this->a) {
            $a = $this->b;
            $b = $this->a;
            $reversed = true;
        } else {
            $a = $this->a;
            $b = $this->b;
        }
        PrintHelper::printLine("Działanie rozszerzonego algorytmu Euklidesa dla a = $this->a oraz b = $this->b ");
        PrintHelper::printLine();
        do {
            $r = $a % $b;
            $integerDiv = (int)floor($a / $b);
            $multiplicative = (int)($a - $r) / $integerDiv;
            if ($r !== 0) {
                PrintHelper::printDouble(
                    "$a = $integerDiv * $multiplicative + $r",
                    "$a - $integerDiv * $multiplicative = $r"
                );
                $this->results[] = [
                    "a" => $a,
                    "integerDiv" => -$integerDiv,
                    "multiplicative" => $multiplicative,
                    "r" => $r
                ];
            } else {
                PrintHelper::printLine("$a = $integerDiv * $multiplicative + $r");
            }
            $a = $b;
            $b = $r;
        } while ($r > 0);

        if ($this->a % $a === 0 && $this->b % $a === 0) {
            $this->NWD = $a;
        }

        PrintHelper::printLine("NWD($this->a, $this->b) = $this->NWD");
        PrintHelper::printLine();

        if ($this->a % $this->b === 0 || $this->b % $this->a === 0) {
            $this->NWD = $reversed ? $this->a : $this->b;
            $this->xValue = 0;
            $this->yValue = 1;
        } else {
            PrintHelper::printLine($this->getResult());
            PrintHelper::printLine();
        }
        if ($reversed) {
            PrintHelper::printSingle(
                "NWD($this->a, $this->b) = $this->NWD = $this->a * "
                . (
                $this->yValue >= 0 ? $this->yValue : "($this->yValue)"
                )
                . " + $this->b * "
                . (
                $this->xValue >= 0 ? $this->xValue : "($this->xValue)"
                )
            );
            $checkValue = $this->a * $this->yValue + $this->b * $this->xValue;
        } else {
            PrintHelper::printSingle(
                "NWD($this->a, $this->b) = $this->NWD = $this->a * "
                . (
                $this->xValue >= 0 ? $this->xValue : "($this->xValue)"
                )
                . " + $this->b * "
                . (
                $this->yValue >= 0 ? $this->yValue : "($this->yValue)"
                )
            );
            $checkValue = $this->a * $this->xValue + $this->b * $this->yValue;
        }

        PrintHelper::printLine("   " . (($this->NWD === $checkValue) ? "PRAWDA" : "FAŁSZ"));
        PrintHelper::printLine();
        PrintHelper::printLine("x = $this->xValue    y = $this->yValue");
    }

    protected function getResult(): string
    {
        $resultsLastIndex = count($this->results) - 1;
        $responseString = "$this->NWD = ";
        for ($i = $resultsLastIndex; $i >= 0; $i--) {
            $result = $this->results[$i];
            if ($i === $resultsLastIndex) {
                $responseString .= $result["a"] . " - " . abs($result["integerDiv"]) . " * " . $result["multiplicative"];
            } else {
                if ($i === $resultsLastIndex - 1) {
                    $previousResult = $this->results[$i + 1];
                    $responseString .= "\n  = "
                        . $this->results[$i]["multiplicative"]
                        . ($previousResult["integerDiv"] >= 0 ? " + " : " - ")
                        . abs($previousResult["integerDiv"])
                        . " * ("
                        . $result["a"] . " - " . abs($result["integerDiv"]) . " * " . $result["multiplicative"]
                        . ")";
                    $this->results[$i]["a"] = $result["a"] * $previousResult["integerDiv"];
                    $this->results[$i]["integerDiv"] = $previousResult["integerDiv"] * $result["integerDiv"] + (
                        $this->results[$i]["a"] >= 0
                            ? -1
                            : 1
                        );
                    $responseString .= "\n  = "
                        . (
                        $previousResult["integerDiv"] >= 0
                            ? $previousResult["integerDiv"] . " * "
                            : "(" . $previousResult["integerDiv"] . ") * "
                        )
                        . $result["a"]
                        . ($this->results[$i]["integerDiv"] >= 0 ? " + " : " - ")
                        . abs($this->results[$i]["integerDiv"])
                        . " * "
                        . $result["multiplicative"];
                } else {
                    $previousResult = $this->results[$i + 1];
                    $responseString .= "\n  = "
                        . (
                        $this->results[$i + 2]["integerDiv"] >= 0
                            ? $this->results[$i + 2]["integerDiv"] . " * "
                            : "(" . $this->results[$i + 2]["integerDiv"] . ") * "
                        )
                        . $this->results[$i]["multiplicative"]
                        . ($previousResult["integerDiv"] >= 0 ? " + " : " - ")
                        . abs($previousResult["integerDiv"])
                        . " * ("
                        . $result["a"] . " - " . abs($result["integerDiv"]) . " * " . $result["multiplicative"]
                        . ")";
                    $this->results[$i]["a"] = $result["a"] * $previousResult["integerDiv"];
                    $this->results[$i]["integerDiv"] = $result["integerDiv"]
                        * $previousResult["integerDiv"]
                        + $this->results[$i + 2]["integerDiv"];
                    $responseString .= "\n  = "
                        . (
                        $previousResult["integerDiv"] >= 0
                            ? $previousResult["integerDiv"] . " * "
                            : "(" . $previousResult["integerDiv"] . ") * "
                        )
                        . $result["a"]
                        . ($this->results[$i]["integerDiv"] >= 0 ? " + " : " - ")
                        . abs($this->results[$i]["integerDiv"])
                        . " * "
                        . $result["multiplicative"];
                }
            }
            $this->yValue = $this->results[$i]["integerDiv"];
            $this->xValue = array_key_exists($i + 1, $this->results)
                ? $this->results[$i + 1]["integerDiv"]
                : 1;
        }
        return $responseString;
    }
}

$a = 24;
$b = 21;

$ee = new ExtendedEuclidean($a, $b);
$ee->main();
