<?php

namespace tests;

final class SpyWriter implements \Writer
{
    private $message;

    public function write($message)
    {
        $this->message = $message;
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function hasWriteBeenCalledWith($message)
    {
        return $this->message == $message;
    }
}
