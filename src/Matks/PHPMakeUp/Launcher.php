<?php

namespace Matks\PHPMakeUp;

use Matks\PHPMakeUp\File\FileManager;
use Matks\PHPMakeUp\LineAlignment\LineAligner;
use Matks\PHPMakeUp\UseSorting\UseSortingManager;

/**
 * PHPMakeUp Launcher
 *
 * This class setups the PHPMakeUp tool
 */
class Launcher
{

    /**
     * Main
     *
     * @param string $filepath
     */
    public static function main($filepath)
    {
        $launcher = new Launcher();
        $launcher->run((string)$filepath);
    }

    /**
     * Run
     *
     * @param string $filepath
     */
    public function run($filepath)
    {
        $phpCleaner = $this->setup();
        $phpCleaner->clean($filepath);

        die(0);
    }

    /**
     * Construct PHPCleaner instance with its dependencies
     *
     * @return PHPCleaner
     */
    private function setup()
    {
        $fileManager       = new FileManager();
        $lineAligner       = new LineAligner($fileManager);
        $useSortingManager = new UseSortingManager($fileManager);

        $phpCleaner = new phpCleaner($lineAligner, $useSortingManager);

        return $phpCleaner;
    }
}
