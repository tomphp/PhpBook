<?php

namespace tests;

use Reader;

final class FakeReader implements Reader
{
    public function readInt($src = self::STDIN)
    {
        return $src == self::STDIN ? 2 : 5;
    }
}
