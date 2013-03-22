<?php

namespace BattleRattle\Tests\ShuffleBag;

use BattleRattle\ShuffleBag\ShuffleBag;

class ShuffleBagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShuffleBag
     */
    private $bag;

    public function setUp()
    {
        // Create a faked number generator in order to make sure, the tests won't succeed or fail randomly
        $numberGeneratorMock = $this->getMockBuilder('BattleRattle\\ShuffleBag\\NumberGenerator\\AbstractNumberGenerator')
            ->setMethods(array('next'))
            ->getMockForAbstractClass();

        $numberGeneratorMock->expects($this->any())
            ->method('next')
            ->will($this->returnValue(0));

        $this->bag = new ShuffleBag($numberGeneratorMock);
    }

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
        $this->bag->add('item 1', 1);
        $this->bag->add('item 2', 1);
        $this->bag->add('item 3', 1);

        $item = $this->bag->next();

        $this->assertTrue(in_array($item, array('item 1', 'item 2', 'item 3')), 'The picked item should be one of the added ones.');
    }

    public function testItemDistribution()
    {
        $this->bag->add('item 1', 5);
        $this->bag->add('item 2', 10);
        $this->bag->add('item 3', 20);

        $actualItemCounts = array('item 1' => 0, 'item 2' => 0, 'item 3' => 0);
        for ($i = 0; $i < 35; $i++) {
            $item = $this->bag->next();
            $actualItemCounts[$item]++;
        }

        $expectedCounts = array(
            'item 1' => 5,
            'item 2' => 10,
            'item 3' => 20
        );

        $this->assertEquals($expectedCounts, $actualItemCounts, 'The picked item counts should equal the targeted ones.');
    }
}
