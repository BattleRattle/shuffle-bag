<?php

namespace BattleRattle\Tests\ShuffleBag;

use BattleRattle\ShuffleBag\ArrayShuffleBag;
use BattleRattle\ShuffleBag\NumberGenerator\AbstractNumberGenerator;

class ArrayShuffleBagTest extends AbstractShuffleBagTest
{
    public function setUp()
    {
        // Create a faked number generator in order to make sure, the tests won't succeed or fail randomly
        $numberGeneratorMock = $this->getMockBuilder('BattleRattle\\ShuffleBag\\NumberGenerator\\AbstractNumberGenerator')
            ->setMethods(array('next'))
            ->getMockForAbstractClass();

        $numberGeneratorMock->expects($this->any())
            ->method('next')
            ->will($this->returnValue(0));

        /** @var $numberGeneratorMock AbstractNumberGenerator */
        $this->bag = new ArrayShuffleBag($numberGeneratorMock);
    }
}
