<?php

namespace Moves\PPFormula;

/**
 * Build API request arguments for calls like:
 *  - $Moves->dailyStoryline();
 */
class CurrentDayFormula implements PPFormulaInterface
{
    public function test($arg0, $arg1)
    {
        return (false === $arg0 && false === $arg1);
    }

    public function process($arg0, $arg1)
    {
        list($extraPath, $params) = array("/" . date(PPFormulaInterface::FORMAT), false);
        return array($extraPath, $params);
    }
}
