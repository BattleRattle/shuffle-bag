Shuffle Bag
===========

Build status: [![Build Status](https://travis-ci.org/BattleRattle/shuffle-bag.png?branch=master)](https://travis-ci.org/BattleRattle/shuffle-bag)

Scrutinizer: [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/BattleRattle/shuffle-bag/badges/quality-score.png?s=962243106c95fc7d7a341ee562475194aaffe777)](https://scrutinizer-ci.com/g/BattleRattle/shuffle-bag/)

Packagist: [![Latest Stable Version](https://poser.pugx.org/battlerattle/shuffle-bag/v/stable.png)](https://packagist.org/packages/battlerattle/shuffle-bag)

This is a Shuffle Bag implementation, highly inspired by [this nice article](http://gamedev.tutsplus.com/tutorials/implementation/shuffle-bags-making-random-feel-more-random/) and its C# example.

What is a Shuffle Bag?
----------------------

A Shuffle Bag can be used for picking random items while reaching the targeted distribution after max. X picks, where X means the sum of all amounts the items were added.

The Shuffle Bag could be used in games in order to provide a certain amount of randomness while having the guarantee to keep the game balanced at the same time.

Installation
------------

The easiest way to install this library is to use [Composer](http://getcomposer.org/)
Add the package "battlerattle/shuffle-bag" to your composer.json

```json
{
    "require": {
        "battlerattle/shuffle-bag": "v1.0-beta"
    }
}
```

Example
-------

Imagine you want 3 different items to be picked with a probability of 10%, 30% and 60%. Add those items 1, 3 and 6 times to your bag and after 10 picks you got the targeted distribution.
Add those items 10, 30 and 60 times in order to get a better randomness, because you could get the first item 10 times in row by random, but after max. 100 picks, you reached the target distribution again.

Usage
-----

Here we implement the example as described above:

```php
use BattleRattle\ShuffleBag\ArrayShuffleBag;

$bag = new ArrayShuffleBag();

// add your items with a certain probability
$bag->add('item 1', 1);
$bag->add('item 2', 3);
$bag->add('item 3', 6);

// pick a random item
$item = $bag->next();
```

In order to use the same bag over multiple requests, you need to store the bag in a persistent storage.
Here we use the PersistentShuffleBag with Redis ([Predis](https://github.com/nrk/predis)) as storage:

```php
use BattleRattle\ShuffleBag\PersistentShuffleBag;
use BattleRattle\ShuffleBag\Storage\RedisStorage;
use Predis\Client;

$redisClient = new Client();
$storage = new RedisStorage($redisClient);
$bag = new PersistentShuffleBag($storage);

$bag->add('foo', 42);
$bag->add('bar', 1337);

$item = $bag->next();
```