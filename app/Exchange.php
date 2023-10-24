<?php

namespace App;

use Carbon\Carbon;

class Exchange
{
    private string $timestamp;

    private Currencies $currencies;


    public function __construct(string $timestamp, array $currencies)
    {
        $this->timestamp = $timestamp;
        $this->currencies = new Currencies($currencies);
    }

    public function exchange(string $from, int $amount, string $to): int
    {
        $amountInBase = $amount / $this->getRate($from);
        return $this->getRate($to) * $amountInBase;
    }


    public function getRate(string $isoCode): float
    {
        return $this->currencies->get($isoCode)->getRate();
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return Carbon::createFromTimestamp($this->timestamp)->toDateTimeString();
    }

}