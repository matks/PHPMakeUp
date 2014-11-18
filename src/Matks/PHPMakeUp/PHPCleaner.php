<?php

namespace Matks\PHPMakeUp;

use Matks\PHPMakeUp\LineAlignment\LineAlignerInterface;
use Matks\PHPMakeUp\UseSorting\UseSortingManager;
use Matks\PHPMakeUp\UseSorting\UseSortingManagerInterface;

/**
 * PHPCleaner
 */
class PHPCleaner
{

    /**
     * Lines Aligner tool
     *
     * @var LineAlignerInterface
     */
    private $lineAligner;

    /**
     * Use sorting tool
     *
     * @var UseSortingManagerInterface
     */
    private $useSortingManager;

    /**
     * @param LineAlignerInterface $lineAligner
     */
    public function __construct(LineAlignerInterface $lineAligner, UseSortingManagerInterface $useSortingManager)
    {
        $this->lineAligner       = $lineAligner;
        $this->useSortingManager = $useSortingManager;
    }

    /**
     * @param string $filepath
     */
    public function clean($filepath)
    {
        $this->lineAligner->align($filepath);
        $this->useSortingManager->sort($filepath);
    }
}
