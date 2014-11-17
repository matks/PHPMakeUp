<?php

namespace Matks\PHPMakeUp;

use Matks\PHPMakeUp\Line\LineAlignerInterface;

class PHPCleaner
{

    /**
     * Lines Aligner tool
     *
     * @var LineAligner
     */
    private $lineAligner;

    public function __construct(LineAlignerInterface $lineAligner)
    {
        $this->lineAligner = $lineAligner;
    }

    public function clean($filepath)
    {
        $this->lineAligner->align($filepath);
    }
}
