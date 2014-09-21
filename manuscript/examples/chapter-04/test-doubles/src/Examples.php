<?php

final class Examples
{
    /**
     * @param number $a
     * @param number $b
     *
     * @return number
     */
    public function addValues(Writer $writer, $a, $b)
    {
        $writer->write("Adding $a and $b");

        return $a + $b;
    }

    /** @return int */
    public function doubleInput(Reader $reader)
    {
        return $reader->readInt() * 2;
    }

    /** @return int */
    public function addFromInputAndFile(Reader $reader, $filename)
    {
        return $reader->readInt(Reader::STDIN) + $reader->readInt($filename);
    }
}
