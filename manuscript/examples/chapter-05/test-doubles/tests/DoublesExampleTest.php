<?php

namespace tests;

use Examples;

class DoublesExampleTest extends \PHPUnit_Framework_TestCase
{
    function test_dummy()
    {
        $writer = new DummyWriter();
        $examples = new Examples();

        $this->assertEquals(5, $examples->addValues($writer, 2, 3));
    }

    function test_stub()
    {
        $reader = new StubReader();
        $examples = new Examples();

        $this->assertEquals(14, $examples->doubleInput($reader));
    }

    function test_fake()
    {
        $reader = new FakeReader();
        $examples = new Examples();

        $this->assertEquals(
            7,
            $examples->addFromInputAndFile($reader, 'file.txt')
        );
    }

    function test_spy()
    {
        $writer = new SpyWriter();
        $examples = new Examples();

        $examples->addValues($writer, 2, 3);

        $this->assertTrue(
            $writer->hasWriteBeenCalledWith('Adding 2 and 3'),
            '$writer->write("Adding 2 and 3") should have been called'
        );
    }
}
