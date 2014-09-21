<?php

namespace tests;

use Examples;
use Reader;

class MockExampleTest extends \PHPUnit_Framework_TestCase
{
    function test_dummy()
    {
        $examples = new Examples();

        $writer = $this->getMock('Writer');

        $this->assertEquals(5, $examples->addValues($writer, 2, 3));
    }

    function test_stub()
    {
        $examples = new Examples();

        $reader = $this->getMock('Reader');

        $reader->expects($this->any())
               ->method('readInt')
               ->will($this->returnValue(7));

        $this->assertEquals(14, $examples->doubleInput($reader));
    }

    function test_fake()
    {
        $examples = new Examples();

        $reader = $this->getMock('Reader');

        $reader->expects($this->at(0))
               ->method('readInt')
               ->with($this->equalTo(Reader::STDIN))
               ->will($this->returnValue(2));

        $reader->expects($this->at(1))
               ->method('readInt')
               ->with($this->equalTo('file.txt'))
               ->will($this->returnValue(5));

        $this->assertEquals(
            7,
            $examples->addFromInputAndFile($reader, 'file.txt')
        );
    }

    function test_expectation()
    {
        $examples = new Examples();

        $writer = $this->getMock('Writer');

        $writer->expects($this->once())
               ->method('write')
               ->with($this->equalTo('Adding 2 and 3'));

        $examples->addValues($writer, 2, 3);
    }
}
