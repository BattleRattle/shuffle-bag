<?php

namespace BattleRattle\Tests\ShuffleBag;

use BattleRattle\Tests\ShuffleBag\Helper\ArrayStorage;
use BattleRattle\ShuffleBag\PersistentShuffleBag;
use BattleRattle\Tests\ShuffleBag\Helper\FixedNumberGenerator;

class PersistentShuffleBagTest extends AbstractShuffleBagTest
{
    /**
     * @var ArrayStorage
     */
    private $storage;

    public function setUp()
    {
        $this->storage = new ArrayStorage();
        $this->bag = new PersistentShuffleBag($this->storage, new FixedNumberGenerator(0.0));
    }

    public function testCurrentPosition()
    {
        $this->bag->add('foo', 3);
        $this->assertSame(2, $this->storage->getCurrentPosition(), 'Position must be updated to last position after adding items');

        $this->bag->next();
        $this->assertSame(1, $this->storage->getCurrentPosition(), 'Position must be reduced by 1 each time an item gets fetched');

        $this->bag->next();
        $this->bag->next();
        $this->assertSame(2, $this->storage->getCurrentPosition(), 'Position must be reset the max offset, after the bag gets empty');
    }
}
