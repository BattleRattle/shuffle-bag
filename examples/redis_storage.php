<?php

require __DIR__ . '/../vendor/autoload.php';

use BattleRattle\ShuffleBag\PersistentShuffleBag;
use BattleRattle\ShuffleBag\Storage\RedisStorage;
use Predis\Client;

$redisClient = new Client();
$storage = new RedisStorage($redisClient);
$bag = new PersistentShuffleBag($storage);

$bag->add('foo', 42);
$bag->add('bar', 1337);

$item = $bag->next();