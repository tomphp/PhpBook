<?php

namespace PhpspecExample;

class GreatestCommonDivisorFinder
{
    /** @var int */
    private $divisor;

    /**
     * @param int $a
     * @param int $b
     *
     * @return int
     */
    public function findGreatestDivisor($a, $b)
    {
        $this->divisor = min($a, $b);

        while (!$this->divisorIsFactorOf($a) || !$this->divisorIsFactorOf($b)) {
            $this->divisor--;
        }

        return $this->divisor;
    }

    /**
     * @param int $target
     *
     * @return bool
     */
    private function divisorIsFactorOf($target)
    {
        return $target % $this->divisor === 0;
    }
}
