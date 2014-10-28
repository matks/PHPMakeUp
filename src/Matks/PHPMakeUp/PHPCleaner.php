<?php

namespace Matks\PHPMakeUp;

use Matks\PHPMakeUp\Line\LineAligner;

class PHPCleaner
{

    /**
     * Lines Aligner tool
     * @var LineAligner
     */
    private $lineAligner;

    public function __construct(LineAligner $lineAligner)
    {
        $this->lineAligner = $lineAligner;
    }

    public function clean($filepath)
    {
        $this->lineAligner->align($filepath);
    }
}
