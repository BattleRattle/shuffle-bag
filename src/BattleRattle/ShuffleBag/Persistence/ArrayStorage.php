<?php

namespace BattleRattle\ShuffleBag\Persistence;

class ArrayStorage extends AbstractStorage
{
    /**
     * @var \SplFixedArray
     */
    private $items;

    public function __construct()
    {
        $this->items = new \SplFixedArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getItemCount()
    {
        return $this->items->getSize();
    }

    /**
     * {@inheritdoc}
     */
    public function appendItems(array $items)
    {
        $size = $this->items->getSize();
        $amount = count($items);
        $this->items->setSize($size + $amount);

        for ($i = 0; $i < $amount; $i++) {
            $this->items[$size + $i] = $items[$i];
        }

        $this->setCurrentPosition($this->items->getSize() - 1);
    }

    /**
     * {@inheritdoc}
     */
    public function swapItems($firstIndex, $secondIndex)
    {
        $item = $this->items[$firstIndex];
        $this->items[$firstIndex] = $this->items[$secondIndex];
        $this->items[$secondIndex] = $item;

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function getItem($index)
    {
        if (!$this->items->offsetExists($index)) {
            throw new \OutOfBoundsException('The index ' . $index . ' is not set');
        }

        return $this->items[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentPosition($index)
    {
        $this->currentPosition = $index;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }
}