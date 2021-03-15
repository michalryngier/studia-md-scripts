<?php

include "PrintHelper.php";
include "PrimeHelper.php";

class DividersAndMultiplications
{
    protected $a, $b;

    public function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function main()
    {
    }
}

$a = 0;
$b = 0;
$dam = new DividersAndMultiplications();