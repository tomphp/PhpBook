<?php

namespace tests;

use Reader;

final class StubReader implements Reader
{
    public function readInt($src = self::STDIN)
    {
        return 7;
    }
}
