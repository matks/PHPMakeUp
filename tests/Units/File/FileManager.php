<?php

namespace Matks\PHPMakeUp\tests\Units\File;

use Matks\PHPMakeUp\File;

use \atoum;

class FileManager extends atoum
{
    use \Matks\PHPMakeUpTest\FixtureManager;

    public function testConstruct()
    {
        $manager = new File\FileManager();

        $this
            ->class(get_class($manager))
            ->hasInterface('\Matks\PHPMakeUp\File\FileManagerInterface');
    }

    public function testWriteFile()
    {
        $lines        = array(
            'line 1' . PHP_EOL,
            'line 2' . PHP_EOL,
            'last line' . PHP_EOL,
        );
        $testFilepath = $this->getTestDirectory() . '/newFile.txt';

        $manager = new File\FileManager();
        $manager->writeFile($testFilepath, $lines);

        $expectedFileContent = $lines[0] . $lines[1] . $lines[2];

        $this
            ->boolean(file_exists($testFilepath))
            ->isTrue()
            ->string(file_get_contents($testFilepath))
            ->isEqualTo($expectedFileContent);

        $this->clearFixture('newFile.txt');
    }

    public function testReplaceFile()
    {
        $testFilepath = $this->getTestDirectory() . '/file-to-replace.txt';
        file_put_contents($testFilepath, 'aaaaaa');

        $newFilepath = $this->getTestDirectory() . '/newFile.xml';
        file_put_contents($newFilepath, '<a>foo</a>');

        $manager = new File\FileManager();
        $manager->replaceFile($testFilepath, $newFilepath);

        $this
            ->boolean(file_exists($testFilepath))
            ->isTrue()
            ->boolean(file_exists($newFilepath))
            ->isFalse()
            ->string(file_get_contents($testFilepath))
            ->isEqualTo('<a>foo</a>');

        $this->clearFixture('file-to-replace.txt');
    }
}
