<?php

namespace BattleRattle\ShuffleBag\Storage;

abstract class AbstractStorage implements Storage
{
    protected $currentPosition = Storage::EMPTY_BAG_STORAGE;

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