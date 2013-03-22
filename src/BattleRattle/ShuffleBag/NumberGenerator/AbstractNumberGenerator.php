<?php

namespace BattleRattle\ShuffleBag\NumberGenerator;

abstract class AbstractNumberGenerator implements NumberGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function next();
}