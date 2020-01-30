<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;

final class Currency extends Field
{
    public string $type = 'decimal';
    public string $subType = 'currency';
    public string $currency;
    public string $locale;

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Cast the field as string
        $this->toString();

        //Resolve value for: index and show
        $this->displayUsing(function ($value) {
            // Configure locale
            $this->configureLocale();

            // Format the money
            return Helper::formatMoney($value, $this->currency, $this->locale);
        });
    }

    /**
     * Set locale
     */
    public function setLocale(string $value): self
    {
        $this->locale = $value;

        return $this;
    }

    /**
     * Set currency
     */
    public function currency(string $value): self
    {
        $this->currency = $value;

        return $this;
    }

    /**
     * Set currency to dollars
     */
    public function dollar(): self
    {
        $this->currency = 'USD';

        return $this;
    }

    /**
     * Set currency to euro
     */
    public function euro(): self
    {
        $this->currency = 'EUR';

        return $this;
    }

    /**
     * Set currency to GBP Pound
     */
    public function pound(): self
    {
        $this->currency = 'GBP';

        return $this;
    }

    /**
     * Set currency to Yen
     */
    public function yen(): self
    {
        $this->currency = 'JPY';

        return $this;
    }

    /**
     * Set currency to Yuan
     */
    public function yuan(): self
    {
        $this->currency = 'CNY';

        return $this;
    }

    /**
     * Configure locale
     */
    private function configureLocale()
    {
        if ($this->locale) {
            return setlocale(LC_MONETARY, $this->locale);
        }

        // Get browser language
        $browser = explode(',', request()->server('HTTP_ACCEPT_LANGUAGE'));
        $locale_LOC = str_replace('-', '_', $browser);

        $this->locale = setlocale(LC_MONETARY, $locale_LOC);
    }
}
