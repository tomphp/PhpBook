<?php

interface Reader
{
    const STDIN = 'php://stdin';

    /** @return int */
    public function readInt($src = self::STDIN);
}
