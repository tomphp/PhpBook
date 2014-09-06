<?php

namespace PhpspecExample;

class GreatestCommonDivisor
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

    /** @return bool */
    private function divisorIsFactorOf($target)
    {
        return $target % $this->divisor == 0;
    }
}
