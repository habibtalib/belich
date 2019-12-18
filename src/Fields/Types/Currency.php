<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;

final class Currency extends Field
{
    /**
     * @var string
     */
    public $type = 'decimal';

    /**
     * @var string
     */
    public $subType = 'currency';

    /**
     * @var string
     */
    public $currency;

    /**
     * @var string
     */
    public $locale;

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
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
     *
     * @param string $value
     *
     * @return self
     */
    public function setLocale(string $value): self
    {
        $this->locale = $value;

        return $this;
    }

    /**
     * Set currency
     *
     * @param string $value
     *
     * @return self
     */
    public function currency(string $value): self
    {
        $this->currency = $value;

        return $this;
    }

    /**
     * Set currency to dollars
     *
     * @param string $value
     *
     * @return self
     */
    public function dollar(): self
    {
        $this->currency = 'USD';

        return $this;
    }

    /**
     * Set currency to euro
     *
     * @param string $value
     *
     * @return self
     */
    public function euro(): self
    {
        $this->currency = 'EUR';

        return $this;
    }

    /**
     * Set currency to GBP Pound
     *
     * @param string $value
     *
     * @return self
     */
    public function pound(): self
    {
        $this->currency = 'GBP';

        return $this;
    }

    /**
     * Set currency to Yen
     *
     * @param string $value
     *
     * @return self
     */
    public function yen(): self
    {
        $this->currency = 'JPY';

        return $this;
    }

    /**
     * Set currency to Yuan
     *
     * @param string $value
     *
     * @return self
     */
    public function yuan(): self
    {
        $this->currency = 'CNY';

        return $this;
    }

    /**
     * Configure locale
     *
     * @return self
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
