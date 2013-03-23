<?php

namespace BattleRattle\ShuffleBag\Persistence;

interface StorageInterface
{
    /**
     * Append one or more items to the bag.
     *
     * @param array $items The items to add.
     *
     * @return void
     */
    public function appendItems(array $items);

    /**
     * Get the amount of items in bag.
     *
     * @return integer
     */
    public function getItemCount();

    /**
     * Swap two elements in bag.
     *
     * @param integer $firstIndex Index of the first element.
     * @param integer $secondIndex Index of the second element.
     *
     * @return void
     */
    public function swapItems($firstIndex, $secondIndex);

    /**
     * Get an item by its index.
     *
     * @param integer $index The item index.
     *
     * @return mixed
     */
    public function getItem($index);

    /**
     * Get the current position.
     *
     * @return integer
     */
    public function getCurrentPosition();

    /**
     * Set the current position.
     *
     * @param integer $index The new index position.
     *
     * @return void
     */
    public function setCurrentPosition($index);
}