<?php

namespace Moves\PPFormula;

class DateRangeFormula implements PPFormulaInterface
{
    public function test($arg0, $arg1)
    {
        return !is_array($arg0) && !is_array($arg1);
    }

    public function process($arg0, $arg1)
    {
        list($extraPath, $params) = array("", array('from' => $arg0, 'to' => $arg1));

        if (isset($params["to"]) && $params["to"] instanceof \DateTime) {
            $params["to"] = $params["to"]->format(PPFormulaInterface::FORMAT);
        }

        if (isset($params["from"]) && $params["from"] instanceof \DateTime) {
            $params["from"] = $params["from"]->format(PPFormulaInterface::FORMAT);
        }

        return array($extraPath, $params);
    }
}
