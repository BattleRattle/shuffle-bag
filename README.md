Shuffle Bag
===========

This is a Shuffle Bag implementation, highly inspired by [this nice article](http://gamedev.tutsplus.com/tutorials/implementation/shuffle-bags-making-random-feel-more-random/) and its C# example.

What is a Shuffle Bag?
----------------------

A Shuffle Bag can be used for picking random items while reaching the targeted distribution after max. X picks, where X means the sum of all amounts the items were added.

The Shuffle Bag could be used in games in order to provide a certain amount randomness while having the guarantee to keep the game balanced at the same time.

E.g. you want 3 different items to be picked with a probability of 10%, 30% and 60%. Add those items 1, 3 and 6 times to your bag and after 10 picks you got the targeted distribution.
Add those items 10, 30 and 60 times in order to get a better randomness, because you could get the first item 10 times in row by random, but after max. 100 picks, you reached the target distribution again.

Usage
-----

use BattleRattle\ShuffleBag\ShuffleBag;

$bag = new ShuffleBag();

// add your items with a certain probability
$bag->add('item 1', 1);
$bag->add('item 2', 3);
$bag->add('item 3', 6);

// pick a random item
$item = $bag->next();