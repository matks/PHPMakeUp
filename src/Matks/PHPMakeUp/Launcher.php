<?php

namespace Matks\PHPMakeUp;

use Matks\PHPMakeUp\File\FileManager;
use Matks\PHPMakeUp\Line\LineAligner;

/**
 * PHPMakeUp Launcher
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
        $launcher->run((string) $filepath);
    }

    /**
     * Run
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
        $fileManager = new FileManager();
        $lineAligner = new LineAligner($fileManager);

        $phpCleaner = new phpCleaner($lineAligner);

        return $phpCleaner;
    }
}
