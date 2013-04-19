<?php

namespace BattleRattle\ShuffleBag;

interface ShuffleBag
{
    /**
     * Add an item with certain amount.
     *
     * @param mixed $item The item to add.
     * @param integer $amount The amount to add.
     *
     * @throws \InvalidArgumentException
     * @return ShuffleBag
     */
    public function add($item, $amount = 1);

    /**
     * Get the next element from bag.
     * @return mixed
     */
    public function next();
}