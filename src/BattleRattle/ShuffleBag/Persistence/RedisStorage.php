<?php

namespace BattleRattle\ShuffleBag\Persistence;

use Predis\Client;

class RedisStorage extends AbstractStorage
{
    /**
     * @var \Predis\Client
     */
    private $redis;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var integer|null
     */
    private $itemCount;

    /**
     * @var integer|null
     */
    protected $currentPosition;

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @var array
     */
    private $items = array();

    /**
     * Constructor.
     *
     * @param Client $redis Redis client.
     * @param string $key The key for bag identification.
     */
    public function __construct(Client $redis, $key)
    {
        $this->redis = $redis;
        $this->key = $key;
    }

    private function initializeRedis()
    {
        if ($this->initialized) {
            return;
        }

        $this->hash = substr(sha1(serialize($this->items)), 0, 8);

        $positionKey = $this->getKeyForCurrentPosition();
        $existing = !$this->redis->setnx($positionKey, count($this->items) - 1);

        if (!$existing) {
            $listKey = $this->getKeyForItemList();
            $this->itemCount = $this->redis->lpush($listKey, $this->items);
        }

        $this->initialized = true;
    }

    /**
     * {@inheritdoc}
     */
    public function appendItems(array $items)
    {
        $this->initialized = false;
        $this->items = array_merge($this->items, $items);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemCount()
    {
        $this->initializeRedis();

        if ($this->itemCount === null) {
            $key = $this->getKeyForItemList();
            $this->itemCount = $this->redis->llen($key);
        }

        return $this->itemCount;
    }

    /**
     * {@inheritdoc}
     */
    public function swapItems($firstIndex, $secondIndex)
    {
        $this->initializeRedis();
        $key = $this->getKeyForItemList();

        $options = array(
            'cas'   => true,
            'watch' => $key,
            'retry' => 3,
        );

        $this->redis->multiExec($options, function($tx) use ($key, $firstIndex, $secondIndex) {
            $firstItem = $tx->lindex($key, $firstIndex);
            $secondItem = $tx->lindex($key, $secondIndex);

            $tx->multi();
            $tx->lset($key, $firstIndex, $secondItem);
            $tx->lset($key, $secondIndex, $firstItem);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getItem($index)
    {
        $this->initializeRedis();
        $key = $this->getKeyForItemList();
        $item = $this->redis->lindex($key, $index);

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPosition()
    {
        $this->initializeRedis();

        if ($this->currentPosition === null) {
            $key = $this->getKeyForCurrentPosition();
            $this->currentPosition = $this->redis->get($key);
        }

        return $this->currentPosition;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentPosition($index)
    {
        $this->initializeRedis();

        $key = $this->getKeyForCurrentPosition();
        $this->redis->set($key, $index);
        $this->currentPosition = $index;
    }

    private function getKeyForItemList()
    {
        return sprintf('%s:%s:items', $this->key, $this->hash);
    }

    private function getKeyForCurrentPosition()
    {
        return sprintf('%s:%s:currentPosition', $this->key, $this->hash);
    }
}