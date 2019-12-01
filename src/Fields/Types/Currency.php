<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Currency extends Field
{
    /**
     * @var string
     */
    public $type = 'decimal';

    /**
     * @var string
     */
    public $format = '%i';

    /**
     * @var string
     */
    public $setLocale;

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

            //Set the label value
            return money_format($this->format, $value);
        });
    }

    /**
     * Set currency format
     *
     * @param string $value
     *
     * @return self
     */
    public function format(string $value): self
    {
        $this->format = $value;

        return $this;
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
        $this->setLocale = $value;

        return $this;
    }

    /**
     * Configure locale
     *
     * @return self
     */
    private function configureLocale()
    {
        if($this->setLocale) {
            return setlocale(LC_MONETARY, $this->setLocale);
        }
        // Get browser language
        $browser = explode(',', request()->server('HTTP_ACCEPT_LANGUAGE'));
        $locale = str_replace('-', '_', $browser);

        return  setlocale(LC_MONETARY, $locale);
    }
}
