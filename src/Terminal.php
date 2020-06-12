<?php
declare(strict_types=1);

namespace Store;

class Terminal
{
    protected Store $store;

    /** @var array<string, int> */
    protected array $itemsVolume;

    /**
     * Terminal constructor.
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
        $this->itemsVolume = [];
    }

    /**
     * @param string $code
     * @return $this
     */
    public function scanItem(string $code): self
    {
        if (!isset($this->itemsVolume[$code])) {
            $this->itemsVolume[$code] = 1;
        } else {
            $this->itemsVolume[$code]++;
        }
        return $this;
    }

    /**
     * Calculate total price for stored items
     * @return float
     */
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->itemsVolume as $code => $volume) {
            $total += $this->store->calculatePrice($code, $volume);
        }
        return $total;
    }
}
