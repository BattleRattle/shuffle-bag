<?php

/**
 * This example shows how to pick a random item.
 */

require __DIR__ . '/../vendor/autoload.php';

use BattleRattle\ShuffleBag\ArrayShuffleBag;

// Item IDs with their probabilities to be used
$items = array(
    1 => 0.5,
    2 => 0.2,
    3 => 0.1,
    4 => 0.1,
    5 => 0.05,
    6 => 0.05,
);

$shuffleBag = new ArrayShuffleBag();

// Since we use decimal numbers with up to 2 decimal places, we will multiply the occurrences by 100.
foreach ($items as $itemId => $probability) {
    $shuffleBag->add($itemId, $probability * 100);
}

$randomItemId = $shuffleBag->next();
var_dump($randomItemId);