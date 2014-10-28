<?php

namespace Matks\PHPMakeUp;

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
        $phpCleaner = new phpCleaner();

        return $phpCleaner;
    }
}
