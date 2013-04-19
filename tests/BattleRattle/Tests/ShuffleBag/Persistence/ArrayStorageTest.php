<?php

namespace BattleRattle\Tests\ShuffleBag\Persistence;

use BattleRattle\ShuffleBag\Storage\ArrayStorage;

class ArrayStorageTest extends AbstractStorageTest
{
    public function setUp()
    {
        $this->storage = new ArrayStorage();
    }
}
