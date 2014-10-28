<?php

namespace Matks\PHPMakeUp\tests\Units\Line;

use Matks\PHPMakeUp\Line;

use \atoum;

class LineAligner extends atoum
{
    use \Matks\PHPMakeUpTest\FixtureManager;

    public function testConstruct()
    {
        // just check class can be instantiated
        $aligner = new Line\LineAligner();
    }

    public function testAlign()
    {
        $testFilename = 'aClass.php';
        $this->setupFixture($testFilename);

        $aligner = new Line\LineAligner();

        $testFilepath = $this->getTestDirectory() . $testFilename;
        $aligner->align($testFilepath);

        $expectedFilepath = $this->getExpectedFilesDirectory() . $testFilename;

        $this
            ->string(file_get_contents($testFilepath))
                ->isEqualTo(file_get_contents($expectedFilepath))
        ;

        $this->clearFixture($testFilename);
    }
}
