<?php

namespace BattleRattle\ShuffleBag;

use BattleRattle\ShuffleBag\NumberGenerator\NumberGeneratorInterface;
use BattleRattle\ShuffleBag\NumberGenerator\RandomNumberGenerator;

class ShuffleBag
{
    private $numberGenerator;
    private $items;
    private $currentPosition = -1;

    /**
     * Constructor.
     *
     * @param NumberGenerator\NumberGeneratorInterface $numberGenerator
     * @internal param \BattleRattle\ShuffleBag\NumberGenerator\RandomNumberGenerator|null $random A random number generator.
     */
    public function __construct(NumberGeneratorInterface $numberGenerator = null)
    {
        $this->items = new \SplFixedArray();
        $this->numberGenerator = $numberGenerator ?: new RandomNumberGenerator();
    }

    /**
     * Add an item with certain amount.
     *
     * @param mixed $item The item to add.
     * @param integer $amount The amount to add.
     *
     * @throws \InvalidArgumentException
     * @return ShuffleBag
     */
    public function add($item, $amount)
    {
        if ($amount < 1) {
            throw new \InvalidArgumentException('The amount must be a positive number');
        }

        $bagSize = $this->items->getSize();
        $this->resize($bagSize + $amount);

        for ($i = 0; $i < $amount; $i++) {
            $this->items[$bagSize + $i] = $item;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        if ($this->items->getSize() < 1) {
            throw new \LogicException('At least one item must be added before requesting a random item');
        }

        if ($this->currentPosition < 1) {
            $this->currentPosition = $this->items->getSize() - 1;

            return $this->items[0];
        }

        $randomOffset = (int) ($this->numberGenerator->next() * $this->currentPosition);

        return $this->pickItem($randomOffset);
    }

    /**
     * Resize the bag.
     *
     * @param integer $newSize The new bag size.
     */
    private function resize($newSize)
    {
        $this->items->setSize($newSize);
        $this->currentPosition = $newSize - 1;
    }

    /**
     * Pick an item.
     *
     * @param integer $index The item index to use.
     * @return mixed
     */
    private function pickItem($index)
    {
        $item = $this->items[$index];
        $this->items[$index] = $this->items[$this->currentPosition];
        $this->items[$this->currentPosition] = $item;

        $this->currentPosition--;

        return $item;
    }
}