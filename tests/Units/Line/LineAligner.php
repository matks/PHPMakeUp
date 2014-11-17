<?php

namespace Matks\PHPMakeUp\tests\Units\Line;

use Matks\PHPMakeUp\Line;

use \atoum;
use Mock;

class LineAligner extends atoum
{
    use \Matks\PHPMakeUpTest\FixtureManager;

    public function testConstruct()
    {
        $fileManagerMock = new Mock\Matks\PHPMakeUp\File\FileManagerInterface();
        $aligner         = new Line\LineAligner($fileManagerMock);

        $this
            ->class(get_class($aligner))
            ->hasInterface('\Matks\PHPMakeUp\Line\LineAlignerInterface');
    }

    public function testAlign()
    {
        $fileManagerMock = new Mock\Matks\PHPMakeUp\File\FileManagerInterface();
        $testFilename    = 'aClass.php';
        $copyFilename    = 'aClass.php.copy';

        $aligner = new Line\LineAligner($fileManagerMock);

        $testFilepath = $this->getTestDirectory() . $testFilename;
        $copyFilepath = $this->getTestDirectory() . $copyFilename;
        $aligner->align($testFilepath);

        $expectedFilepath = $this->getExpectedFilesDirectory() . $testFilename;
        $expectedContent  = file($expectedFilepath);

        $this
            ->mock($fileManagerMock)
            ->call('writeFile')
            ->withIdenticalArguments($copyFilepath, $expectedContent)
            ->once();
    }
}
