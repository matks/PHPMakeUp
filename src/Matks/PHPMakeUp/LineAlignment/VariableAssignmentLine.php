<?php

namespace Matks\PHPMakeUp\LineAlignment;

/**
 * Variable Assignment Line
 */
class VariableAssignmentLine
{

    /**
     * @var integer
     */
    private $lineNumber;

    /**
     * @var string
     */
    private $partBefore;

    /**
     * @var string
     */
    private $partAfter;

    /**
     * @param int    $lineNumber
     * @param string $partBefore
     * @param string $partAfter
     */
    public function __construct($lineNumber, $partBefore, $partAfter)
    {
        $this->lineNumber = $lineNumber;
        $this->partBefore = $partBefore;
        $this->partAfter  = $partAfter;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @return string
     */
    public function getPartBefore()
    {
        return $this->partBefore;
    }

    /**
     * @return string
     */
    public function getPartAfter()
    {
        return $this->partAfter;
    }
}
