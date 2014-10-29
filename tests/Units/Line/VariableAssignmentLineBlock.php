<?php

namespace Matks\PHPMakeUp\tests\Units\Line;

use Matks\PHPMakeUp\Line;

use \atoum;
use Mock;

class VariableAssignmentLineBlock extends atoum
{
    public function testConstruct()
    {
        $block = new Line\VariableAssignmentLineBlock();

        $this
            ->array($block->getLines())
                ->isEmpty()
            ->boolean($block->isValid())
                ->isFalse()
            ->integer($block->getAlignment())
                ->isEqualTo(0)
            ->integer($block->count())
                ->isEqualTo(0)
        ;

        $this
            ->exception(
                function () use ($block) {
                    $block->getFirstLine();
                }
            )
                ->hasMessage('Cannot get first line, no lines in this block')
        ;
    }

    public function testAddOneLine()
    {
        $lineMock1 = new Mock\Matks\PHPMakeUp\Line\VariableAssignmentLine(5, '2 ', 'foo');

        $block = new Line\VariableAssignmentLineBlock();

        $block->addLine($lineMock1);

        $this
            ->array($block->getLines())
                ->isEqualTo(array($lineMock1))
            ->boolean($block->isValid())
                ->isFalse()
            ->integer($block->getAlignment())
                ->isEqualTo(2)
            ->integer($block->count())
                ->isEqualTo(1)
            ->object($block->getFirstLine())
                ->isIdenticalTo($lineMock1)
        ;
    }

    public function testAddMultipleLines()
    {
        $lineMock1 = new Mock\Matks\PHPMakeUp\Line\VariableAssignmentLine(5, '2 ', ' foo');
        $lineMock2 = new Mock\Matks\PHPMakeUp\Line\VariableAssignmentLine(6, 'aaaa ', 'b');
        $lineMock3 = new Mock\Matks\PHPMakeUp\Line\VariableAssignmentLine(7, 'j  ', ' b');

        $block = new Line\VariableAssignmentLineBlock();

        $block->addLine($lineMock1);
        $block->addLine($lineMock2);
        $block->addLine($lineMock3);

        $this
            ->array($block->getLines())
                ->isEqualTo(array($lineMock1, $lineMock2, $lineMock3))
            ->boolean($block->isValid())
                ->isTrue()
            ->integer($block->getAlignment())
                ->isEqualTo(5)
            ->integer($block->count())
                ->isEqualTo(3)
            ->object($block->getFirstLine())
                ->isIdenticalTo($lineMock1)
        ;
    }
}
