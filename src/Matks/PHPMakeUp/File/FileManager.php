<?php

namespace Matks\PHPMakeUp\File;

use Exception;

/**
 * File Manager
 */
class FileManager implements FileManagerInterface
{
    /**
     * @param string $filepath
	 * @param  array  $lines
	 */
    public function writeFile($filepath, array $lines)
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

    /**
     * @param string $oldFilepath
     * @param string $newFilepath
     */
    public function replaceFile($oldFilepath, $newFilepath)
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
