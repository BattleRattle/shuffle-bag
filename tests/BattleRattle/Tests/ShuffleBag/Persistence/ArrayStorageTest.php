<?php

namespace BattleRattle\Tests\ShuffleBag\Persistence;

use BattleRattle\Tests\ShuffleBag\Helper\ArrayStorage;

class ArrayStorageTest extends AbstractStorageTest
{
    public function setUp()
    {
        $this->storage = new ArrayStorage();
    }
}
