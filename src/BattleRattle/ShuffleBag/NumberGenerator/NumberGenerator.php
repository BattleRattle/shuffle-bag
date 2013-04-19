<?php

namespace BattleRattle\ShuffleBag\NumberGenerator;

interface NumberGenerator
{
    /**
     * Get the next generated number between 0 and 1 (inclusively).
     *
     * @return float
     */
    public function next();
}