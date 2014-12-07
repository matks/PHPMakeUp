<?php

namespace Matks\PHPMakeUp\LineAlignment;

use Exception;
use Matks\PHPMakeUp\File\FileManagerInterface;
use Matks\PHPMakeUp\LineAlignment\VariableAssignmentLine as Line;
use Matks\PHPMakeUp\LineAlignment\VariableAssignmentLineBlock as Block;

/**
 * Line Alignment manager
 */
class LineAligner implements LineAlignerInterface
{
    /**
     * Variable assignment code line regex
     */
    const VARIABLE_ASSIGNMENT_REGEX_BEGIN = '^([^=\(]*)\s';
    const VARIABLE_ASSIGNMENT_REGEX_END   = '\s(.*)$';

    private $allAssignmentCharacters = array(
        '=',
        '=>',
        '\.=',
        '<=',
    );

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

            if (null !== $currentBlock) {
                $assignmentCharacters = array($currentBlock->getAssignmentCharacter());
                $pattern = $this->buildVariableAssignmentLinePattern($assignmentCharacters);

                $result  = preg_match($pattern, $line, $matches);
                $patternDoesNotMatch = (0 === $result);
                if ($patternDoesNotMatch) {
                    $currentBlock = null;
                }
            }

            $pattern = $this->buildVariableAssignmentLinePattern($this->allAssignmentCharacters);

            $result  = preg_match($pattern, $line, $matches);
            $patternDoesNotMatch = (0 === $result);
            if ($patternDoesNotMatch) {
                $currentBlock = null;
                $count++;
                continue;
            }

            $partBefore          = $matches[1];
            $assignmentCharacter = $matches[2];
            $partAfter           = $matches[3];

            if (null == $currentBlock) {
                $currentBlock = new Block($assignmentCharacter);
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
     *
     * @return array
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

                $missingSpaceLength  = $alignmentLength - strlen($partBefore);
                $alignmentSpace      = $this->buildAlignmentSpace($missingSpaceLength);
                $assignmentCharacter = $block->getAssignmentCharacter();

                $fileLines[$lineNumber] = $partBefore . $alignmentSpace . ' ' . $assignmentCharacter . ' ' . $partAfter . PHP_EOL;
            }
        }

        return $fileLines;
    }

    /**
     * @param array $assignmentCharacters
     *
     * @return string
     */
    private function buildVariableAssignmentLinePattern(array $assignmentCharacters)
    {
        if (empty($assignmentCharacters)) {
            throw new \RuntimeException('No assignment characters provided');
        }

        $charactersRegex = '(';
        $length = count($assignmentCharacters);

        for ($i = 0; $i < $length; $i++) {
            $character = $assignmentCharacters[$i];

            if (($length - 1) === $i) {
                $charactersRegex .= $character;
            } else {
                $charactersRegex .= $character . '|';
            }
        }

        $charactersRegex .= ')';

        $pattern = '#' . static::VARIABLE_ASSIGNMENT_REGEX_BEGIN . $charactersRegex . static::VARIABLE_ASSIGNMENT_REGEX_END . '#';

        return $pattern;
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
