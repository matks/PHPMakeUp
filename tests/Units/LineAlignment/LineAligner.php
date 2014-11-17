<?php

namespace Matks\PHPMakeUp\tests\Units\LineAlignment;

use Matks\PHPMakeUp\LineAlignment;

use \atoum;
use Mock;

class LineAligner extends atoum
{
    use \Matks\PHPMakeUpTest\FixtureManager;

    public function testConstruct()
    {
        $fileManagerMock = new Mock\Matks\PHPMakeUp\File\FileManagerInterface();
        $aligner         = new LineAlignment\LineAligner($fileManagerMock);

        $this
            ->class(get_class($aligner))
            ->hasInterface('\Matks\PHPMakeUp\LineAlignment\LineAlignerInterface');
    }

    public function testAlign()
    {
        $fileManagerMock = new Mock\Matks\PHPMakeUp\File\FileManagerInterface();
        $testFilename    = 'aClass.php';
        $copyFilename    = 'aClass.php.copy';

        $aligner = new LineAlignment\LineAligner($fileManagerMock);

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
