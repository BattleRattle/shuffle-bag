<?php

namespace BattleRattle\Tests\ShuffleBag;

use BattleRattle\ShuffleBag\ShuffleBag;

abstract class AbstractShuffleBagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShuffleBag
     */
    protected $bag;

    public function testAddNegativeAmount()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->bag->add('item', -5);
    }

    public function testPickOnEmptyBag()
    {
        $this->setExpectedException('LogicException');

        $this->bag->next();
    }

    public function testPickSingleItem()
    {
        $this->bag
            ->add('item 1', 1)
            ->add('item 2', 1)
            ->add('item 3', 1);

        $item = $this->bag->next();

        $this->assertTrue(in_array($item, array('item 1', 'item 2', 'item 3')), 'The picked item should be one of the added ones.');
    }

    /**
     * @dataProvider provideRuns
     */
    public function testItemDistribution($runs)
    {
        $this->bag
            ->add('item 1', 5)
            ->add('item 2', 10)
            ->add('item 3', 20);

        $actualItemCounts = array('item 1' => 0, 'item 2' => 0, 'item 3' => 0);
        for ($i = 0; $i < 35 * $runs; $i++) {
            $item = $this->bag->next();
            $actualItemCounts[$item]++;
        }

        $expectedCounts = array(
            'item 1' => 5 * $runs,
            'item 2' => 10 * $runs,
            'item 3' => 20 * $runs,
        );

        $this->assertEquals($expectedCounts, $actualItemCounts, 'The picked item counts should equal the targeted ones.');
    }

    public function provideRuns()
    {
        return array(
            array(1), // pick each item exactly once
            array(3), // pick each item exactly three times, requires the bag to be refilled
        );
    }
}
