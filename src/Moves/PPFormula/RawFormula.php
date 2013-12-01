<?php

namespace Moves\PPFormula;

class RawFormula implements PPFormulaInterface
{
    public function test($arg0, $arg1)
    {
        return is_string($arg0) && is_array($arg1);
    }

    public function process($arg0, $arg1)
    {
        list($extraPath, $params) = array("/{$arg0}", $arg1);

        return array($extraPath, $params);
    }
}
