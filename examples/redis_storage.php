<?php

require __DIR__ . '/../vendor/autoload.php';

use BattleRattle\ShuffleBag\ShuffleBag;
use BattleRattle\ShuffleBag\Persistence\RedisStorage;
use Predis\Client;

$client = new Client();
$storage = new RedisStorage($client, 'player:12345:pickup-items');
$storage = new \BattleRattle\ShuffleBag\Persistence\ArrayStorage();
$bag = new ShuffleBag($storage);

$bag->add('item 1', 2);
$bag->add('item 2', 2);
$bag->add('item 3', 2);

$item = $bag->next();
var_dump($item);