<?php

namespace Moves\PPFormula;

interface PPFormulaInterface
{
    const FORMAT = "Y-m-d";

    public function test($arg0, $arg1);

    public function process($arg0, $arg1);
}
