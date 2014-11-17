<?php

namespace Matks\PHPMakeUp;

use Matks\PHPMakeUp\LineAlignment\LineAlignerInterface;

/**
 * PHPCleaner
 */
class PHPCleaner
{

    /**
     * Lines Aligner tool
     *
     * @var LineAligner
     */
    private $lineAligner;

    /**
     * @param LineAlignerInterface $lineAligner
     */
    public function __construct(LineAlignerInterface $lineAligner)
    {
        $this->lineAligner = $lineAligner;
    }

    /**
     * @param string $filepath
     */
    public function clean($filepath)
    {
        $this->lineAligner->align($filepath);
    }
}
