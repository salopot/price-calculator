<?php
declare(strict_types=1);

namespace Store;

use LogicException;

class VolumePrice
{
    protected float $price;
    protected int $volume;

    /**
     * VolumePrice constructor.
     * @param float $price
     * @param int $volume
     */
    public function __construct(float $price, int $volume = 1)
    {
        if ($volume < 1) {
            throw new LogicException('Volume must be positive value');
        }
        $this->price = $price;
        $this->volume = $volume;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume;
    }
}
