<?php

namespace Matks\PHPMakeUp\tests\Units;

use Matks\PHPMakeUp;

use Mock;
use \atoum;

class PHPCleaner extends atoum
{
    public function testConstruct()
    {
        $aligner    = new Mock\Matks\PHPMakeUp\LineAlignment\LineAlignerInterface();
        $useManager = new Mock\Matks\PHPMakeUp\UseSorting\UseSortingManagerInterface();
        $cleaner    = new PHPMakeUp\PHPCleaner($aligner, $useManager);
    }

    public function testClean()
    {
        $aligner    = new Mock\Matks\PHPMakeUp\LineAlignment\LineAlignerInterface();
        $useManager = new Mock\Matks\PHPMakeUp\UseSorting\UseSortingManagerInterface();
        $cleaner    = new PHPMakeUp\PHPCleaner($aligner, $useManager);

        $path = './.././..';
        $cleaner->clean($path);

        $this
            ->mock($aligner)
            ->call('align')
            ->withIdenticalArguments($path)
            ->once()
            ->mock($useManager)
            ->call('sort')
            ->withIdenticalArguments($path)
            ->once();
    }
}
