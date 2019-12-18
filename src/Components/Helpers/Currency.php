<?php

namespace Daguilarm\Belich\Components\Helpers;

use Money\Currencies\ISOCurrencies;
use Money\Currency as MoneyCurrency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

trait Currency
{
    /**
     * Format the money
     *
     * @param string $value
     * @param string $currency
     * @param string $locale
     *
     * @return self
     */
    public function formatMoney($value, $currency, $locale): string
    {
        //Configure the currency
        $money = new Money($value * 100, new MoneyCurrency($currency));

        //Format
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($money);
    }
}
