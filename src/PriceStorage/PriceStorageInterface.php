<?php
namespace Store\PriceStorage;

use Store\VolumePrice;

interface PriceStorageInterface
{
    /**
     * Store prices by volume for code
     * @param string $code
     * @param VolumePrice ...$volumePrices
     */
    public function set(string $code, VolumePrice ...$volumePrices): void;

    /**
     * Return array of prices for item code
     * @param string $code
     * @return VolumePrice[]
     */
    public function get(string $code): array;

    /**
     * Clear all prices for selected code
     * @param string $code
     * @return mixed
     */
    public function delete(string $code);
}