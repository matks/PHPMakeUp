<?php

namespace Matks\Tests\Random;

use Matks\Tests\Random\Foo as Foo;
use Matks\Tests\Random\Abc;

class aClass
{
    const A_CONSTANT = 'a';

    /**
     * @param $anArgument
     */
    public function aFunction($anArgument)
    {
        $a = count($anArgument);

        $foo = $anArgument;
        $aNewVar = empty(array());
        $test = $this->aPrivateFunction();

        $example = 'Foo';
        if ($example == 1) {
            $b = 3;
            $cd = 6;
        }

        $anArray = array('a' => 'b');
        $example2 = 'This is a test file';
        $example3 = 'Again';
        $example10 = 'Again';
        $example11 = 'Again';

        $test = null;

        $foo = array();
        $fooAndFoo = array(array());
    }

    private function aPrivateFunction()
    {
        // do nothing
    }

    /**
     * Random description
     */
    protected function aProtectedFunction()
    {
        $aString = 'ahlala';
        $anotherString = 'hello';
        $aString .= ' yes and no';

        $test = 'foo';
        $a = array(
            1 => 'a',
            22 => 'b');
        $b = 7;
        $ab = 78;
    }
}
