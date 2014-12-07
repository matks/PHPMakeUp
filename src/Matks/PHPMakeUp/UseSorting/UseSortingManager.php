<?php

namespace Matks\PHPMakeUp\UseSorting;

use Exception;
use Matks\PHPMakeUp\File\FileManagerInterface;

/**
 * Use Sorting Manager
 */
class UseSortingManager implements UseSortingManagerInterface
{
    /**
     * Use statement regex
     */
    const USE_STATEMENT_REGEX = '^(use .*)$';

    /**
     * Constructor
     *
     * @param FileManagerInterface $fileManager
     */
    public function __construct(FileManagerInterface $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * Search and sort alphabetically use statements in a class file
     *
     * @param string $filepath
     *
     * @throws Exception
     */
    public function sort($filepath)
    {
        if (!file_exists($filepath)) {
            throw new Exception("File $filepath does not exist");
        }

        $statementBlock = $this->findUseStatements($filepath);

        $fileLines = $this->createCleanedFile($filepath, $statementBlock);

        $newFilepath = $filepath . '.copy';
        $this->fileManager->writeFile($newFilepath, $fileLines);
        $this->fileManager->replaceFile($filepath, $newFilepath);
    }

    /**
     * Find use statements
     *
     * @param string $filepath
     *
     * @return UseStatementBlock
     */
    private function findUseStatements($filepath)
    {
        $lines = file($filepath);

        $statementBlock = new UseStatementBlock();

        foreach ($lines as $lineNumber => $line) {

            $matches = array();
            $result  = preg_match('#' . static::USE_STATEMENT_REGEX . '#', $line, $matches);

            if (0 === $result) {
                continue;
            }

            $statementContent = $matches[1];
            $statementBlock->addStatement($lineNumber, $statementContent);
        }

        return $statementBlock;
    }

    /**
     * Sort use lines in new created file
     *
     * @param string            $filepath
     * @param UseStatementBlock $statementBlock
     */
    private function createCleanedFile($filepath, UseStatementBlock $statementBlock)
    {
        $fileLines        = file($filepath);
        $sortedStatements = $statementBlock->getSortedStatements();
        $lineNumbers      = $statementBlock->getSortedLineNumbers();

        $i = 0;
        foreach ($sortedStatements as $statement) {
            $lineNumber             = $lineNumbers[$i];
            $fileLines[$lineNumber] = $statement . PHP_EOL;

            $i++;
        }

        return $fileLines;
    }
}
