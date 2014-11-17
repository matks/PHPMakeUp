<?php

namespace Matks\PHPMakeUp\tests\Units\LineAlignment;

use Matks\PHPMakeUp\LineAlignment;

use \atoum;

class VariableAssignmentLine extends atoum
{
    public function testConstruct()
    {
        $line = new LineAlignment\VariableAssignmentLine(2, 'a', 'b');

        $this
            ->integer($line->getLineNumber())
            ->isEqualTo(2)
            ->string($line->getPartBefore())
            ->isEqualTo('a')
            ->string($line->getPartAfter())
            ->isEqualTo('b');
    }
}
