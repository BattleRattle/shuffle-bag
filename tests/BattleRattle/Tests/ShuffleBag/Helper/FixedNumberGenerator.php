<?php

namespace BattleRattle\Tests\ShuffleBag\Helper;

use BattleRattle\ShuffleBag\NumberGenerator\NumberGenerator;

class FixedNumberGenerator implements NumberGenerator
{
    /**
     * @var float
     */
    private $fixed;

    /**
     * Constructor.
     *
     * @param float $fixed The fixed number, that should be returned at next().
     */
    public function __construct($fixed)
    {
        $this->fixed = max(min((float) $fixed, 1), 0);
    }

    /**
     * Get the next generated number between 0 and 1 (inclusively).
     *
     * @return float
     */
    public function next()
    {
        return $this->fixed;
    }
}