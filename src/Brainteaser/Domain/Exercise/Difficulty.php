<?php
namespace Brainteaser\Domain\Exercise;


class Difficulty
{
    const MIN_VALUE = 1;
    const MAX_VALUE = 12;

    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        if ($value < self::MIN_VALUE || $value > self::MAX_VALUE) {
            throw new \InvalidArgumentException('Difficulty value');
        }
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Difficulty
     */
    public function decrease() : Difficulty
    {
        $value = max($this->value-1, self::MIN_VALUE);
        return new self($value);
    }

    /**
     * @return Difficulty
     */
    public function increase() : Difficulty
    {
        $value = min($this->value+1, self::MAX_VALUE);
        return new self($value);
    }
}