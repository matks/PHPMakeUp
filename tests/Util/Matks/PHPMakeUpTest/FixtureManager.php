<?php

namespace Matks\PHPMakeUpTest;

use Exception;

trait FixtureManager
{
    public function setupFixture($testFilename)
    {
        $inputFilepath = $this->getInputFilesDirectory() . $testFilename;
        if (!file_exists($inputFilepath)) {
            throw new Exception("Test input file $inputFilepath does not exist");
        }

        $targetFilepath = $this->getTestDirectory() . $testFilename;
        if (file_exists($targetFilepath)) {
            throw new Exception("Test input file $targetFilepath already exist");
        }

        copy($inputFilepath, $targetFilepath);
    }

    public function clearFixture($testFilename)
    {
        $resultFilepath = $this->getTestDirectory() . $testFilename;

        if (file_exists($resultFilepath)) {
            unlink($resultFilepath);
        }
    }

    private function getTestDirectory()
    {
        return __DIR__ . '/../../../data/';
    }

    private function getExpectedFilesDirectory()
    {
        return __DIR__ . '/../../../data/expected/';
    }

    private function getInputFilesDirectory()
    {
        return __DIR__ . '/../../../data/input/';
    }
}
