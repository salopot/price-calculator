<?php
declare(strict_types=1);

namespace Store\PriceStorage;

use Store\VolumePrice;
use RuntimeException;

class MemoryStorage implements PriceStorageInterface
{
    protected array $storage;

    /**
     * MemoryStorage constructor.
     */
    public function __construct()
    {
        $this->storage = [];
    }

    protected function checkCode(string $code)
    {
        if (!isset($this->storage[$code])) {
            throw new RuntimeException("No prices for code {$code}");
        }
    }

    /**
     * @inheritDoc
     */
    public function set(string $code, VolumePrice ...$volumePrices): void
    {
        $this->storage[$code] = $volumePrices;
    }

    /**
     * @inheritDoc
     */
    public function get(string $code): array
    {
        $this->checkCode($code);
        return $this->storage[$code];
    }

    /**
     * @inheritDoc
     */
    public function delete(string $code)
    {
        $this->checkCode($code);
        unset($this->storage[$code]);
    }
}
