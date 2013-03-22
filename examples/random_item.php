<?php

/**
 * This example shows how to pick a random item.
 */

require __DIR__ . '/../vendor/autoload.php';

// Item IDs with their probabilites to be chosen
$items = array(
    1 => 0.5,
    2 => 0.2,
    3 => 0.1,
    4 => 0.1,
    5 => 0.05,
    6 => 0.05,
);

$shuffleBag = new \BattleRattle\ShuffleBag\ShuffleBag();

// Since we use decimal numbers with 2 decimal places, we will multiply the occurrences by 100.
foreach ($items as $itemId => $probability) {
    $shuffleBag->add($itemId, $probability * 100);
}

//$randomItemId = $shuffleBag->next();
//var_dump($randomItemId);

$stats = array(
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0
);

for ($i = 0; $i < 1000; $i++) {
    $stats[$shuffleBag->next()]++;
}

foreach ($stats as $id => $count) {
    echo sprintf('%d: %5d', $id, $count) . PHP_EOL;
}