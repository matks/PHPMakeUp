<?php

namespace Matks\PHPMakeUp\tests\Units\UseSorting;

use Matks\PHPMakeUp\UseSorting;

use Mock;
use \atoum;

class UseStatementBlock extends atoum
{
    public function testConstruct()
    {
        $block = new UseSorting\UseStatementBlock();

        $this
            ->array($block->getLineNumbers())
            ->isEmpty()
            ->array($block->getStatements())
            ->isEmpty()
            ->array($block->getSortedLineNumbers())
            ->isEmpty()
            ->array($block->getSortedStatements())
            ->isEmpty()
            ->integer($block->count())
            ->isEqualTo(0);
    }

    public function testAddOneStatement()
    {
        $block = new UseSorting\UseStatementBlock();

        $block->addStatement(5, 'use Matks\Lol;');

        $this
            ->array($block->getLineNumbers())
            ->isEqualTo(array(5))
            ->array($block->getStatements())
            ->isEqualTo(array(5 => 'use Matks\Lol;'))
            ->integer($block->count())
            ->isEqualTo(1);
    }

    public function testAddMultipleStatements()
    {
        $block = new UseSorting\UseStatementBlock();

        $block->addStatement(6, 'use Matks\A;');
        $block->addStatement(5, 'use Matks\Lol;');
        $block->addStatement(8, 'use Matks\B as Blob;');

        $this
            ->array($block->getLineNumbers())
            ->isEqualTo(array(6, 5, 8))
            ->array($block->getStatements())
            ->isEqualTo(array(6 => 'use Matks\A;', 5 => 'use Matks\Lol;', 8 => 'use Matks\B as Blob;'))
            ->integer($block->count())
            ->isEqualTo(3);

        $this
            ->array($block->getSortedLineNumbers())
            ->isEqualTo(array(5, 6, 8))
            ->array($block->getSortedStatements())
            ->isEqualTo(array(0 => 'use Matks\A;', 1 => 'use Matks\B as Blob;', 2 => 'use Matks\Lol;'));
    }
}
