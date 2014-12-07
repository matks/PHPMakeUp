<?php

namespace Matks\PHPMakeUp\LineAlignment;

use Matks\PHPMakeUp\LineAlignment\VariableAssignmentLine as Line;
use RuntimeException;

/**
 * Variable Assignment Line Block
 */
class VariableAssignmentLineBlock
{
    const STATUS_NEW   = 'new';
    const STATUS_VALID = 'valid';

    /**
     * @var Line[]
     */
    private $lines = array();

    /**
     * @var string
     */
    private $assignmentCharacter;

    /**
     * @var string
     */
    private $status;

    /**
     * @param string $assignmentCharacter
     */
    public function __construct($assignmentCharacter)
    {
        $this->status              = static::STATUS_NEW;
        $this->assignmentCharacter = $assignmentCharacter;
    }

    /**
     * @param VariableAssignmentLine $line
     *
     * @return $this
     */
    public function addLine(Line $line)
    {
        $this->lines[] = $line;

        if ($this->count() > 1) {
            $this->status = static::STATUS_VALID;
        }

        return $this;
    }

    /**
     * @return VariableAssignmentLine
     */
    public function getFirstLine()
    {
        $lines = $this->lines;

        if (empty($lines)) {
            throw new RuntimeException('Cannot get first line, no lines in this block');
        }

        return $lines[0];
    }

    /**
     * @return VariableAssignmentLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return string
     */
    public function getAssignmentCharacter()
    {
        return $this->assignmentCharacter;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->lines);
    }

    /**
     * @return int
     */
    public function getAlignment()
    {
        $highestLength = 0;
        foreach ($this->lines as $line) {
            $partBefore = $line->getPartBefore();

            if (strlen($partBefore) > $highestLength) {
                $highestLength = strlen($partBefore);
            }
        }

        return $highestLength;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (static::STATUS_VALID === $this->status);
    }
}
