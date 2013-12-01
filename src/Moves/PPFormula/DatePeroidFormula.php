<?php

namespace Moves\PPFormula;

/**
 * Build API request arguments for calls like:
 *  - $Moves->dailySummary(array('from' => '2013-11-10', 'to' => '2013-11-20'));
 *  - $Moves->dailySummary(array('from' => new DateTime('2013-11-10'), 'to' => new DateTime('2013-11-20')));
 *  - $Moves->dailyActivities(array('pastDays' => 3));
 *  - $Moves->dailyStoryline(array('trackPoints' => 'true'));
 */
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
