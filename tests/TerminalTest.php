<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Store\Store;
use Store\PriceStorage\MemoryStorage;
use Store\Terminal;
use Store\VolumePrice;

class TerminalTest extends TestCase
{
    public function getTotalProvider()
    {
        $store = new Store(new MemoryStorage());
        $store->setPrice(
            'ZA',
            new VolumePrice(2.0),
            new VolumePrice(7.0, 4),
        )->setPrice(
            'YB',
            new VolumePrice(12.0),
        )->setPrice(
            'FC',
            new VolumePrice(1.25),
            new VolumePrice(6, 6),
        )->setPrice(
            'GD',
            new VolumePrice(0.15),
        );
        return [
            [$store->createTerminal(), ['ZA', 'YB', 'FC', 'GD', 'ZA', 'YB', 'ZA', 'ZA'], 32.40],
            [$store->createTerminal(), ['FC', 'FC', 'FC', 'FC', 'FC', 'FC', 'FC'], 7.25],
            [$store->createTerminal(), ['ZA', 'YB', 'FC', 'GD'], 15.40],
        ];
    }

    /**
     * @dataProvider getTotalProvider
     */
    public function testGetTotalCase1(Terminal $terminal, array $codes, float $total)
    {
        foreach ($codes as $code) {
            $terminal->scanItem($code);
        }
        $this->assertSame($terminal->getTotal(), $total);
    }
}
