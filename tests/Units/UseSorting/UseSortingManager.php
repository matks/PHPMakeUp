<?php

namespace Matks\PHPMakeUp\tests\Units\UseSorting;

use Matks\PHPMakeUp\UseSorting;

use Mock;
use \atoum;

class UseSortingManager extends atoum
{
    use \Matks\PHPMakeUpTest\FixtureManager;

    public function testConstruct()
    {
        $fileManagerMock = new Mock\Matks\PHPMakeUp\File\FileManagerInterface();
        $manager         = new UseSorting\UseSortingManager($fileManagerMock);

        $this
            ->class(get_class($manager))
            ->hasInterface('\Matks\PHPMakeUp\UseSorting\UseSortingManagerInterface');
    }

    public function testSort()
    {
        $fileManagerMock  = new Mock\Matks\PHPMakeUp\File\FileManagerInterface();
        $testFilename     = 'aClass.php';
        $expectedFilename = 'aClass.php.sorted';
        $copyFilename     = 'aClass.php.copy';

        $manager = new UseSorting\UseSortingManager($fileManagerMock);

        $testFilepath = $this->getTestDirectory() . $testFilename;
        $copyFilepath = $this->getTestDirectory() . $copyFilename;
        $manager->sort($testFilepath);

        $expectedFilepath = $this->getExpectedFilesDirectory() . $expectedFilename;
        $expectedContent  = file($expectedFilepath);

        $this
            ->mock($fileManagerMock)
            ->call('writeFile')
            ->withIdenticalArguments($copyFilepath, $expectedContent)
            ->once();
    }
}
