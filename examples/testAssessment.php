<?php
require_once 'vendor/autoload.php';

use Store\Store;
use Store\PriceStorage\MemoryStorage;
use Store\VolumePrice;

// Price price facade
$store = new Store(new MemoryStorage());

// Configure prices
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

// Calculate totals
$total = $store->createTerminal()
    ->scanItem('ZA')
    ->scanItem('YB')
    ->scanItem('FC')
    ->scanItem('GD')
    ->scanItem('ZA')
    ->scanItem('YB')
    ->scanItem('ZA')
    ->scanItem('ZA')
    ->getTotal();
echo 1, '> ', $total, PHP_EOL;

$total = $store->createTerminal()
    ->scanItem('FC')
    ->scanItem('FC')
    ->scanItem('FC')
    ->scanItem('FC')
    ->scanItem('FC')
    ->scanItem('FC')
    ->scanItem('FC')
    ->getTotal();
echo 7, '> ', $total, PHP_EOL;

$total = $store->createTerminal()
    ->scanItem('ZA')
    ->scanItem('YB')
    ->scanItem('FC')
    ->scanItem('GD')
    ->getTotal();
echo 8, '> ', $total, PHP_EOL;
