<?php

namespace Matks\PHPMakeUp\Line;

use Matks\PHPMakeUp\File\FileManagerInterface;
use Matks\PHPMakeUp\Line\VariableAssignmentLineBlock as Block;
use Matks\PHPMakeUp\Line\VariableAssignmentLine as Line;
use Exception;

/**
 * Line Alignment manager
 */
class LineAligner implements LineAlignerInterface
{
    /**
     * Variable assignment code line regex
     */
    const VARIABLE_ASSIGNMENT_REGEX = '([^=]*)=(.*)$';

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
     * Search and align variable assignments code lines in a file
     *
     * @param string $filepath
     *
     * @throws Exception
     */
    public function align($filepath)
    {
        if (!file_exists($filepath)) {
            throw new Exception("File $filepath does not exist");
        }

        $blocks      = $this->findBlocks($filepath);
        $validBlocks = $this->getValidBlocks($blocks);

        $fileLines = $this->createCleanedFile($filepath, $validBlocks);

        $newFilepath = $filepath . '.copy';
        $this->fileManager->writeFile($newFilepath, $fileLines);
        $this->fileManager->replaceFile($filepath, $newFilepath);
    }

    /**
     * Find in given eligible VariableAssignmentLineBlocks
     *
     * @param string $filepath
     *
     * @return array
     */
    private function findBlocks($filepath)
    {
        $lines = file($filepath);

        $count        = 0;
        $currentBlock = null;
        $blocks       = array();

        foreach ($lines as $lineNumber => $line) {

            $matches = array();
            $result  = preg_match('#' . static::VARIABLE_ASSIGNMENT_REGEX . '#', $line, $matches);

            if (0 === $result) {
                $currentBlock = null;
                $count++;
                continue;
            }

            $partBefore = $matches[1];
            $partAfter  = $matches[2];

            if (null == $currentBlock) {
                $currentBlock = new Block();
                $blocks[]     = $currentBlock;
            }

            $eligibleLine = new Line($count, $partBefore, $partAfter);
            $currentBlock->addLine($eligibleLine);

            $count++;
        }

        return $blocks;
    }

    /**
     * Clean file lines according to found VariableAssignmentLineBlocks
     *
     * @param string $filepath
     * @param array  $blocks
     */
    private function createCleanedFile($filepath, array $blocks)
    {
        $fileLines = file($filepath);

        foreach ($blocks as $block) {
            $alignmentLength = $block->getAlignment();

            foreach ($block->getLines() as $line) {
                $lineNumber = $line->getLineNumber();
                $partBefore = $line->getPartBefore();
                $partAfter  = $line->getPartAfter();

                $missingSpaceLength = $alignmentLength - strlen($partBefore);
                $alignmentSpace     = $this->buildAlignmentSpace($missingSpaceLength);

                $fileLines[$lineNumber] = $partBefore . $alignmentSpace . '=' . $partAfter . PHP_EOL;
            }
        }

        return $fileLines;
    }

    /**
     * Build alignment space
     *
     * @param integer $length
     *
     * @return string
     */
    private function buildAlignmentSpace($length)
    {
        $space = '';
        for ($i = 0; $i < $length; $i++) {
            $space .= ' ';
        }

        return $space;
    }

    /**
     * Filter valid blocks from given array of VariableAssignmentLineBlock
     *
     * @param array $blocks array of VariableAssignmentLineBlock
     *
     * @return array of valid VariableAssignmentLineBlock
     */
    private function getValidBlocks(array $blocks)
    {
        $result = array();

        foreach ($blocks as $block) {
            if ($block->isValid()) {
                $result[] = $block;
            }
        }

        return $result;
    }
}
