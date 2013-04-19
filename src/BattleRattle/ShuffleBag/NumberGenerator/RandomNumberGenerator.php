<?php

namespace BattleRattle\ShuffleBag\NumberGenerator;

class RandomNumberGenerator extends AbstractNumberGenerator
{
    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return lcg_value();
    }
}
