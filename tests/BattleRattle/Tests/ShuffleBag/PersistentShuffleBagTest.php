<?php

namespace BattleRattle\Tests\ShuffleBag;

use BattleRattle\ShuffleBag\Storage\ArrayStorage;
use BattleRattle\ShuffleBag\PersistentShuffleBag;
use BattleRattle\ShuffleBag\NumberGenerator\AbstractNumberGenerator;

class PersistentShuffleBagTest extends AbstractShuffleBagTest
{
    /**
     * @var ArrayStorage
     */
    private $storage;

    public function setUp()
    {
        // Create a faked number generator in order to make sure, the tests won't succeed or fail randomly
        $numberGeneratorMock = $this->getMockBuilder('BattleRattle\\ShuffleBag\\NumberGenerator\\AbstractNumberGenerator')
            ->setMethods(array('next'))
            ->getMockForAbstractClass();

        $numberGeneratorMock->expects($this->any())
            ->method('next')
            ->will($this->returnValue(0));

        /** @var $numberGeneratorMock AbstractNumberGenerator */

        $this->storage = new ArrayStorage();
        $this->bag = new PersistentShuffleBag($this->storage, $numberGeneratorMock);
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
