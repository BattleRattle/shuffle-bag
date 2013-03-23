<?php

namespace BattleRattle\ShuffleBag;

use BattleRattle\ShuffleBag\NumberGenerator\NumberGeneratorInterface;
use BattleRattle\ShuffleBag\NumberGenerator\RandomNumberGenerator;
use BattleRattle\ShuffleBag\Persistence\ArrayStorage;
use BattleRattle\ShuffleBag\Persistence\StorageInterface;

class ShuffleBag
{
    private $numberGenerator;
    private $storage;

    /**
     * Constructor.
     *
     * @param Persistence\StorageInterface $storage
     * @param NumberGenerator\NumberGeneratorInterface $numberGenerator
     * @internal param \BattleRattle\ShuffleBag\NumberGenerator\RandomNumberGenerator|null $random A random number generator.
     */
    public function __construct(StorageInterface $storage = null, NumberGeneratorInterface $numberGenerator = null)
    {
        $this->storage = $storage ?: new ArrayStorage();
        $this->numberGenerator = $numberGenerator ?: new RandomNumberGenerator();
    }

    /**
     * Add an item with certain amount.
     *
     * @param scalar $item The item to add.
     * @param integer $amount The amount to add.
     *
     * @throws \InvalidArgumentException
     * @return ShuffleBag
     */
    public function add($item, $amount)
    {
        if (!is_scalar($item)) {
            throw new \InvalidArgumentException('The item must be scalar');
        }

        if ($amount < 1) {
            throw new \InvalidArgumentException('The amount must be a positive number');
        }

        $items = array_fill(0, $amount, $item);
        $this->storage->appendItems($items);

        return $this;
    }

    /**
     * Get the next item from bag.
     *
     * return scalar
     */
    public function next()
    {
        $maxOffset = $this->storage->getCurrentPosition();

        if ($maxOffset == -1) {
            throw new \LogicException('Cannot fetch an item from empty bag.');
        }

        if ($maxOffset == 0) {
            $item = $this->storage->getItem(0);
            $size = $this->storage->getItemCount();
            $this->storage->setCurrentPosition($size - 1);

            return $item;
        }

        $multiplier = $this->numberGenerator->next();
        $offset = (int) ($multiplier * $maxOffset);
        $item = $this->storage->getItem($offset);

        if ($offset < $maxOffset) {
            $this->storage->swapItems($offset, $maxOffset);
        }

        $this->storage->setCurrentPosition($maxOffset - 1);

        return $item;
    }
}