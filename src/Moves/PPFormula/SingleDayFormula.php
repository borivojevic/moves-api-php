<?php

namespace Moves\PPFormula;

/**
 * Build API request arguments for calls like:
 *  - $Moves->dailyPlaces();
 *  - $Moves->dailyPlaces('2013-11-20');
 *  - $Moves->dailyPlaces('2013-W48');
 *  - $Moves->dailySummary(new DateTime('2013-11-20'));
 */
class SingleDayFormula implements PPFormulaInterface
{
    public function test($arg0, $arg1)
    {
        return !is_array($arg0) && ($arg1 === false || is_array($arg1));
    }

    public function process($arg0, $arg1)
    {
        $date = $arg0;
        if ($arg0 instanceof \DateTime) {
            $date = $arg0->format(PPFormulaInterface::FORMAT);
        }
        list($extraPath, $params) = array("/$date", $arg1);
        return array($extraPath, $params);
    }
}
