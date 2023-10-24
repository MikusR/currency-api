<?php

namespace App;

use Carbon\Carbon;

class Exchange
{
    private string $timestamp;
    /**
     * @var Currency[]
     */
    private array $listOfCurrency;


    public function __construct(string $timestamp, array $listOfCurrency)
    {
        $this->timestamp = $timestamp;
        $this->listOfCurrency = $listOfCurrency;
    }

    public function exchange(string $from, int $amount, string $to): int
    {
        $amountInBase = $amount / $this->getRate($from);
        return $this->getRate($to) * $amountInBase;
    }


    public function getRate(string $isoCode): float
    {
        return $this->listOfCurrency[$isoCode]->getRate();
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return Carbon::createFromTimestamp($this->timestamp)->toDateTimeString();
    }

}