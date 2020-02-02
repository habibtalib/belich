<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

use Money\Currencies\ISOCurrencies;
use Money\Currency as MoneyCurrency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

trait Currency
{
    /**
     * Format the money
     */
    public function formatMoney(string $value, string $currency, string $locale): string
    {
        //Configure the currency
        $money = new Money($value * 100, new MoneyCurrency($currency));

        //Format
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($money);
    }
}
