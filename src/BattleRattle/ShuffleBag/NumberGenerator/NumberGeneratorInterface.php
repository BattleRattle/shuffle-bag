<?php

namespace BattleRattle\ShuffleBag\NumberGenerator;

interface NumberGeneratorInterface
{
    /**
     * Get the next generated number between 0 and 1.
     *
     * @return float
     */
    public function next();
}