<?php

namespace Matks\PHPMakeUp\File;

interface FileManagerInterface
{
    /**
     * @param string $filepath
     * @param array  $lines
     */
    public function writeFile($filepath, array $lines);

    /**
     * @param string $oldFilepath
     * @param string $newFilepath
     */
    public function replaceFile($oldFilepath, $newFilepath);
}
