<?php

namespace Matks\PHPMakeUp\Line;

use Matks\PHPMakeUp\Line\VariableAssignmentLineBlock as Block;
use Matks\PHPMakeUp\Line\VariableAssignmentLine as Line;
use Exception;

class LineAligner
{
    const VARIABLE_ASSIGNMENT_REGEX = '([^=]*)=(.*)$';

    public function align($filepath)
    {
        if (!file_exists($filepath)) {
            throw new Exception("File $filepath does not exist");
        }

        $blocks = $this->findBlocks($filepath);
        $validBlocks = $this->getValidBlocks($blocks);

        $this->createCleanedFile($filepath, $validBlocks);
    }

    private function findBlocks($filepath)
    {
        $lines = file($filepath);

        $count = 0;
        $currentBlock = null;
        $blocks = array();

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
                $blocks[] = $currentBlock;
            }

            $eligibleLine = new Line($count, $partBefore, $partAfter);
            $currentBlock->addLine($eligibleLine);

            $count++;
        }

        return $blocks;
    }

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
                $alignmentSpace = $this->buildAlignmentSpace($missingSpaceLength);

                $fileLines[$lineNumber] = $partBefore . $alignmentSpace . '=' . $partAfter . PHP_EOL;
            }
        }

        $newFilepath = $filepath . '.copy';
        $this->writeFile($newFilepath, $fileLines);

        $this->replaceFiles($filepath, $newFilepath);
    }

    private function buildAlignmentSpace($length)
    {
        $space = '';
        for ($i = 0; $i < $length; $i++) {
            $space .= ' ';
        }

        return $space;
    }

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

    private function writeFile($filepath, array $lines)
    {
        if (file_exists($filepath)) {
            throw new Exception("File $filepath does exist");
        }

        $file = fopen($filepath, 'w');
        foreach ($lines as $line) {
            fwrite($file, $line);
        }
        fclose($file);
    }

    private function replaceFiles($oldFilepath, $newFilepath)
    {
        if (!file_exists($oldFilepath)) {
            throw new Exception("File $oldFilepath does not exist");
        }
        if (!file_exists($newFilepath)) {
            throw new Exception("File $newFilepath does not exist");
        }

        unlink($oldFilepath);
        rename($newFilepath, $oldFilepath);
    }
}
