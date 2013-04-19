<?php

namespace BattleRattle\Tests\ShuffleBag\Persistence;

use BattleRattle\ShuffleBag\Storage\ArrayStorage;
use BattleRattle\ShuffleBag\Storage\Storage;

abstract class AbstractStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayStorage
     */
    protected $storage;

    public function testInitialState()
    {
        $this->assertSame(0, $this->storage->getItemCount(), 'Item count must be 0 on empty bag');
        $this->assertSame(Storage::EMPTY_BAG_STORAGE, $this->storage->getCurrentPosition(), 'Initial position must be special value');
    }

    public function testItemCount()
    {
        $this->assertSame(0, $this->storage->getItemCount(), 'Item Count must be 0 on empty bag');

        $this->storage->appendItems(array_fill(0, 3, 'foo'));
        $this->assertSame(3, $this->storage->getItemCount(), 'Item Count must be 3 after adding 3 items');
    }

    public function testSwapItems()
    {
        $this->storage->appendItems(array('foo', 'bar'));
        $this->assertSame('foo', $this->storage->getItem(0), 'First item must be "foo"');
        $this->assertSame('bar', $this->storage->getItem(1), 'Second item must be "bar"');

        $this->storage->swapItems(0, 1);
        $this->assertSame('bar', $this->storage->getItem(0), 'First item must be "bar"');
        $this->assertSame('foo', $this->storage->getItem(1), 'Second item must be "foo"');
    }

    public function testPositioning()
    {
        $this->storage->setCurrentPosition(1337);
        $this->assertSame(1337, $this->storage->getCurrentPosition(), 'Position must be the same, that was set before');
    }
}
