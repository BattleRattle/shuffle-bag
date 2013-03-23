<?php

namespace BattleRattle\ShuffleBag\Persistence;

abstract class AbstractStorage implements StorageInterface
{
    protected $currentPosition = -1;

    /**
     * {@inheritdoc}
     */
    abstract public function appendItems(array $item);

    /**
     * {@inheritdoc}
     */
    abstract public function getItemCount();

    /**
     * {@inheritdoc}
     */
    abstract public function swapItems($firstIndex, $secondIndex);

    /**
     * {@inheritdoc}
     */
    abstract public function getItem($index);

    /**
     * {@inheritdoc}
     */
    abstract public function getCurrentPosition();

    /**
     * {@inheritdoc}
     */
    abstract public function setCurrentPosition($index);
}