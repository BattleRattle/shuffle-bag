<?php

namespace BattleRattle\Tests\ShuffleBag\Persistence;

use BattleRattle\ShuffleBag\Storage\RedisStorage;
use Predis\Client;
use Predis\Connection\ConnectionException;

class RedisStorageTest extends AbstractStorageTest
{
    public function setUp()
    {
        if (!class_exists('Predis\\Client')) {
            $this->markTestSkipped('The ' . __CLASS__ . ' requires Predis to be available');
        }

        try {
            $client = new Client();
            $client->connect();
            $client->flushdb();
        } catch (ConnectionException $e) {
            $this->markTestSkipped('The ' . __CLASS__ . ' requires the use of a Redis Server');
        }

        $this->storage = new RedisStorage($client);
    }
}
