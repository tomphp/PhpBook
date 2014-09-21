<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Reader;
use Writer;

class ExamplesSpec extends ObjectBehavior
{
    function it_uses_mock_as_dummy(Writer $writer)
    {
        $this->addValues($writer, 2, 3)->shouldReturn(5);
    }

    function it_uses_mock_as_stub(Reader $reader)
    {
        $reader->readInt()->willReturn(7);

        $this->doubleInput($reader)->shouldReturn(14);
    }

    function it_uses_mock_as_fake(Reader $reader)
    {
        $reader->readInt(Reader::STDIN)->willReturn(2);
        $reader->readInt('file.txt')->willReturn(5);

        $this->addFromInputAndFile($reader, 'file.txt')->shouldReturn(7);
    }

    function it_uses_mock_as_spy(Writer $writer)
    {
        $this->addValues($writer, 2, 3);

        $writer->write('Adding 2 and 3')->shouldHaveBeenCalled();
    }

    function it_can_set_expectations_on_mocks(Writer $writer)
    {
        $writer->write('Adding 2 and 3')->shouldBeCalled();

        $this->addValues($writer, 2, 3);
    }
}
