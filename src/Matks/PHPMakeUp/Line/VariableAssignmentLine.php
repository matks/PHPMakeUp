<?php

namespace Matks\PHPMakeUp\Line;

class VariableAssignmentLine
{

    /**
     * @var integer
     */
    private $lineNumber;

    /**
     * @var integer
     */
    private $partBefore;

    /**
     * @var integer
     */
    private $partAfter;

    public function __construct($lineNumber, $partBefore, $partAfter)
    {
        $this->lineNumber = $lineNumber;
        $this->partBefore = $partBefore;
        $this->partAfter  = $partAfter;
    }

    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    public function getPartBefore()
    {
        return $this->partBefore;
    }

    public function getPartAfter()
    {
        return $this->partAfter;
    }
}
