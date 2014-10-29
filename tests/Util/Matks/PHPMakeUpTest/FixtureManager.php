<?php

namespace Matks\PHPMakeUpTest;

trait FixtureManager
{
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
