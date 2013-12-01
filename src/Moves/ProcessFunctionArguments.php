<?php

namespace Moves;

class ProcessFunctionArguments
{
    protected $formulas = array();

    public function __construct()
    {
        $this->addFormula(new PPFormula\CurrentDayFormula());
        $this->addFormula(new PPFormula\SingleDayFormula());
        $this->addFormula(new PPFormula\DateRangeFormula());
        $this->addFormula(new PPFormula\DatePeroidFormula());
        $this->addFormula(new PPFormula\RawFormula());
    }

    public function process($arg0, $arg1)
    {
        foreach ($this->formulas as $formula) {
            if ($formula->test($arg0, $arg1)) {
                return $formula->process($arg0, $arg1);
            }
        }
    }

    private function addFormula(PPFormula\PPFormulaInterface $formula)
    {
        $this->formulas[] = $formula;
    }
}
