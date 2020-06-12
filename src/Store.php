<?php
declare(strict_types=1);

namespace Store;

use Store\PriceStorage\PriceStorageInterface;

class Store
{
    protected PriceStorageInterface $priceStorage;

    /**
     * Store constructor.
     * @param PriceStorageInterface $priceStorage
     */
    public function __construct(PriceStorageInterface $priceStorage)
    {
        $this->priceStorage = $priceStorage;
    }

    /**
     * Create terminal
     * According test: something like order in real task
     * @return Terminal
     */
    public function createTerminal(): Terminal
    {
        return new Terminal($this);
    }

    /**
     * Configure prices
     * Proxy function to storage layer
     * @param string $code
     * @param VolumePrice ...$volumePrices
     * @return $this
     */
    public function setPrice(string $code, VolumePrice ...$volumePrices): self
    {
        $this->priceStorage->set($code, ...$volumePrices);
        return $this;
    }

    public function calculatePrice(string $code, int $volume): float
    {
        $itemPrices = $this->priceStorage->get($code);
        // order by decrease volume
        usort($itemPrices, fn(VolumePrice $a, VolumePrice $b) => $b->getVolume() - $a->getVolume());
        $price = 0;
        for ($i = 0; $volume > 0 && $i < count($itemPrices);) {
            $volumePrice = $itemPrices[$i];
            if ($volumePrice->getVolume() <= $volume) {
                $volume -= $volumePrice->getVolume();
                $price += $volumePrice->getPrice();
                continue; // calculate price by one loop
            }
            $i++;
        }
        return $price;
    }
}
