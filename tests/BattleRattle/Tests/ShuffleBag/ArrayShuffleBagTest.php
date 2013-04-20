<?php

namespace BattleRattle\Tests\ShuffleBag;

use BattleRattle\ShuffleBag\ArrayShuffleBag;
use BattleRattle\Tests\ShuffleBag\Helper\FixedNumberGenerator;

class ArrayShuffleBagTest extends AbstractShuffleBagTest
{
    public function setUp()
    {
        $this->bag = new ArrayShuffleBag(new FixedNumberGenerator(0.0));
    }
}
