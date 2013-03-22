<?php

namespace BattleRattle\ShuffleBag\NumberGenerator;

class RandomNumberGenerator extends AbstractNumberGenerator
{
    public function next()
    {
        return mt_rand() / mt_getrandmax();
    }
}
