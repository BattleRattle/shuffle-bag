<?php

require __DIR__ . '/../vendor/autoload.php';

use BattleRattle\ShuffleBag\ShuffleBag;
use BattleRattle\ShuffleBag\Persistence\RedisStorage;
use Predis\Client;

$client = new Client();
$storage = new RedisStorage($client, 'player:123:pickup-items');
$bag = new ShuffleBag($storage);

$bag->add('item 1', 1);
$bag->add('item 2', 5);
$bag->add('item 3', 10);

$item = $bag->next();
var_dump($item);