<?php

namespace Moves\PPFormula;

class DatePeroidFormula implements PPFormulaInterface
{
    public function test($arg0, $arg1)
    {
        return is_array($arg0) && false === $arg1;
    }

    public function process($arg0, $arg1)
    {
        list($extraPath, $params) = array("", $arg0);

        if (isset($params['to']) && $params["to"] instanceof \DateTime) {
            $params["to"] = $params["to"]->format(PPFormulaInterface::FORMAT);
        }

        if (isset($params['from']) && $params["from"] instanceof \DateTime) {
            $params["from"] = $params["from"]->format(PPFormulaInterface::FORMAT);
        }

        if (!isset($params['from']) && !isset($params['to']) && !isset($params["pastDays"])) {
            $extraPath = "/" . date(PPFormulaInterface::FORMAT);
        }

        return array($extraPath, $params);
    }
}
