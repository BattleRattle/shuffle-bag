<?php

namespace BattleRattle\ShuffleBag;

use BattleRattle\ShuffleBag\NumberGenerator\NumberGenerator;
use BattleRattle\ShuffleBag\NumberGenerator\RandomNumberGenerator;

class ArrayShuffleBag implements ShuffleBag
{
    /**
     * @var \SplFixedArray
     */
    private $items;

    /**
     * @var integer
     */
    private $currentPosition = -1;

    /**
     * @var NumberGenerator
     */
    private $generator;

    /**
     * Constructor.
     */
    public function __construct(NumberGenerator $generator = null)
    {
        $this->items = new \SplFixedArray();
        $this->generator = $generator ?: new RandomNumberGenerator();
    }

    /**
     * {@inheritdoc}
     */
    public function add($item, $amount = 1)
    {
        if ($amount < 1) {
            throw new \InvalidArgumentException('The amount must be a positive number');
        }

        $size = $this->items->getSize();
        $this->items->setSize($size + $amount);

        for ($i = 0; $i < $amount; $i++) {
            $this->items[$size + $i] = $item;
        }

        $this->currentPosition = $size + $amount - 1;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        if ($this->currentPosition == -1) {
            throw new \LogicException('Cannot fetch an item from empty bag.');
        }

        if ($this->currentPosition == 0) {
            $this->currentPosition = $this->items->getSize() - 1;

            return $this->items[0];
        }

        $maxOffset = $this->currentPosition;
        $randomOffset = (int) ($this->generator->next() * $maxOffset);
        $item = $this->items[$randomOffset];

        if ($randomOffset < $maxOffset) {
            $this->items[$randomOffset] = $this->items[$this->currentPosition];
            $this->items[$this->currentPosition] = $item;
        }
        $this->currentPosition--;

        return $item;
    }
}