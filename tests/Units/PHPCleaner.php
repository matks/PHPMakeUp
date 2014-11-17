<?php

namespace Matks\PHPMakeUp\tests\Units;

use Matks\PHPMakeUp;

use \atoum;
use Mock;

class PHPCleaner extends atoum
{
    public function testConstruct()
    {
        $aligner = new Mock\Matks\PHPMakeUp\Line\LineAlignerInterface();
        $cleaner = new PHPMakeUp\PHPCleaner($aligner);
    }

    public function testClean()
    {
        $aligner = new Mock\Matks\PHPMakeUp\Line\LineAlignerInterface();
        $cleaner = new PHPMakeUp\PHPCleaner($aligner);

        $path = './.././..';
        $cleaner->clean($path);

        $this
            ->mock($aligner)
            ->call('align')
            ->withIdenticalArguments($path)
            ->once();
    }
}
