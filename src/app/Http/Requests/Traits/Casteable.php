<?php

namespace Daguilarm\Belich\App\Http\Requests\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

// This trait is inspired by https://github.com/stahiralijan/request-caster/
trait Casteable
{
    /**
     * Called by validate() method, it maps all the methods used to perform the operations
     *
     * @return void
     */
    public function mapCasts(): void
    {
        if (!$this->request->has('cast')) {
            return;
        }
        foreach ($this->request->get('cast') as $value) {
            //Get cast and attribute
            list($cast, $attribute) = explode('|', $value);

            // Cast to Date
            if (Str::startsWith($cast, 'date:')) {
                $this->toDate($cast, $attribute);
            // Cast by method name
            } else {
                $this->toMethod($attribute, $cast);
            }
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     *
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $this->mapCasts();
        });
    }

    /**
     * Execute a cast method
     *
     * @param string $attribute
     * @param string $cast
     *
     * @return void
     */
    protected function toMethod(string $attribute, string $cast): void
    {
        //Get method
        $method = sprintf('to%s', ucfirst($cast));

        //Do the magic...
        if (method_exists($this, $method)) {
            $this->{$method}($attribute);
        }
    }

    /**
     * Converts the request field into boolean using simple casting (bool)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toBoolean(string $key): void
    {
        if (in_array(request($key), ['true', 'false', '1', '0', 1, 0])) {
            $this->request->set($key, (bool) request($key));
        }
    }

    /**
     * Converts the request field into data using Carbon (date)
     * Format: date|format
     *
     * @param string $key
     *
     * @return void
     */
    protected function toDate(string $cast, string $key): void
    {
        //Get the format
        $format = explode(':', $cast)[1];
        $date = Carbon::createFromFormat($format, request($key));

        $this->request->set($key, $date);
    }

    /**
     * Converts the request field into an integer using simple casting (int)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toInteger(string $key): void
    {
        $this->request->set($key, (int) request($key));
    }

    /**
     * Converts the request field into floating-point value using simple casting (float)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toFloat(string $key): void
    {
        $this->request->set($key, (float) request($key));
    }

    /**
     * Converts JSON to an associated array using jscon_decode (json)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toJson(string $key): void
    {
        $this->request->set($key, json_decode(request($key)));
    }

    /**
     * Converts the request field into an string using simple casting (string)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toString(string $key): void
    {
        $this->request->set($key, (string) request($key));
    }

    /**
     * Converts the request field into a Carbon object (year)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toYear(string $key): void
    {
        $this->request->set($key, Carbon::createFromFormat('Y', request($key))->year);
    }
}
