<?php

namespace Matks\PHPMakeUp\Line;

use Matks\PHPMakeUp\Line\VariableAssignmentLine as Line;
use RuntimeException;

class VariableAssignmentLineBlock
{
    const STATUS_NEW   = 'new';
    const STATUS_VALID = 'valid';

    /**
     * @var Line
     */
    private $lines = array();

    private $status;

    public function __construct()
    {
        $this->status = static::STATUS_NEW;
    }

    public function addLine(Line $line)
    {
        $this->lines[] = $line;

        if ($this->count() > 1) {
            $this->status = static::STATUS_VALID;
        }

        return $this;
    }

    public function getFirstLine()
    {
        $lines = $this->lines;

        if (empty($lines)) {
            throw new RuntimeException('Cannot get first line, no lines in this block');
        }

        return $lines[0];
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function count()
    {
        return count($this->lines);
    }

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

    public function isValid()
    {
        return (static::STATUS_VALID === $this->status);
    }
}
