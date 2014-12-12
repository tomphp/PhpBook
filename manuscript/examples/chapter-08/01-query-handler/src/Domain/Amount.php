<?php

namespace CocktailRater\Domain;

final class Amount
{
    /** @var float */
    private $value;

    /** @var Unit */
    private $unit;

    /**
     * @param float  $value
     * @oaram string $unit
     *
     * @return Amount
     */
    public static function fromValues($value, $unit)
    {
        return new self($value, new Unit($unit));
    }

    /** @param float $value */
    public function __construct($value, Unit $unit)
    {
        $this->value = $value;
        $this->unit  = $unit;
    }

    /** @return float */
    public function getValue()
    {
        return $this->value;
    }

    /** @return string */
    public function getUnit()
    {
        return $this->unit->getValue();
    }
}
