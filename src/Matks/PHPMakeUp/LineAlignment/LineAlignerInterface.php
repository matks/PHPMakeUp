<?php

namespace Matks\PHPMakeUp\LineAlignment;

interface LineAlignerInterface
{
    /**
     * @param string $filepath
     */
    public function align($filepath);
}
