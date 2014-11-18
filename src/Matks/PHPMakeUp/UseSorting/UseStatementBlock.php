<?php

namespace Matks\PHPMakeUp\UseSorting;

use Matks\PHPMakeUp\UseSorting\UseStatement;

class UseStatementBlock
{
    /**
     * @var UseStatement[]
     */
    private $statements = array();

    /**
     * @var int[]
     */
    private $lineNumbers = array();

    /**
     * @param int    $lineNumber
     * @param string $statementContent
     *
     * @return $this
     */
    public function addStatement($lineNumber, $statementContent)
    {
        $this->statements[$lineNumber] = $statementContent;
        $this->lineNumbers[]           = $lineNumber;

        return $this;
    }

    /**
     * @return UseStatement[]
     */
    public function getStatements()
    {
        return $this->statements;
    }

    public function getSortedStatements()
    {
        sort($this->statements, SORT_STRING);

        return $this->statements;
    }

    /**
     * @return int[]
     */
    public function getLineNumbers()
    {
        return $this->lineNumbers;
    }

    /**
     * @return int[]
     */
    public function getSortedLineNumbers()
    {
        sort($this->lineNumbers);

        return $this->lineNumbers;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->statements);
    }
}
