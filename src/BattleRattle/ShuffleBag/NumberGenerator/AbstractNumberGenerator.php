<?php

namespace BattleRattle\ShuffleBag\NumberGenerator;

abstract class AbstractNumberGenerator implements NumberGenerator
{
    /**
     * {@inheritdoc}
     */
    abstract public function next();
}