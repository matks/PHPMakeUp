<?php

namespace Matks\PHPMakeUp\tests\Units\Line;

use Matks\PHPMakeUp\Line;

use \atoum;

class VariableAssignmentLine extends atoum
{
    public function testConstruct()
    {
        $line = new Line\VariableAssignmentLine(2, 'a', 'b');

        $this
            ->integer($line->getLineNumber())
                ->isEqualTo(2)
            ->string($line->getPartBefore())
                ->isEqualTo('a')
            ->string($line->getPartAfter())
                ->isEqualTo('b')
        ;
    }
}
